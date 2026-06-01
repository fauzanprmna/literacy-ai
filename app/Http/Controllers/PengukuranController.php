<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
    // Hasil / Result
    // ─────────────────────────────────────────────────────────────────────────

    public function hasil(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->route('pengukuran.index');
        }

        $userAnswers = UserAnswer::where('user_id', $userId)
            ->with([
                'question.category.translation',
                'question.answerTemplate.defaultAnswers',
            ])
            ->get();

        if ($userAnswers->isEmpty()) {
            return redirect()->route('pengukuran.index');
        }

        // ── Akumulasi skor per kategori, pisahkan likert vs MC ────────────────
        $likertScores   = [];   // total bobot per catId
        $maxLikertScore = [];   // max possible bobot per catId
        $mcScores       = [];   // total bobot per catId (sudah 0 atau question->bobot)
        $mcMaxScores    = [];   // max possible bobot per catId
        $categoryNames  = [];

        foreach ($userAnswers as $ua) {
            $question = $ua->question;
            if (!$question) continue;

            $catId = $question->id_kategori;
            $bobot = (float) $ua->answer_bobot;

            // Nama kategori (pakai locale saat ini)
            if (!isset($categoryNames[$catId])) {
                $categoryNames[$catId] = optional($question->category->translation)->name ?? 'Unknown';
            }

            if ($question->type === 'likert') {
                // ── Likert: max bobot berasal dari answer template ─────────────
                $maxAnswerBobot = 5; // default skala 5
                if ($question->answerTemplate && $question->answerTemplate->defaultAnswers->isNotEmpty()) {
                    $maxAnswerBobot = (int) $question->answerTemplate->defaultAnswers->max('bobot');
                }

                $likertScores[$catId]   = ($likertScores[$catId]   ?? 0) + $bobot;
                $maxLikertScore[$catId] = ($maxLikertScore[$catId] ?? 0) + $maxAnswerBobot;
            } elseif ($question->type === 'multiple_choice') {
                // ── MC: answer_bobot sudah berisi question->bobot (jika benar) atau 0 ─
                $mcScores[$catId]   = ($mcScores[$catId]   ?? 0) + $bobot;
                $mcMaxScores[$catId] = ($mcMaxScores[$catId] ?? 0) + (int) $question->bobot;
            }
        }

        // ── Hitung persentase per kategori ────────────────────────────────────
        //
        // Skema perhitungan:
        //   • MC adalah pelengkap Likert dalam satu dimensi.
        //     Bobot MC dirancang agar (likert_max + mc_max) = 50 per dimensi.
        //   • Skor digabung terlebih dahulu:
        //       combined_total = likert_score + mc_score
        //       combined_max   = likert_max   + mc_max
        //   • Konversi ke persentase 0–100:
        //       combined_max >= 50  →  (combined_total / combined_max) * 100
        //       combined_max <  50  →  combined_total * 2
        //
        $categoryPercents = [];
        $categoryStatus   = [];
        $allCatIds        = array_unique(array_merge(array_keys($likertScores), array_keys($mcScores)));

        foreach ($allCatIds as $catId) {
            $combinedTotal = ($likertScores[$catId]   ?? 0) + ($mcScores[$catId]    ?? 0);
            $combinedMax   = ($maxLikertScore[$catId] ?? 0) + ($mcMaxScores[$catId] ?? 0);

            if ($combinedMax <= 0) {
                $categoryPercents[$catId] = 0;
            } elseif ($combinedMax >= 50) {
                // Max sudah 50 (atau lebih): normalisasi proporsional → tidak perlu dikali 2
                $categoryPercents[$catId] = round(min(100, ($combinedTotal / $combinedMax) * 100), 2);
            } else {
                // Max di bawah 50: kalikan 2 agar tetap mendekati skala 0–100
                $categoryPercents[$catId] = round(min(100, $combinedTotal * 2), 2);
            }

            // ── Status kategori ───────────────────────────────────────────────
            $pct = $categoryPercents[$catId];
            $categoryStatus[$catId] = match (true) {
                $pct > 90  => __('assessment.excellent'),
                $pct >= 81 => __('assessment.very_good'),
                $pct >= 65 => __('assessment.satisfiable'),
                default    => __('assessment.need_improvement'),
            };
        }

        // ── Overall score ─────────────────────────────────────────────────────
        $totalObtained   = array_sum($likertScores) + array_sum($mcScores);
        $totalMaxPossible = array_sum($maxLikertScore) + array_sum($mcMaxScores);

        $overallScore = $totalMaxPossible > 0
            ? (int) round(($totalObtained / $totalMaxPossible) * 100)
            : 0;

        $instrumentScore = match (true) {
            $overallScore > 90  => __('assessment.excellent'),
            $overallScore >= 81 => __('assessment.very_good'),
            $overallScore >= 65 => __('assessment.satisfiable'),
            default             => __('assessment.need_improvement'),
        };

        // ── Rekomendasi modul untuk kategori < 70% ────────────────────────────
        $THRESHOLD            = 70;
        $recommendedCategories = [];

        foreach ($categoryPercents as $catId => $percent) {
            if ($percent < $THRESHOLD) {
                $category = Category::with('translation')->find($catId);
                $moduls   = Modul::with(['translation', 'category.translation', 'kategoriModul.translation'])
                    ->where('id_kategori', $catId)
                    ->get();

                $recommendedCategories[$catId] = [
                    'category' => $category,
                    'percent'  => $percent,
                    'moduls'   => $moduls,
                ];
            }
        }

        // Urutkan by category id
        ksort($categoryNames);
        ksort($categoryPercents);
        ksort($categoryStatus);
        ksort($recommendedCategories);

        return view('pengukuran.hasil', compact(
            'categoryNames',
            'categoryPercents',
            'categoryStatus',
            'recommendedCategories',
            'overallScore',
            'instrumentScore'
        ));
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

        // Hapus jawaban lama user ini sebelum menyimpan yang baru
        UserAnswer::where('user_id', $userId)->delete();

        foreach ($allAnswers as $questionId => $answerValue) {
            $parts = explode(':', $answerValue);
            $nilai = end($parts);

            UserAnswer::create([
                'user_id'      => $userId,
                'question_id'  => (int) $parts[0],
                'answer_bobot' => (float) $nilai,
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
