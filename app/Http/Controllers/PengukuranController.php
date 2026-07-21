<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ML\ContentClassification;
use App\Models\ML\ScrapedContent;
use App\Models\Modul;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class PengukuranController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Intro / info pages
    // ─────────────────────────────────────────────────────────────────────────

    public function show()
    {
        $categories = Category::with('translation')
            ->withCount('questions')
            ->get();

        return view('pengukuran.index', [
            'categories'      => $categories,
            'totalQuestions'  => $categories->sum('questions_count'),
            'totalCategories' => $categories->count(),
        ]);
    }

    public function infoLikert()
    {
        session()->forget(['pengukuran_likert_answers', 'pengukuran_mc_answers']);

        $categories = Category::with('translation')->withCount('questions')->get();
        return view('pengukuran.info-likert', compact('categories'));
    }

    /**
     * Store user consent and redirect to likert info.
     */
    public function startWithConsent(Request $request)
    {
        $request->validate([
            'consent' => 'accepted',
        ]);

        $user = auth()->user();
        if ($user) {
            $user->consent_given_at = now();
            $user->save();
        }

        return redirect()->route('pengukuran.info.likert')->with('success', 'Persetujuan tersimpan. Anda dapat memulai asesmen.');
    }

    public function infoPilihanGanda()
    {
        if (!session('pengukuran_likert_completed')) {
            return redirect()->route('pengukuran.info.likert');
        }

        $categories = Category::with('translation')->withCount('questions')->get();
        return view('pengukuran.info-pilihan-ganda', compact('categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Legacy combined questionnaire (index / store)
    // ─────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $categories = Category::with([
            'translation',
            'questions.translation',
            'questions.answers.translation',
            'questions.answerTemplate.translation',
            'questions.answerTemplate.defaultAnswers.translation',
        ])->paginate(1);

        $stored = session('pengukuran_answers', []);
        return view('pengukuran.kuesioner', compact('categories', 'stored'));
    }

    public function store(Request $request)
    {
        $stored = session('pengukuran_answers', []);

        foreach ($request->input('answers', []) as $val) {
            $parts      = explode(':', $val);
            $questionId = $parts[0];
            $stored[$questionId] = $val;
        }
        session(['pengukuran_answers' => $stored]);

        if ($request->input('action') === 'next') {
            return redirect()->route('pengukuran.show', ['page' => $request->query('page', 1) + 1]);
        }
        if ($request->input('action') === 'back') {
            return redirect()->route('pengukuran.show', ['page' => max(1, $request->query('page', 1) - 1)]);
        }

        if ($request->input('action') === 'submit') {
            $allAnswers = session('pengukuran_answers', []);
            $this->persistAnswers($allAnswers);
            session()->forget('pengukuran_answers');
            return redirect()->route('pengukuran.hasil')->with('success', 'Kuesioner berhasil disimpan!');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Likert questionnaire
    // ─────────────────────────────────────────────────────────────────────────

    public function kuesionerLikert(Request $request)
    {
        $page = (int) $request->query('page', 1);

        $categories = $this->getCategoriesWithType('likert');
        $totalPages = $categories->count();
        $page       = max(1, min($page, $totalPages));

        $currentCategory = $categories->values()->get($page - 1);
        if (!$currentCategory) {
            return redirect()->route('pengukuran.info.likert');
        }

        return view('pengukuran.kuesioner-likert', [
            'currentCategory' => $currentCategory,
            'currentPage'     => $page,
            'totalPages'      => $totalPages,
            'stored'          => session('pengukuran_likert_answers', []),
        ]);
    }

    public function storeLikert(Request $request)
    {
        $page   = (int) $request->query('page', 1);
        $stored = session('pengukuran_likert_answers', []);

        foreach ($request->input('answers', []) as $questionId => $val) {
            $stored[$questionId] = $val;
        }
        session(['pengukuran_likert_answers' => $stored]);

        $totalPages = $this->getCategoriesWithType('likert')->count();

        if ($request->input('action') === 'next') {
            return redirect()->route('pengukuran.kuesioner.likert', ['page' => min($page + 1, $totalPages)]);
        }
        if ($request->input('action') === 'back') {
            return redirect()->route('pengukuran.kuesioner.likert', ['page' => max(1, $page - 1)]);
        }
        if ($request->input('action') === 'finish_likert') {
            session(['pengukuran_likert_completed' => true]);
            return redirect()->route('pengukuran.info.pilihan_ganda');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Multiple choice questionnaire
    // ─────────────────────────────────────────────────────────────────────────

    public function kuesionerPilihanGanda(Request $request)
    {
        $page = (int) $request->query('page', 1);

        $categories = $this->getCategoriesWithType('multiple_choice');
        $totalPages = $categories->count();
        $page       = max(1, min($page, $totalPages));

        $currentCategory = $categories->values()->get($page - 1);
        if (!$currentCategory) {
            return redirect()->route('pengukuran.info.pilihan_ganda');
        }

        return view('pengukuran.kuesioner-pilihan-ganda', [
            'currentCategory' => $currentCategory,
            'currentPage'     => $page,
            'totalPages'      => $totalPages,
            'stored'          => session('pengukuran_mc_answers', []),
        ]);
    }

    public function storePilihanGanda(Request $request)
    {
        $page   = (int) $request->query('page', 1);
        $stored = session('pengukuran_mc_answers', []);

        foreach ($request->input('answers', []) as $questionId => $val) {
            $stored[$questionId] = $val;
        }
        session(['pengukuran_mc_answers' => $stored]);

        $totalPages = $this->getCategoriesWithType('multiple_choice')->count();

        if ($request->input('action') === 'next') {
            return redirect()->route('pengukuran.kuesioner.multiple_choice', ['page' => min($page + 1, $totalPages)]);
        }
        if ($request->input('action') === 'back') {
            return redirect()->route('pengukuran.kuesioner.multiple_choice', ['page' => max(1, $page - 1)]);
        }

        if ($request->input('action') === 'submit') {
            $allAnswers = array_merge(
                session('pengukuran_likert_answers', []),
                session('pengukuran_mc_answers', [])
            );

            $this->persistAnswers($allAnswers);
            session()->forget(['pengukuran_likert_answers', 'pengukuran_mc_answers', 'pengukuran_likert_completed']);

            return redirect()->route('pengukuran.hasil')->with('success', 'Kuesioner berhasil disimpan!');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Hasil / Result - SPLIT PERSEPSI & AKTUAL
    // ─────────────────────────────────────────────────────────────────────────

    public function hasil(Request $request)
    {
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('pengukuran.index');
        }

        $lastTestDate = UserAnswer::where('user_id', $userId)
            ->latest('attempt_id')
            ->value('attempt_id');

        $userAnswers = UserAnswer::where('user_id', $userId)
            ->where('attempt_id', $lastTestDate)
            ->with([
                'question.category.translation',
                'question.answerTemplate.defaultAnswers',
            ])
            ->get();

        if ($userAnswers->isEmpty()) {
            return redirect()->route('pengukuran.index');
        }

        // ══════════════════════════════════════════════════════════════════════
        // SPLIT: LIKERT (PERSEPSI) vs MC (AKTUAL KOMPETENSI)
        // ══════════════════════════════════════════════════════════════════════

        // --- LIKERT: HASIL PERSEPSI ---
        $likertScores = [];
        $maxLikertScore = [];

        // --- MC: HASIL AKTUAL KOMPETENSI ---
        $mcScores = [];
        $mcMaxScores = [];

        $categoryNames = [];

        foreach ($userAnswers as $ua) {

            $question = $ua->question;

            if (!$question) {
                continue;
            }

            $catId = $question->id_kategori;
            $bobot = (float) $ua->answer_bobot;

            if (!isset($categoryNames[$catId])) {
                $categoryNames[$catId] =
                    optional($question->category->translation)->name
                    ?? 'Unknown';
            }

            // PERSEPSI: Likert scores per kategori
            if ($question->type === 'likert') {

                $maxAnswerBobot = 5;

                if (
                    $question->answerTemplate &&
                    $question->answerTemplate->defaultAnswers->isNotEmpty()
                ) {
                    $maxAnswerBobot = (int)
                    $question->answerTemplate
                        ->defaultAnswers
                        ->max('bobot');
                }

                $likertScores[$catId] =
                    ($likertScores[$catId] ?? 0) + $bobot;

                $maxLikertScore[$catId] =
                    ($maxLikertScore[$catId] ?? 0) + $maxAnswerBobot;
            }
            // AKTUAL: MC scores per kategori
            elseif ($question->type === 'multiple_choice') {

                $mcScores[$catId] =
                    ($mcScores[$catId] ?? 0) + $bobot;

                $mcMaxScores[$catId] =
                    ($mcMaxScores[$catId] ?? 0) + (int) $question->bobot;
            }
        }

        // ══════════════════════════════════════════════════════════════════════
        // HITUNG PERSENTASE: PERSEPSI (LIKERT) vs AKTUAL (MC)
        // ══════════════════════════════════════════════════════════════════════

        $categoryPercents = [];
        $categoryStatus = [];
        $categoryLikertPercents = [];
        $categoryMcPercents = [];

        $allCatIds = array_unique(
            array_merge(
                array_keys($likertScores),
                array_keys($mcScores)
            )
        );

        foreach ($allCatIds as $catId) {

            // ─── PERSEPSI (LIKERT) ───
            $likertTotal = $likertScores[$catId] ?? 0;
            $likertMax = $maxLikertScore[$catId] ?? 0;

            if ($likertMax <= 0) {
                $categoryLikertPercents[$catId] = 0;
            } else {
                $categoryLikertPercents[$catId] = round(
                    min(100, ($likertTotal / $likertMax) * 100),
                    2
                );
            }

            // ─── AKTUAL KOMPETENSI (MC) ───
            $mcTotal = $mcScores[$catId] ?? 0;
            $mcMax = $mcMaxScores[$catId] ?? 0;

            if ($mcMax <= 0) {
                $categoryMcPercents[$catId] = 0;
            } else {
                $categoryMcPercents[$catId] = round(
                    min(100, ($mcTotal / $mcMax) * 100),
                    2
                );
            }

            // ─── STATUS BERDASARKAN AKTUAL (MC) SAJA ───
            // Rekomendasi modul hanya berdasarkan MC
            $mcPercent = $categoryMcPercents[$catId];

            $categoryStatus[$catId] = match (true) {
                $mcPercent > 90  => __('assessment.excellent'),
                $mcPercent >= 81 => __('assessment.very_good'),
                $mcPercent >= 65 => __('assessment.satisfiable'),
                default          => __('assessment.need_improvement'),
            };

            // ─── COMBINED (untuk backward compatibility) ───
            $combinedTotal = $likertTotal + $mcTotal;
            $combinedMax = $likertMax + $mcMax;

            if ($combinedMax <= 0) {
                $categoryPercents[$catId] = 0;
            } else {
                $categoryPercents[$catId] = round(
                    min(100, ($combinedTotal / $combinedMax) * 100),
                    2
                );
            }
        }

        // ══════════════════════════════════════════════════════════════════════
        // OVERALL SCORE: SPLIT PERSEPSI vs AKTUAL
        // ══════════════════════════════════════════════════════════════════════

        $totalLikertObtained = array_sum($likertScores);
        $totalLikertMax = array_sum($maxLikertScore);
        $overallLikertScore = $totalLikertMax > 0
            ? (int) round(($totalLikertObtained / $totalLikertMax) * 100)
            : 0;

        $totalMcObtained = array_sum($mcScores);
        $totalMcMax = array_sum($mcMaxScores);
        $overallMcScore = $totalMcMax > 0
            ? (int) round(($totalMcObtained / $totalMcMax) * 100)
            : 0;

        // ─── INSTRUMENT SCORE BERDASARKAN AKTUAL (MC) ───
        $instrumentScore = match (true) {
            $overallMcScore > 90  => __('assessment.excellent'),
            $overallMcScore >= 81 => __('assessment.very_good'),
            $overallMcScore >= 65 => __('assessment.satisfiable'),
            default               => __('assessment.need_improvement'),
        };

        // ══════════════════════════════════════════════════════════════════════
        // REKOMENDASI MODUL: HANYA JIKA MC < 70%
        // ══════════════════════════════════════════════════════════════════════

        $THRESHOLD = 70;  // Threshold untuk rekomendasi

        $recommendedCategories = [];

        foreach ($categoryMcPercents as $catId => $mcPercent) {

            // TRIGGER REKOMENDASI HANYA JIKA MC < 70%
            if ($mcPercent < $THRESHOLD) {

                $category = Category::with('translation')
                    ->find($catId);

                $moduls = Modul::with([
                    'translation',
                    'category.translation',
                ])
                    ->where('id_kategori', $catId)
                    ->get();

                $recommendedCategories[$catId] = [
                    'category' => $category->translation ?? $category,
                    'percept_percent' => $categoryLikertPercents[$catId] ?? 0,  // Persepsi
                    'actual_percent' => $mcPercent,                            // Aktual
                    'moduls' => $moduls,
                ];
            }
        }

        // ─────────────────────────────────────────────
        // Mapping kategori -> dimensi pembelajaran
        // ─────────────────────────────────────────────
        $dimensions = [];

        $dimensions = collect($recommendedCategories)
            ->map(function ($item) {

                return $item['category']
                    ->dimension?->name;
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // ─────────────────────────────────────────────
        // Ambil hasil scraping
        // ─────────────────────────────────────────────
        $recommendedContents = ScrapedContent::with('classification')
            ->when(
                !empty($dimensions),
                function ($query) use ($dimensions) {

                    $query->whereHas(
                        'classification',
                        function ($q) use ($dimensions) {
                            $q->whereIn('dimension', $dimensions);
                        }
                    );
                }
            )
            ->latest()
            ->take(15)
            ->get();

        // Jika tidak ada mapping ditemukan,
        // tampilkan semua konten terbaru
        if ($recommendedContents->isEmpty()) {

            $recommendedContents = ScrapedContent::with(
                'classification.dimension.category.translation'
            )
                ->latest()
                ->take(15)
                ->get();
        }

        // ─────────────────────────────────────────────
        // Sorting
        // ─────────────────────────────────────────────
        ksort($categoryNames);
        ksort($categoryPercents);
        ksort($categoryStatus);
        ksort($categoryLikertPercents);
        ksort($categoryMcPercents);
        ksort($recommendedCategories);

        return view('pengukuran.hasil', [
            // Kategori names & status
            'categoryNames' => $categoryNames,
            'categoryPercents' => $categoryPercents,
            'categoryStatus' => $categoryStatus,

            // SPLIT: Persepsi vs Aktual per kategori
            'categoryLikertPercents' => $categoryLikertPercents,  // Persepsi
            'categoryMcPercents' => $categoryMcPercents,          // Aktual Kompetensi

            // Overall scores SPLIT
            'overallLikertScore' => $overallLikertScore,        // Persepsi overall
            'overallMcScore' => $overallMcScore,                // Aktual overall

            // Untuk backward compatibility
            'overallScore' => $overallMcScore,  // Default ke MC (aktual)
            'instrumentScore' => $instrumentScore,

            // Rekomendasi (hanya jika MC < 70%)
            'recommendedCategories' => $recommendedCategories,
            'recommendedContents' => $recommendedContents,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Simpan semua jawaban dari session ke tabel user_answers.
     * Format value: "questionId:bobot"
     * Untuk MC: bobot = question->bobot jika benar, 0 jika salah
     *           (sudah di-encode di view kuesioner-pilihan-ganda)
     * Untuk Likert: bobot = nilai skala yang dipilih (1-5)
     */
    private function persistAnswers(array $allAnswers): void
    {
        $userId = auth()->id();

        $attempt = UserAnswer::where('user_id', $userId)->latest()->first();

        foreach ($allAnswers as $questionId => $answerValue) {
            $parts = explode(':', $answerValue);
            $nilai = end($parts);
            $answerId = null;

            if ($parts[2] === 'multiple_choice') {
                $answerId = $parts[1] ?? null;
            }

            UserAnswer::create([
                'user_id'      => $userId,
                'attempt_id'   => $attempt ? $attempt->attempt_id + 1 : 1,
                'question_id'  => (int) $parts[0],
                'answer_bobot' => (float) $nilai,
                'answer_id'    => $answerId,
            ]);
        }
    }

    /**
     * Ambil kategori berikut soal-soal berdasarkan tipe tertentu.
     */
    private function getCategoriesWithType(string $type)
    {
        $categories = Category::with([
            'translation',
            'questions' => fn($q) => $q->where('type', $type),
            'questions.translation',
            'questions.answers.translation',
            'questions.answerTemplate.translation',
            'questions.answerTemplate.defaultAnswers.translation',
        ])->get();

        return $categories->filter(fn($cat) => $cat->questions->count() > 0);
    }
}
