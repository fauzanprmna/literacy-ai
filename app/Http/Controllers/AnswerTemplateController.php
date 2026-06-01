<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerTemplateRequest;
use App\Models\AnswerTemplate;
use App\Models\AnswerTemplateTranslation;
use App\Models\DefaultAnswer;
use App\Models\DefaultAnswerTranslation;
use App\Services\TranslationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnswerTemplateController extends Controller
{
    public function __construct(protected TranslationService $translator) {}

    public function index(): View
    {
        $templates = AnswerTemplate::query()
            ->latest()
            ->paginate(10);

        return view('answer-template.index', compact('templates'));
    }

    public function create(): View
    {
        return view('answer-template.create');
    }

    public function store(AnswerTemplateRequest $request): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
            ],
            'en' => [
                'name' => $request->name_en,
            ],
        ];

        // Get translated data
        $translatedData = $this->translator->answerTranslations($rawData);

        // Create template with Indonesian name
        $template = AnswerTemplate::create([
            'name' => $translatedData['id']['name'],
        ]);

        // Save translations for both locales
        foreach ($translatedData as $locale => $fields) {
            $template->translations()->create([
                'locale' => $locale,
                'name' => $fields['name'],
            ]);
        }

        // Create default answers if provided
        $defaultAnswers = $request->input('default_answers', []);
        foreach ($defaultAnswers as $answer) {
            $answerData = [
                'id' => [
                    'name' => $answer['name_id'] ?? null,
                ],
                'en' => [
                    'name' => $answer['name_en'] ?? null,
                ],
            ];

            // Get translated data
            $translatedAnswer = $this->translator->answerDefaultTranslations($answerData);

            $da = DefaultAnswer::create([
                'id_answer_template' => $template->id,
                'name' => $translatedAnswer['id']['name'],
                'bobot' => $answer['bobot'] ?? 0,
            ]);

            if ($da) {
                foreach ($translatedAnswer as $locale => $fields) {
                    $da->translations()->create([
                        'locale' => $locale,
                        'name' => $fields['name'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('answer-template.index')
            ->with('success', 'Template berhasil dibuat.');
    }

    public function show(AnswerTemplate $answerTemplate): View
    {
        return view('answer-template.show', ['template' => $answerTemplate]);
    }

    public function edit(AnswerTemplate $answerTemplate): View
    {
        return view('answer-template.edit', ['template' => $answerTemplate]);
    }

    public function update(AnswerTemplateRequest $request, AnswerTemplate $answerTemplate): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
            ],
            'en' => [
                'name' => $request->name_en,
            ],
        ];

        // Get translated data
        $translatedData = $this->translator->answerTranslations($rawData);

        // Update template with Indonesian name
        $answerTemplate->update(['name' => $translatedData['id']['name']]);

        // Update translations for both locales
        AnswerTemplateTranslation::updateOrCreate(
            ['answer_template_id' => $answerTemplate->id, 'locale' => 'id'],
            ['name' => $translatedData['id']['name']]
        );
        AnswerTemplateTranslation::updateOrCreate(
            ['answer_template_id' => $answerTemplate->id, 'locale' => 'en'],
            ['name' => $translatedData['en']['name']]
        );

        // Sync default answers if provided
        if ($request->has('default_answers')) {
            $answerTemplate->defaultAnswers()->delete();
            foreach ($request->input('default_answers', []) as $answer) {
                $answerData = [
                    'id' => [
                        'name' => $answer['name_id'] ?? null,
                    ],
                    'en' => [
                        'name' => $answer['name_en'] ?? null,
                    ],
                ];

                // Get translated data
                $translatedAnswer = $this->translator->answerDefaultTranslations($answerData);

                $da = DefaultAnswer::create([
                    'id_answer_template' => $answerTemplate->id,
                    'name' => $translatedAnswer['id']['name'],
                    'bobot' => $answer['bobot'] ?? 0,
                ]);
                if ($da) {
                    DefaultAnswerTranslation::updateOrCreate(
                        ['default_answer_id' => $da->id, 'locale' => 'id'],
                        ['name' => $translatedAnswer['id']['name']]
                    );
                    DefaultAnswerTranslation::updateOrCreate(
                        ['default_answer_id' => $da->id, 'locale' => 'en'],
                        ['name' => $translatedAnswer['en']['name']]
                    );
                }
            }
        }

        return redirect()
            ->route('answer-template.index')
            ->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(AnswerTemplate $answerTemplate): RedirectResponse
    {
        $answerTemplate->delete();

        return redirect()
            ->route('answer-template.index')
            ->with('success', 'Template berhasil dihapus.');
    }
}
