<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class AssessmentHistoryController extends Controller
{
    /**
     * Show assessment history list
     * - Admin: carousel dengan semua user + attempts mereka
     * - User: hanya attempts user sendiri
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();

        if ($authUser->role === 'admin') {
            // ===== ADMIN: TAMPILKAN SEMUA USER DENGAN ASSESSMENT =====

            // Get semua user yang pernah mengisi assessment
            $usersWithAssessments = User::whereHas('answers')
                ->orderBy('name')
                ->get();

            // Get selected user (default: user pertama)
            $selectedUserId = $request->get('user_id', $usersWithAssessments->first()->id ?? null);
            $selectedUser = $usersWithAssessments->firstWhere('id', $selectedUserId);

            if (!$selectedUser) {
                return view('assessments.history', [
                    'usersWithAssessments' => $usersWithAssessments,
                    'selectedUser' => null,
                    'attempts' => collect([]),
                    'userStats' => [],
                    'totalAssessments' => 0,
                    'averageScore' => 0,
                ]);
            }

            // Get attempts untuk selected user
            $userAnswers = UserAnswer::where('user_id', $selectedUserId)
                ->with(['question.translation', 'question.answerTemplate.defaultAnswers', 'question.category'])
                ->orderBy('attempt_id', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Group by attempt_id
            $attemptGroups = $userAnswers->groupBy('attempt_id');

            // Calculate statistics per attempt
            $attempts = $attemptGroups->map(function ($responses, $attemptId) use ($selectedUserId) {
                return $this->enrichAssessmentData($responses, $attemptId, $selectedUserId);
            })->values();
            // Calculate user statistics
            $userStats = $this->calculateUserStats($attempts);

            return view('assessments.history', [
                'usersWithAssessments' => $usersWithAssessments,
                'selectedUser' => $selectedUser,
                'attempts' => $attempts,
                'userStats' => $userStats,
                'totalAssessments' => $attempts->count(),
                'averageScore' => round($attempts->avg('score')),
            ]);
        } else {
            // ===== USER: TAMPILKAN HANYA ATTEMPTS SENDIRI =====

            $userAnswers = UserAnswer::where('user_id', $authUser->id)
                ->with(['question.translation', 'question.answerTemplate.defaultAnswers', 'question.category'])
                ->orderBy('attempt_id', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Group by attempt_id
            $attemptGroups = $userAnswers->groupBy('attempt_id');

            // Calculate statistics per attempt
            $attempts = $attemptGroups->map(function ($responses, $attemptId) use ($authUser) {
                return $this->enrichAssessmentData($responses, $attemptId, $authUser->id);
            })->values();

            // Apply sorting if requested
            if ($request->has('sort')) {
                $attempts = $this->applySort($attempts, $request->sort);
            }

            return view('assessments.history', [
                'usersWithAssessments' => collect([]),
                'selectedUser' => null,
                'attempts' => $attempts,
                'userStats' => [],
                'totalAssessments' => $attempts->count(),
                'averageScore' => round($attempts->avg('score')),
            ]);
        }
    }

    /**
     * Show detailed view of single assessment attempt
     * - Split Likert vs MCQ
     * - Show user answers clearly
     */
    public function show($attemptId, $userId = null)
    {
        $authUser = Auth::user();

        // Verify authorization
        if ($authUser->role !== 'admin' && $authUser->id != $userId) {
            abort(403, 'Unauthorized');
        }

        // Get all responses from this attempt
        $responses = UserAnswer::where('user_id', $userId ?? $authUser->id)
            ->with(['question.translation', 'question.answerTemplate.defaultAnswers', 'question.category', 'user', 'answer_value.translation'])
            ->where('attempt_id', $attemptId)
            ->orderBy('question_id', 'asc')
            ->get();

        if ($responses->isEmpty()) {
            abort(404, 'Assessment not found');
        }

        // Get session metadata
        $firstResponse = $responses->first();
        $lastResponse = $responses->last();
        $sessionDate = $firstResponse->created_at;
        $sessionUser = $firstResponse->user;

        $scoreData = $this->calculateAssessmentScores($responses);

        // Calculate instrument score
        $instrumentScore = match (true) {
            $scoreData['overallScore'] > 90  => __('assessment.excellent'),
            $scoreData['overallScore'] >= 81 => __('assessment.very_good'),
            $scoreData['overallScore'] >= 65 => __('assessment.satisfiable'),
            default                          => __('assessment.need_improvement'),
        };

        // ===== SPLIT LIKERT vs MCQ =====
        $likertResponses = $responses->filter(fn($r) => $r->question->type === 'likert');
        $mcqResponses = $responses->filter(fn($r) => $r->question->type === 'multiple_choice');

        // Group each by category
        $likertByCategory = $likertResponses->groupBy(fn($r) => $r->question->category->name ?? 'Uncategorized');
        $mcqByCategory = $mcqResponses->groupBy(fn($r) => $r->question->category->name ?? 'Uncategorized');

        // Calculate per-category scores for each type
        $likertCategoryScores = $this->calculateCategoryScores($likertResponses);
        $mcqCategoryScores = $this->calculateCategoryScores($mcqResponses);

        // Group by dimension
        $responsesByDimension = $responses->groupBy(function ($response) {
            return $response->question->category->name ?? 'Uncategorized';
        })->map(function ($group, $dimension) use ($scoreData) {
            return [
                'total' => $group->count(),
                'correct' => $group->where('is_correct', true)->count(),
                'score' => $scoreData['dimensionScores'][$dimension] ?? 0,
            ];
        });

        // Calculate statistics
        $totalQuestions = $responses->count();
        $correctAnswers = $responses->where('is_correct', true)->count();
        $duration = $this->calculateDuration($firstResponse, $lastResponse);

        return view('assessments.detail', [
            'attemptId' => $attemptId,
            'sessionUser' => $sessionUser,
            'sessionDate' => $sessionDate,
            'responses' => $responses,
            'responsesByDimension' => $responsesByDimension,
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'overallScore' => $scoreData['overallScore'],
            'instrumentScore' => $instrumentScore,
            'duration' => $duration,
            'userId' => $userId ?? $authUser->id,
            // ===== SPLIT DATA =====
            'likertResponses' => $likertResponses,
            'mcqResponses' => $mcqResponses,
            'likertByCategory' => $likertByCategory,
            'mcqByCategory' => $mcqByCategory,
            'likertCategoryScores' => $likertCategoryScores,
            'mcqCategoryScores' => $mcqCategoryScores,
        ]);
    }

    public function delete($attemptId, $userId = null)
    {
        $authUser = Auth::user();

        if ($authUser->role !== 'admin') {
            abort(403);
        }

        $targetUserId = $userId ?? $authUser->id;

        UserAnswer::where('user_id', $targetUserId)
            ->where('attempt_id', $attemptId)
            ->delete();

        $hasRemainingAttempt = UserAnswer::where('user_id', $targetUserId)
            ->distinct('attempt_id')
            ->exists();

        if (!$hasRemainingAttempt) {
            return redirect()
                ->route('assessments.history')
                ->with('success', 'Assessment attempt deleted successfully.');
        }

        return redirect()
            ->route('assessments.history', ['userId' => $targetUserId])
            ->with('success', 'Assessment attempt deleted successfully.');
    }

    /**
     * Export assessment as PDF
     */
    public function exportPDF($sessionKey = null, $userId = null)
    {
        $authUser = Auth::user();

        if ($sessionKey) {

            // Verify authorization
            if ($authUser->role !== 'admin' && $authUser->id != $userId) {
                abort(403, 'Unauthorized');
            }

            // Get all responses from this attempt
            $responses = UserAnswer::where('user_id', $userId ?? $authUser->id)
                ->with(['question.translation', 'question.answerTemplate.defaultAnswers', 'question.category', 'user', 'answer_value.translation'])
                ->where('attempt_id', $sessionKey)
                ->orderBy('question_id', 'asc')
                ->get();

            if ($responses->isEmpty()) {
                abort(404, 'Assessment not found');
            }

            // Get session metadata
            $firstResponse = $responses->first();
            $lastResponse = $responses->last();
            $sessionDate = $firstResponse->created_at;
            $sessionUser = $firstResponse->user;

            $scoreData = $this->calculateAssessmentScores($responses);

            // Calculate instrument score
            $instrumentScore = match (true) {
                $scoreData['overallScore'] > 90  => __('assessment.excellent'),
                $scoreData['overallScore'] >= 81 => __('assessment.very_good'),
                $scoreData['overallScore'] >= 65 => __('assessment.satisfiable'),
                default                          => __('assessment.need_improvement'),
            };

            // ===== SPLIT LIKERT vs MCQ =====
            $likertResponses = $responses->filter(fn($r) => $r->question->type === 'likert');
            $mcqResponses = $responses->filter(fn($r) => $r->question->type === 'multiple_choice');

            // Group each by category
            $likertByCategory = $likertResponses->groupBy(fn($r) => $r->question->category->name ?? 'Uncategorized');
            $mcqByCategory = $mcqResponses->groupBy(fn($r) => $r->question->category->name ?? 'Uncategorized');

            // Calculate per-category scores for each type
            $likertCategoryScores = $this->calculateCategoryScores($likertResponses);
            $mcqCategoryScores = $this->calculateCategoryScores($mcqResponses);

            // Group by dimension
            $responsesByDimension = $responses->groupBy(function ($response) {
                return $response->question->category->name ?? 'Uncategorized';
            })->map(function ($group, $dimension) use ($scoreData) {
                return [
                    'total' => $group->count(),
                    'correct' => $group->where('is_correct', true)->count(),
                    'score' => $scoreData['dimensionScores'][$dimension] ?? 0,
                ];
            });

            // Calculate statistics
            $totalQuestions = $responses->count();
            $correctAnswers = $responses->where('is_correct', true)->count();
            $duration = $this->calculateDuration($firstResponse, $lastResponse);

            $pdf = PDF::loadView('assessments.export.detail', [
                'attemptId' => $sessionKey,
                'sessionUser' => $sessionUser,
                'sessionDate' => $sessionDate,
                'responses' => $responses,
                'responsesByDimension' => $responsesByDimension,
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
                'overallScore' => $scoreData['overallScore'],
                'instrumentScore' => $instrumentScore,
                'duration' => $duration,
                'userId' => $userId ?? $authUser->id,
                // ===== SPLIT DATA =====
                'likertResponses' => $likertResponses,
                'mcqResponses' => $mcqResponses,
                'likertByCategory' => $likertByCategory,
                'mcqByCategory' => $mcqByCategory,
                'likertCategoryScores' => $likertCategoryScores,
                'mcqCategoryScores' => $mcqCategoryScores,
                'exportDate' => now()->format('d F Y H:i'),
            ]);

            return $pdf->download("Assessment {$sessionKey}_{$sessionUser->name}.pdf");
        }
        // Export single assessment session
        $responses = UserAnswer::where('user_id', $userId ?? $user->id)
            ->with('question.translation')
            ->where('attempt_id', $sessionKey)
            ->get();

        if ($responses->isEmpty()) {
            abort(404, 'Assessment not found');
        }

        $pdf = PDF::loadView('assessments.export.detail', [
            'responses' => $responses,
            'user' => $user,
            'sessionDate' => $responses->first()->created_at,
        ]);

        return $pdf->download("assessment-{$sessionKey}.pdf");
    }

    /**
     * Helper: Enrich assessment data with calculations
     */
    private function enrichAssessmentData($responses, $attemptId, $userId)
    {
        $scoreData = $this->calculateAssessmentScores($responses);

        $firstAnswer = $responses->first();
        $lastAnswer = $responses->last();

        // Count per type
        $likertCount = $responses->where('question.type', 'likert')->count();
        $mcqCount = $responses->where('question.type', 'multiple_choice')->count();

        return [
            'attempt_id' => $attemptId,
            'user_id' => $userId,
            'date' => $firstAnswer->created_at,
            'score' => $scoreData['overallScore'],
            'category' => $scoreData['category'],
            'dimension_scores' => $scoreData['dimensionScores'],
            'total_questions' => $responses->count(),
            'correct_answers' => $responses->where('is_correct', true)->count(),
            'likert_count' => $likertCount,
            'mcq_count' => $mcqCount,
            'duration' => $this->calculateDuration($firstAnswer, $lastAnswer),
            'responses' => $responses,
        ];
    }

    /**
     * Helper: Calculate user statistics
     */
    private function calculateUserStats($attempts)
    {
        if ($attempts->isEmpty()) {
            return [];
        }

        return [
            'total_attempts' => $attempts->count(),
            'average_score' => round($attempts->avg('score'), 2),
            'highest_score' => $attempts->max('score'),
            'lowest_score' => $attempts->min('score'),
        ];
    }

    /**
     * Helper: Calculate per-category scores
     */
    private function calculateCategoryScores($responses)
    {
        $categoryScores = [];

        $byCategory = $responses->groupBy(fn($r) => $r->question->category->name ?? 'Uncategorized');

        foreach ($byCategory as $category => $groupResponses) {
            $scoreData = $this->calculateAssessmentScores($groupResponses);
            $categoryScores[$category] = [
                'score' => $scoreData['overallScore'],
                'total' => $groupResponses->count(),
                'correct' => $groupResponses->where('is_correct', true)->count(),
            ];
        }

        return $categoryScores;
    }

    /**
     * Helper: Apply sort to attempts
     */
    private function applySort($attempts, $sort)
    {
        return match ($sort) {
            'terbaru' => $attempts->sortByDesc('date'),
            'tertua' => $attempts->sortBy('date'),
            'skor-tinggi' => $attempts->sortByDesc('score'),
            'skor-rendah' => $attempts->sortBy('score'),
            default => $attempts,
        };
    }

    /**
     * Helper: Get category from score
     */
    private function getCategoryFromScore($score)
    {
        if ($score >= 70) return 'Tinggi';
        if ($score >= 50) return 'Sedang';
        return 'Rendah';
    }

    /**
     * Helper: Calculate weighted assessment scores
     */
    private function calculateAssessmentScores($responses)
    {
        $likertScores = [];
        $maxLikertScore = [];
        $mcScores = [];
        $mcMaxScores = [];
        $dimensionScores = [];
        $dimensionMaxScores = [];

        foreach ($responses as $response) {
            $question = $response->question;

            if (!$question) {
                continue;
            }

            $dimension = $question->category->name ?? 'Uncategorized';
            $bobot = (float) $response->answer_bobot;

            if ($question->type === 'likert') {
                $maxAnswerBobot = 5;

                if (
                    $question->answerTemplate &&
                    $question->answerTemplate->defaultAnswers->isNotEmpty()
                ) {
                    $maxAnswerBobot = (int) $question->answerTemplate->defaultAnswers->max('bobot');
                }

                $likertScores[$dimension] = ($likertScores[$dimension] ?? 0) + $bobot;
                $maxLikertScore[$dimension] = ($maxLikertScore[$dimension] ?? 0) + $maxAnswerBobot;
            } elseif ($question->type === 'multiple_choice') {
                $mcScores[$dimension] = ($mcScores[$dimension] ?? 0) + $bobot;
                $mcMaxScores[$dimension] = ($mcMaxScores[$dimension] ?? 0) + (int) $question->bobot;
            }

            if ($question->type === 'likert' || $question->type === 'multiple_choice') {
                $dimensionScores[$dimension] = ($dimensionScores[$dimension] ?? 0) + $bobot;
                $dimensionMaxScores[$dimension] = ($dimensionMaxScores[$dimension] ?? 0) +
                    ($question->type === 'likert' ? ($maxAnswerBobot ?? 5) : (int) $question->bobot);
            }
        }

        $dimensionPercents = [];

        foreach ($dimensionMaxScores as $dimension => $maxScore) {
            $score = $dimensionScores[$dimension] ?? 0;

            if ($maxScore <= 0) {
                $dimensionPercents[$dimension] = 0;
                continue;
            }

            if ($maxScore >= 50) {
                $dimensionPercents[$dimension] = round(min(100, ($score / $maxScore) * 100), 2);
            } else {
                $dimensionPercents[$dimension] = round(min(100, $score * 2), 2);
            }
        }

        $totalObtained = array_sum($likertScores) + array_sum($mcScores);
        $totalMaxPossible = array_sum($maxLikertScore) + array_sum($mcMaxScores);

        $overallScore = $totalMaxPossible > 0
            ? (int) round(($totalObtained / $totalMaxPossible) * 100)
            : 0;

        return [
            'overallScore' => $overallScore,
            'category' => $this->getCategoryFromScore($overallScore),
            'dimensionScores' => $dimensionPercents,
            'totalObtained' => $totalObtained,
            'totalMaxPossible' => $totalMaxPossible,
        ];
    }

    /**
     * Helper: Calculate assessment duration
     */
    private function calculateDuration($firstAnswer, $lastAnswer)
    {
        if (!$firstAnswer || !$lastAnswer) {
            return null;
        }

        $minutes = $firstAnswer->created_at->diffInMinutes($lastAnswer->created_at);
        $seconds = $firstAnswer->created_at->diffInSeconds($lastAnswer->created_at) % 60;

        if ($minutes === 0 && $seconds === 0) {
            return "< 1 detik";
        }

        return "{$minutes}m {$seconds}s";
    }
}
