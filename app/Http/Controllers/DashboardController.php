<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use App\Models\Category;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::user()->id ?? 1;

        // Ambil jawaban terbaru berdasarkan waktu update
        $latestAnswer = UserAnswer::where('user_id', $userId)
            ->latest('updated_at')
            ->first();

        $userAnswers = collect();

        if ($latestAnswer) {
            $sessionStart = $latestAnswer->updated_at->copy()->subMinute();

            $userAnswers = UserAnswer::where('user_id', $userId)
                ->where('attempt_id', $latestAnswer->attempt_id)
                ->with([
                    'question.category',
                    'question.answerTemplate.defaultAnswers',
                ])
                ->orderBy('updated_at')
                ->get();
        }

        $categoryNames          = [];
        $categoryPercents       = [];
        $overallScore           = 0;
        $totalQuestions         = 0;
        $lastTestDate           = null;
        $totalTestCount         = 0;
        $instrumentScore        = null;
        $colorScore             = 'success';
        $categoriesForImprovement = [];
        $totalBobotObtained = 0;
        $totalMaxPossible = 0;

        if ($userAnswers->isNotEmpty()) {

            // ── Akumulasi skor per kategori, pisahkan Likert vs MC ───────────
            $likertScores    = [];
            $maxLikertScore  = [];
            $mcScores        = [];
            $mcMaxScores     = [];

            foreach ($userAnswers as $ua) {
                $question = $ua->question;
                if (!$question) continue;

                $catId = $question->id_kategori;
                $bobot = (float) $ua->answer_bobot;
                $totalBobotObtained += $bobot;
                $totalQuestions++;

                if (!isset($categoryNames[$catId])) {
                    $categoryNames[$catId] = $question->category->translation->name ?? 'Unknown';
                }

                if (!$lastTestDate) {
                    $lastTestDate = $ua->created_at;
                }

                if ($question->type === 'likert') {
                    // Max bobot per soal dari answer template (default 5)
                    $maxAnswerBobot = 5;
                    if ($question->answerTemplate && $question->answerTemplate->defaultAnswers->isNotEmpty()) {
                        $maxAnswerBobot = (int) $question->answerTemplate->defaultAnswers->max('bobot');
                    }

                    $likertScores[$catId]   = ($likertScores[$catId]   ?? 0) + $bobot;
                    $maxLikertScore[$catId] = ($maxLikertScore[$catId] ?? 0) + $maxAnswerBobot;
                } elseif ($question->type === 'multiple_choice') {
                    $mcScores[$catId]    = ($mcScores[$catId]    ?? 0) + $bobot;
                    $mcMaxScores[$catId] = ($mcMaxScores[$catId] ?? 0) + (int) $question->bobot;
                }
            }



            // ── Persentase per kategori ───────────────────────────────────────
            // MC adalah pelengkap Likert dalam satu dimensi.
            // Skor digabung dulu, baru dikonversi ke persen:
            //   combined_max >= 50  →  (total / combined_max) * 100
            //   combined_max <  50  →  total * 2
            $allCatIds = array_unique(array_merge(array_keys($likertScores), array_keys($mcScores)));

            foreach ($allCatIds as $catId) {
                $combinedTotal = ($likertScores[$catId]   ?? 0) + ($mcScores[$catId]    ?? 0);
                $combinedMax   = ($maxLikertScore[$catId] ?? 0) + ($mcMaxScores[$catId] ?? 0);

                if ($combinedMax <= 0) {
                    $categoryPercents[$catId] = 0;
                } elseif ($combinedMax >= 50) {
                    $categoryPercents[$catId] = round(min(100, ($combinedTotal / $combinedMax) * 100), 2);
                } else {
                    $categoryPercents[$catId] = round(min(100, $combinedTotal * 2), 2);
                }
            }

            // ── Overall score ─────────────────────────────────────────────────
            $totalObtained    = array_sum($likertScores) + array_sum($mcScores);
            $totalMaxPossible = array_sum($maxLikertScore) + array_sum($mcMaxScores);

            $overallScore = $totalMaxPossible > 0
                ? (int) round(($totalObtained / $totalMaxPossible) * 100)
                : 0;

            // ── Instrument score label ────────────────────────────────────────
            [$instrumentScore, $colorScore] = match (true) {
                $overallScore > 90  => [__('assessment.excellent'),        'success'],
                $overallScore >= 81 => [__('assessment.very_good'),        'warning'],
                $overallScore >= 65 => [__('assessment.satisfiable'),      'warning'],
                default             => [__('assessment.need_improvement'), 'danger'],
            };

            // Urutkan konsisten
            ksort($categoryNames);
            ksort($categoryPercents);

            // Kategori di bawah threshold 70%
            foreach ($categoryPercents as $catId => $percent) {
                if ($percent < 70) {
                    $categoriesForImprovement[] = [
                        'id'    => $catId,
                        'name'  => $categoryNames[$catId],
                        'score' => round($percent, 2),
                    ];
                }
            }

            $totalTestCount = UserAnswer::where('user_id', $userId)
                ->distinct('attempt_id')
                ->count('attempt_id');
        }

        return view('dashboard', compact(
            'categoryNames',
            'categoryPercents',
            'overallScore',
            'totalQuestions',
            'lastTestDate',
            'totalTestCount',
            'totalBobotObtained',
            'totalMaxPossible' ,
            'categoriesForImprovement',
            'instrumentScore',
            'colorScore',
        ));
    }
}
