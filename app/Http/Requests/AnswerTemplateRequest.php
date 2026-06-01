<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_id' => ['nullable', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'default_answers' => ['nullable', 'array'],
            'default_answers.*.name_id' => ['nullable', 'string'],
            'default_answers.*.name_en' => ['nullable', 'string'],
            'default_answers.*.bobot' => ['nullable', 'integer'],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                // Minimal salah satu bahasa untuk nama harus diisi
                if (!$this->filled('name_id') && !$this->filled('name_en')) {
                    $validator->errors()->add('name', 'Minimal salah satu bahasa (Indonesia atau English) untuk nama harus diisi.');
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'name_id.required' => 'Nama template (Indonesia) wajib diisi.',
            'name_id.string' => 'Nama template (Indonesia) harus berupa teks.',
            'name_id.max' => 'Nama template (Indonesia) tidak boleh lebih dari 255 karakter.',
            'name_en.required' => 'Template name (English) is required.',
            'name_en.string' => 'Template name (English) must be a string.',
            'name_en.max' => 'Template name (English) max 255 characters.',
        ];
    }
}
