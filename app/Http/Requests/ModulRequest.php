<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModulRequest extends FormRequest
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
            'id_kategori' => ['required', 'exists:categories,id'],
            'id_kategori_modul' => ['nullable', 'exists:kategori_moduls,id'],
            'isi_id' => ['nullable', 'string'],
            'isi_en' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            // New content validation
            'new_content_text' => ['nullable', 'array'],
            'new_content_text.*' => ['nullable', 'string'],
            'new_content_file' => ['nullable', 'array'],
            'new_content_file.*' => ['nullable', 'file', 'max:102400'], // 100MB max
            'new_content_link' => ['nullable', 'array'],
            'new_content_link.*' => ['nullable', 'url'],
            'delete_contents' => ['nullable', 'array'],
            'delete_contents.*' => ['nullable', 'exists:modul_contents,id'],
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

                // Minimal salah satu bahasa untuk isi harus diisi (jika ada)
                if ($this->filled('isi_id') || $this->filled('isi_en')) {
                    if (!$this->filled('isi_id') || !$this->filled('isi_en')) {
                        $validator->errors()->add('isi', 'Jika isi diisi, kedua bahasa harus diisi.');
                    }
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'name_id.required' => 'Nama modul (Indonesia) wajib diisi.',
            'name_id.string' => 'Nama modul (Indonesia) harus berupa teks.',
            'name_id.max' => 'Nama modul (Indonesia) maksimal 255 karakter.',
            'name_en.required' => 'Module name (English) is required.',
            'name_en.string' => 'Module name (English) must be a string.',
            'name_en.max' => 'Module name (English) max 255 characters.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'id_kategori_modul.exists' => 'Kategori modul yang dipilih tidak valid.',
            'link.url' => 'Link harus berupa URL yang valid.',
        ];
    }
}
