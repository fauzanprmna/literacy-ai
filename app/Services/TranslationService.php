<?php
// app/Services/TranslationService.php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    /**
     * Columns yang perlu ditranslate
     */
    protected array $question = ['question'];
    protected array $answer = ['name'];
    protected array $answerDefault = ['name'];
    protected array $category = ['name', 'description'];
    protected array $modul_content = ['content_id', 'content_en'];


    /**
     * $data = [
     *   'id' => ['question' => '...'],
     *   'en' => ['question' => ''],  // boleh kosong
     * ]
     */
    public function questionTranslations(array $data): array
    {
        $idData = $data['id'] ?? [];
        $enData = $data['en'] ?? [];

        foreach ($this->question as $field) {
            $idValue = trim($idData[$field] ?? '');
            $enValue = trim($enData[$field] ?? '');

            if ($idValue && !$enValue) {
                // ID ada, EN kosong → translate ID ke EN
                $data['en'][$field] = $this->translate($idValue, from: 'id', to: 'en');
            } elseif ($enValue && !$idValue) {
                // EN ada, ID kosong → translate EN ke ID
                $data['id'][$field] = $this->translate($enValue, from: 'en', to: 'id');
            }
            // Kalau dua2nya ada → skip, tidak pakai API
        }

        return $data;
    }

    public function answerTranslations(array $data): array
    {
        $idData = $data['id'] ?? [];
        $enData = $data['en'] ?? [];

        foreach ($this->answer as $field) {
            $idValue = trim($idData[$field] ?? '');
            $enValue = trim($enData[$field] ?? '');

            if ($idValue && !$enValue) {
                // ID ada, EN kosong → translate ID ke EN
                $data['en'][$field] = $this->translate($idValue, from: 'id', to: 'en');
            } elseif ($enValue && !$idValue) {
                // EN ada, ID kosong → translate EN ke ID
                $data['id'][$field] = $this->translate($enValue, from: 'en', to: 'id');
            }
            // Kalau dua2nya ada → skip, tidak pakai API
        }

        return $data;
    }

    public function answerDefaultTranslations(array $data): array
    {
        $idData = $data['id'] ?? [];
        $enData = $data['en'] ?? [];

        foreach ($this->answerDefault as $field) {
            $idValue = trim($idData[$field] ?? '');
            $enValue = trim($enData[$field] ?? '');

            if ($idValue && !$enValue) {
                // ID ada, EN kosong → translate ID ke EN
                $data['en'][$field] = $this->translate($idValue, from: 'id', to: 'en');
            } elseif ($enValue && !$idValue) {
                // EN ada, ID kosong → translate EN ke ID
                $data['id'][$field] = $this->translate($enValue, from: 'en', to: 'id');
            }
            // Kalau dua2nya ada → skip, tidak pakai API
        }

        return $data;
    }

    public function categoryTranslations(array $data): array
    {
        $idData = $data['id'] ?? [];
        $enData = $data['en'] ?? [];

        foreach ($this->category as $field) {
            $idValue = trim($idData[$field] ?? '');
            $enValue = trim($enData[$field] ?? '');

            if ($idValue && !$enValue) {
                // ID ada, EN kosong → translate ID ke EN
                $data['en'][$field] = $this->translate($idValue, from: 'id', to: 'en');
            } elseif ($enValue && !$idValue) {
                // EN ada, ID kosong → translate EN ke ID
                $data['id'][$field] = $this->translate($enValue, from: 'en', to: 'id');
            }
            // Kalau dua2nya ada → skip, tidak pakai API
        }

        return $data;
    }

    public function modulContentTranslations(array $data): array
    {

        $idData = $data['id'] ?? [];
        $enData = $data['en'] ?? [];

        foreach ($this->modul_content as $field) {
            $idValue = trim($idData['content_id'] ?? '');
            $enValue = trim($enData['content_en'] ?? '');


            if ($idValue && !$enValue) {
                // ID ada, EN kosong → translate ID ke EN
                $data['en']['content_en'] = $this->translate($idValue, from: 'id', to: 'en');

            } elseif ($enValue && !$idValue) {
                // EN ada, ID kosong → translate EN ke ID
                $data['id']['content_id'] = $this->translate($enValue, from: 'en', to: 'id');
            }
            // Kalau dua2nya ada → skip, tidak pakai API
        }


        return $data;
    }

    private function translate(string $text, string $from, string $to): string
    {
        $tr = new GoogleTranslate();
        $tr->setSource($from)->setTarget($to);
        return $tr->translate($text) ?? $text;
    }
}
?>