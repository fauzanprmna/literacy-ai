<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'deskripsi_id' => ['nullable', 'string'],
            'deskripsi_en' => ['nullable', 'string'],
            'bobot' => ['nullable', 'integer'],
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

                // Minimal salah satu bahasa untuk deskripsi harus diisi
                if (!$this->filled('deskripsi_id') && !$this->filled('deskripsi_en')) {
                    $validator->errors()->add('deskripsi', 'Minimal salah satu deskripsi bahasa harus diisi.');
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'name_id.string' => 'Nama kategori (Indonesia) harus berupa teks.',
            'name_id.max' => 'Nama kategori (Indonesia) maksimal 255 karakter.',
            'name_en.string' => 'Category name (English) must be a string.',
            'name_en.max' => 'Category name (English) max 255 characters.',
            'deskripsi_id.string' => 'Deskripsi (Indonesia) harus berupa teks.',
            'deskripsi_en.string' => 'Description (English) must be a string.',
            'bobot.integer' => 'Bobot harus berupa angka.',
        ];
    }
}
