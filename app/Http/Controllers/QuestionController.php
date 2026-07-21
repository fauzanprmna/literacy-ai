<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionTranslation;
use App\Models\Answer;
use App\Models\AnswerTranslation;
use App\Services\TranslationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function __construct(protected TranslationService $translator) {}

    public function index(): View
    {
        $questions = Question::query()
            ->with(['category', 'answerTemplate'])
            ->latest()
            ->paginate(10);

        return view('question.index', compact('questions'));
    }

    public function create(): View
    {
        return view('question.create');
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => ['question' => $request->question_id],
            'en' => ['question' => $request->question_en],
        ];

        $translatedData = $this->translator->questionTranslations($rawData);

        $question = Question::create([
            'id_kategori'       => $request->id_kategori,
            'id_answer_template' => $request->id_answer_template ?? null,
            'type'              => $request->type ?? 'text',
            'bobot'             => $request->bobot,
        ]);

        // Save translations for both locales
        foreach ($translatedData as $locale => $fields) {
            $question->translations()->create([
                'locale'   => $locale,
                'question' => $fields['question'],
                'header'   => $request->input("header_{$locale}") ?? null,
            ]);
        }

        // Handle multiple choice answers
        if (($request->type ?? '') === 'multiple_choice') {
            $this->saveMcAnswers($question, $request);
        }

        return redirect()
            ->route('question.index')
            ->with('success', 'Pertanyaan berhasil dibuat.');
    }

    public function show(Question $question): View
    {
        return view('question.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        $question->load(['translations', 'answers.translations']);
        return view('question.edit', compact('question'));
    }

    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $rawData = [
            'id' => ['question' => $request->question_id],
            'en' => ['question' => $request->question_en],
        ];

        $translatedData = $this->translator->questionTranslations($rawData);

        $question->update([
            'id_kategori'       => $request->id_kategori,
            'id_answer_template' => $request->id_answer_template ?? null,
            'question'          => $translatedData['id']['question'],
            'type'              => $request->type ?? $question->type,
            'bobot'             => $request->bobot,
        ]);

        // Update translations for both locales
        QuestionTranslation::updateOrCreate(
            ['question_id' => $question->id, 'locale' => 'id'],
            ['question' => $translatedData['id']['question'], 'header' => $request->header_id ?? null]
        );
        QuestionTranslation::updateOrCreate(
            ['question_id' => $question->id, 'locale' => 'en'],
            ['question' => $translatedData['en']['question'], 'header' => $request->header_en ?? null]
        );

        // Selalu hapus jawaban lama terlebih dahulu
        $question->answers()->delete();

        if (($request->type ?? '') === 'multiple_choice') {
            $this->saveMcAnswers($question, $request);
        }
        // Jika bukan MC, answers sudah terhapus di atas (konsisten)

        return redirect()
            ->route('question.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()
            ->route('question.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }

    // ─────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────

    /**
     * Simpan 4 jawaban pilihan ganda untuk sebuah soal.
     * is_correct ditentukan dari checkbox "Benar" di form.
     * bobot = 1 jika benar, 0 jika salah (digunakan sebagai fallback legacy).
     */
    private function saveMcAnswers(Question $question, $request): void
    {
        $mcAnswersId = $request->input('mc_answers_id', []);
        $mcAnswersEn = $request->input('mc_answers_en', []);
        $mcCorrect   = $request->input('mc_correct', []);   // array index yang benar, e.g. ["0","2"]

        for ($i = 0; $i < 4; $i++) {
            $answerData = [
                'id' => ['name' => $mcAnswersId[$i] ?? null],
                'en' => ['name' => $mcAnswersEn[$i] ?? null],
            ];

            $translatedAnswer = $this->translator->answerTranslations($answerData);

            $isCorrect = in_array((string) $i, (array) $mcCorrect);

            $answer = Answer::create([
                'id_question' => $question->id,
                'name'        => $translatedAnswer['id']['name'] ?? '',
                // bobot = nilai soal jika benar, 0 jika salah
                // ini yang akan disimpan ke user_answers.answer_bobot saat kuesioner
                'bobot'       => $isCorrect ? (int) $question->bobot : 0,
                'is_correct'  => $isCorrect,
            ]);

            if ($answer) {
                AnswerTranslation::updateOrCreate(
                    ['answer_id' => $answer->id, 'locale' => 'id'],
                    ['name' => $translatedAnswer['id']['name'] ?? '']
                );
                AnswerTranslation::updateOrCreate(
                    ['answer_id' => $answer->id, 'locale' => 'en'],
                    ['name' => $translatedAnswer['en']['name'] ?? '']
                );
            }
        }
    }
}
