<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kategori' => ['required', 'exists:categories,id'],
            'question_id' => ['nullable', 'string'],
            'question_en' => ['nullable', 'string'],
            'header_id' => ['nullable', 'string'],
            'header_en' => ['nullable', 'string'],
            'bobot' => ['required', 'integer', 'min:1'],
            'id_answer_template' => ['nullable', 'exists:answer_templates,id'],
            'type' => ['required', 'in:likert,multiple_choice'],
            // multiple choice fields
            'mc_answers_id' => ['nullable', 'array', 'size:4'],
            'mc_answers_id.*' => ['nullable', 'string'],
            'mc_answers_en' => ['nullable', 'array', 'size:4'],
            'mc_answers_en.*' => ['nullable', 'string'],
            'mc_correct' => ['nullable', 'array'],
            'mc_correct.*' => ['nullable'],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                // Minimal salah satu bahasa untuk pertanyaan harus diisi
                if (!$this->filled('question_id') && !$this->filled('question_en')) {
                    $validator->errors()->add('question', 'Minimal salah satu bahasa (Indonesia atau English) untuk pertanyaan harus diisi.');
                }

                // Minimal salah satu bahasa untuk header harus diisi (jika ada)
                if ($this->filled('header_id') || $this->filled('header_en')) {
                    if (!$this->filled('header_id') || !$this->filled('header_en')) {
                        $validator->errors()->add('header', 'Jika header diisi, kedua bahasa harus diisi.');
                    }
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.string' => 'Pertanyaan harus berupa teks.',
            'question_id.required' => 'Pertanyaan (Indonesia) wajib diisi.',
            'question_en.required' => 'Question (English) is required.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.integer' => 'Bobot harus berupa angka.',
            'bobot.min' => 'Bobot minimal 1.',
            'id_answer_template.exists' => 'Template jawaban tidak valid.',
            'type.required' => 'Jenis pertanyaan wajib dipilih.',
            'type.in' => 'Jenis pertanyaan tidak valid.',
            'mc_answers.size' => 'Pilihan ganda harus terdiri dari 4 jawaban.',
        ];
    }
}
