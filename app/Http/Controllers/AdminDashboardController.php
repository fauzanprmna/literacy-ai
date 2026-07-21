<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modul;
use App\Models\UserAnswer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // ====== GET LATEST ATTEMPT PER USER ======
        $latestAttempts = UserAnswer::select(
            'user_id',
            DB::raw('MAX(attempt_id) as latest_attempt_id')
        )->groupBy('user_id');

        $userAnswers = UserAnswer::joinSub(
            $latestAttempts,
            'latest_attempts',
            function ($join) {
                $join->on('user_answers.user_id', '=', 'latest_attempts.user_id')
                    ->on('user_answers.attempt_id', '=', 'latest_attempts.latest_attempt_id');
            }
        )
            ->select('user_answers.*')
            ->with([
                'user',
                'question',
                'question.category',
                'question.answerTemplate.defaultAnswers',
            ])
            ->orderBy('user_answers.user_id')
            ->get();

        $categoryNames          = [];
        $userCategoryScores     = [];   // combined
        $userLikertCatScores    = [];   // persepsi per cat
        $userMcqCatScores       = [];   // kompetensi per cat
        $userOverallScores      = [];
        $userLikertScores       = [];   // persepsi overall per user
        $userMcqScores          = [];   // kompetensi overall per user

        // ====== HITUNG PER USER ======
        foreach ($userAnswers->groupBy('user_id') as $userId => $answers) {

            $likertScores    = [];
            $maxLikertScores = [];
            $mcScores        = [];
            $mcMaxScores     = [];

            foreach ($answers as $ua) {
                $question = $ua->question;
                if (!$question) continue;

                $catId = $question->id_kategori;
                $bobot = (float) $ua->answer_bobot;

                if (!isset($categoryNames[$catId])) {
                    $categoryNames[$catId] = $question->category->name ?? 'Unknown';
                }

                if ($question->type === 'likert') {
                    $maxAnswerBobot = 5;
                    if ($question->answerTemplate && $question->answerTemplate->defaultAnswers->isNotEmpty()) {
                        $maxAnswerBobot = (int) $question->answerTemplate->defaultAnswers->max('bobot');
                    }
                    $likertScores[$catId]    = ($likertScores[$catId] ?? 0) + $bobot;
                    $maxLikertScores[$catId] = ($maxLikertScores[$catId] ?? 0) + $maxAnswerBobot;
                } else {
                    $mcScores[$catId]    = ($mcScores[$catId] ?? 0) + $bobot;
                    $mcMaxScores[$catId] = ($mcMaxScores[$catId] ?? 0) + 10;
                }
            }

            $allCatIds = array_unique(array_merge(array_keys($likertScores), array_keys($mcScores)));

            // Per-category (combined, likert-only, mcq-only)
            foreach ($allCatIds as $catId) {
                $combinedTotal = ($likertScores[$catId] ?? 0) + ($mcScores[$catId] ?? 0);
                $combinedMax   = ($maxLikertScores[$catId] ?? 0) + ($mcMaxScores[$catId] ?? 0);
                $userCategoryScores[$catId][] = $combinedMax > 0
                    ? round(($combinedTotal / $combinedMax) * 100, 0) : 0;

                // Likert-only per cat
                if (isset($likertScores[$catId])) {
                    $lMax = $maxLikertScores[$catId] ?? 0;
                    $userLikertCatScores[$catId][] = $lMax > 0
                        ? round(($likertScores[$catId] / $lMax) * 100, 0) : 0;
                }

                // MCQ-only per cat
                if (isset($mcScores[$catId])) {
                    $mMax = $mcMaxScores[$catId] ?? 0;
                    $userMcqCatScores[$catId][] = $mMax > 0
                        ? round(($mcScores[$catId] / $mMax) * 100, 0) : 0;
                }
            }

            // Overall combined
            $obtained = array_sum($likertScores) + array_sum($mcScores);
            $maximum  = array_sum($maxLikertScores) + array_sum($mcMaxScores);
            $userOverallScores[] = $maximum > 0 ? round(($obtained / $maximum) * 100, 2) : 0;

            // Overall likert
            $lObt = array_sum($likertScores);
            $lMax = array_sum($maxLikertScores);
            $userLikertScores[] = $lMax > 0 ? round(($lObt / $lMax) * 100, 2) : 0;

            // Overall MCQ
            $mObt = array_sum($mcScores);
            $mMax = array_sum($mcMaxScores);
            $userMcqScores[] = $mMax > 0 ? round(($mObt / $mMax) * 100, 2) : 0;
        }

        // ===== RATA-RATA PER KATEGORI =====
        $categoryPercents      = [];
        $categoryLikertPercents = [];
        $categoryMcqPercents   = [];

        foreach ($userCategoryScores as $catId => $scores) {
            $categoryPercents[$catId] = round(collect($scores)->avg(), 2);
        }
        foreach ($userLikertCatScores as $catId => $scores) {
            $categoryLikertPercents[$catId] = round(collect($scores)->avg(), 2);
        }
        foreach ($userMcqCatScores as $catId => $scores) {
            $categoryMcqPercents[$catId] = round(collect($scores)->avg(), 2);
        }

        ksort($categoryNames);
        ksort($categoryPercents);
        ksort($categoryLikertPercents);
        ksort($categoryMcqPercents);

        // ===== OVERALL STATS (combined) =====
        $totalUsers   = count($userOverallScores);
        $overallScore = $totalUsers > 0 ? round(collect($userOverallScores)->avg(), 1) : 0;
        $highestScore = $totalUsers > 0 ? round(max($userOverallScores), 0) : 0;
        $lowestScore  = $totalUsers > 0 ? round(min($userOverallScores), 0) : 0;

        // ===== LIKERT STATS (persepsi) =====
        $likertAvg     = count($userLikertScores) > 0 ? round(collect($userLikertScores)->avg(), 1) : 0;
        $likertHighest = count($userLikertScores) > 0 ? round(max($userLikertScores), 0) : 0;
        $likertLowest  = count($userLikertScores) > 0 ? round(min($userLikertScores), 0) : 0;

        // ===== MCQ STATS (kompetensi aktual) =====
        $mcqAvg     = count($userMcqScores) > 0 ? round(collect($userMcqScores)->avg(), 1) : 0;
        $mcqHighest = count($userMcqScores) > 0 ? round(max($userMcqScores), 0) : 0;
        $mcqLowest  = count($userMcqScores) > 0 ? round(min($userMcqScores), 0) : 0;

        // ===== SCORE CATEGORIES (combined) =====
        $scoreCategories = $this->calculateScoreCategories($userOverallScores);

        // ===== SCORE CATEGORIES LIKERT =====
        $likertCategories = $this->calculateScoreCategories($userLikertScores);

        // ===== SCORE CATEGORIES MCQ =====
        $mcqCategories = $this->calculateScoreCategories($userMcqScores);

        // ===== SCORE DISTRIBUTION =====
        $scoreRanges       = $this->calculateScoreRanges($userOverallScores);
        $likertScoreRanges = $this->calculateScoreRanges($userLikertScores);
        $mcqScoreRanges    = $this->calculateScoreRanges($userMcqScores);

        // ===== CATEGORY DETAILS =====
        $categoryDetails = $this->getCategoryDetails($userAnswers);

        // ===== RECENT ASSESSMENTS =====
        $recentAssessments = $this->getRecentAssessments();

        // ===== COUNTS =====
        $userCount         = User::count();
        $modulCount        = Modul::count();
        $mahasiswaAssessed = User::whereIn('id', $userAnswers->pluck('user_id'))->where('role', 'mahasiswa')->count();
        $dosenAssessed     = User::whereIn('id', $userAnswers->pluck('user_id'))->where('role', 'dosen')->count();

        // ===== CONVERT CAT IDs TO NAMES =====
        $categoryScores      = [];
        $categoryLikertScores = [];
        $categoryMcqScores   = [];

        foreach ($categoryNames as $catId => $name) {
            $categoryScores[$name]       = $categoryPercents[$catId] ?? 0;
            $categoryLikertScores[$name] = $categoryLikertPercents[$catId] ?? 0;
            $categoryMcqScores[$name]    = $categoryMcqPercents[$catId] ?? 0;
        }

        return view('admin.dashboard', [
            'userCount'          => $userCount,
            'modulCount'         => $modulCount,
            'totalAssessments'   => $userAnswers->count(),
            'uniqueUsers'        => $totalUsers,
            'mahasiswaAssessed'  => $mahasiswaAssessed,
            'dosenAssessed'      => $dosenAssessed,

            // Combined
            'averageScore'  => $overallScore,
            'highestScore'  => $highestScore,
            'lowestScore'   => $lowestScore,
            'scoreRanges'   => $scoreRanges,
            'highScoreCount'      => $scoreCategories['high'],
            'highScorePercentage' => $scoreCategories['highPercentage'],
            'mediumScoreCount'    => $scoreCategories['medium'],
            'mediumScorePercentage' => $scoreCategories['mediumPercentage'],
            'lowScoreCount'       => $scoreCategories['low'],
            'lowScorePercentage'  => $scoreCategories['lowPercentage'],

            // Persepsi (Likert)
            'likertAvg'     => $likertAvg,
            'likertHighest' => $likertHighest,
            'likertLowest'  => $likertLowest,
            'likertScoreRanges'       => $likertScoreRanges,
            'likertHighCount'         => $likertCategories['high'],
            'likertHighPercentage'    => $likertCategories['highPercentage'],
            'likertMediumCount'       => $likertCategories['medium'],
            'likertMediumPercentage'  => $likertCategories['mediumPercentage'],
            'likertLowCount'          => $likertCategories['low'],
            'likertLowPercentage'     => $likertCategories['lowPercentage'],
            'categoryLikertScores'    => $categoryLikertScores,

            // Kompetensi Aktual (MCQ)
            'mcqAvg'     => $mcqAvg,
            'mcqHighest' => $mcqHighest,
            'mcqLowest'  => $mcqLowest,
            'mcqScoreRanges'          => $mcqScoreRanges,
            'mcqHighCount'            => $mcqCategories['high'],
            'mcqHighPercentage'       => $mcqCategories['highPercentage'],
            'mcqMediumCount'          => $mcqCategories['medium'],
            'mcqMediumPercentage'     => $mcqCategories['mediumPercentage'],
            'mcqLowCount'             => $mcqCategories['low'],
            'mcqLowPercentage'        => $mcqCategories['lowPercentage'],
            'categoryMcqScores'       => $categoryMcqScores,

            // Shared
            'categoryScores'  => $categoryScores,
            'categoryDetails' => $categoryDetails,
            'userScores'      => $userOverallScores,
            'recentAssessments' => $recentAssessments,
        ]);
    }

    private function calculateScoreCategories($userScores)
    {
        $high = 0;
        $medium = 0;
        $low = 0;
        $total = count($userScores);

        foreach ($userScores as $score) {
            if ($score >= 85)                    $high++;
            elseif ($score >= 70 && $score < 85) $medium++;
            else                                  $low++;
        }

        return [
            'high'             => $high,
            'highPercentage'   => $total > 0 ? round(($high   / $total) * 100) : 0,
            'medium'           => $medium,
            'mediumPercentage' => $total > 0 ? round(($medium / $total) * 100) : 0,
            'low'              => $low,
            'lowPercentage'    => $total > 0 ? round(($low    / $total) * 100) : 0,
        ];
    }

    private function calculateScoreRanges($userScores)
    {
        $ranges = ['0-20' => 0, '21-40' => 0, '41-60' => 0, '61-80' => 0, '81-100' => 0];

        foreach ($userScores as $score) {
            if ($score <= 20)       $ranges['0-20']++;
            elseif ($score <= 40)   $ranges['21-40']++;
            elseif ($score <= 60)   $ranges['41-60']++;
            elseif ($score <= 80)   $ranges['61-80']++;
            else                    $ranges['81-100']++;
        }

        return $ranges;
    }

    private function getCategoryDetails($userAnswers)
    {
        $allCategories = Category::pluck('id', 'name');
        $result = [];

        foreach ($allCategories as $categoryName => $categoryId) {
            $catAnswers = $userAnswers->filter(fn($a) => $a->question && $a->question->id_kategori == $categoryId);
            $total = $catAnswers->count();
            $correct = 0;

            foreach ($catAnswers as $answer) {
                if (!$answer->question) continue;
                $bobot = (int) $answer->answer_bobot;
                if ($answer->question->type === 'likert') {
                    if ($bobot >= 3) $correct++;
                } else {
                    if ($bobot == 10) $correct++;
                }
            }

            $result[$categoryName] = ['total' => $total, 'correct' => $correct];
        }

        return $result;
    }

    private function getRecentAssessments()
    {
        $recentAnswers = UserAnswer::with(['user', 'question', 'question.category', 'question.answerTemplate.defaultAnswers'])
            ->where('attempt_id', function ($query) {
                $query->selectRaw('MAX(attempt_id)')
                    ->from('user_answers as ua2')
                    ->whereColumn('ua2.user_id', 'user_answers.user_id');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($a) => $a->user_id . '_' . $a->attempt_id)
            ->take(10);

        $assessments = [];

        foreach ($recentAnswers as $answers) {
            $likertScores = [];
            $maxLikertScore = [];
            $mcScores     = [];
            $mcMaxScores    = [];
            $dimScores    = [];
            $dimMaxScores   = [];
            $likertTotal  = 0;
            $likertCorrect  = 0;
            $mcqTotal     = 0;
            $mcqCorrect     = 0;

            foreach ($answers as $answer) {
                if (!$answer->question) continue;

                $question  = $answer->question;
                $dimension = $question->category->name ?? 'Uncategorized';
                $bobot     = (float) $answer->answer_bobot;

                if ($question->type === 'likert') {
                    $maxBobot = 5;
                    if ($question->answerTemplate && $question->answerTemplate->defaultAnswers->isNotEmpty()) {
                        $maxBobot = (int) $question->answerTemplate->defaultAnswers->max('bobot');
                    }
                    $likertScores[$dimension]   = ($likertScores[$dimension] ?? 0) + $bobot;
                    $maxLikertScore[$dimension] = ($maxLikertScore[$dimension] ?? 0) + $maxBobot;
                    $likertTotal++;
                    if ((int) $bobot >= 3) $likertCorrect++;

                    $dimScores[$dimension]   = ($dimScores[$dimension] ?? 0) + $bobot;
                    $dimMaxScores[$dimension] = ($dimMaxScores[$dimension] ?? 0) + $maxBobot;
                } elseif (in_array($question->type, ['mc', 'multiple_choice'])) {
                    $mcScores[$dimension]   = ($mcScores[$dimension] ?? 0) + (int) $bobot;
                    $mcMaxScores[$dimension] = ($mcMaxScores[$dimension] ?? 0) + 10;
                    $mcqTotal++;
                    if ((int) $bobot == 10) $mcqCorrect++;

                    $dimScores[$dimension]   = ($dimScores[$dimension] ?? 0) + $bobot;
                    $dimMaxScores[$dimension] = ($dimMaxScores[$dimension] ?? 0) + 10;
                }
            }

            $totalObtained   = array_sum($likertScores) + array_sum($mcScores);
            $totalMaxPossible = array_sum($maxLikertScore) + array_sum($mcMaxScores);
            $overallScore    = $totalMaxPossible > 0 ? (int) round(($totalObtained / $totalMaxPossible) * 100) : 0;

            $lTotal = array_sum($maxLikertScore);
            $likertScore = $lTotal > 0 ? (int) round((array_sum($likertScores) / $lTotal) * 100) : 0;

            $mTotal = array_sum($mcMaxScores);
            $mcqScore = $mTotal > 0 ? (int) round((array_sum($mcScores) / $mTotal) * 100) : 0;

            $dimPercents = [];
            foreach ($dimMaxScores as $dim => $max) {
                $dimPercents[$dim] = $max > 0 ? round(min(100, (($dimScores[$dim] ?? 0) / $max) * 100), 1) : 0;
            }

            $firstAnswer = $answers->first();
            $user        = $firstAnswer->user;
            $userRole    = $user && $user->role === 'mahasiswa' ? '(Mahasiswa)' : '(Dosen)';

            $assessments[] = [
                'user_name'       => ($user ? $user->name : 'Unknown') . ' ' . $userRole,
                'user_id'         => $firstAnswer->user_id,
                'attempt_id'      => $firstAnswer->attempt_id,
                'date'            => $firstAnswer->created_at->format('d M Y H:i'),
                'total_questions' => $answers->count(),
                'likert_total'    => $likertTotal,
                'likert_correct'  => $likertCorrect,
                'likert_score'    => $likertScore,
                'mcq_total'       => $mcqTotal,
                'mcq_correct'     => $mcqCorrect,
                'mcq_score'       => $mcqScore,
                'overall_score'   => $overallScore,
                'dimension_scores' => $dimPercents,
            ];
        }

        return $assessments;
    }
}
