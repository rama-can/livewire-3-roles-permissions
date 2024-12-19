<?php

namespace App\Services\Translation;

interface TranslationService
{
    public function translate(string $text, ?string $sourceLang = null, string $targetLang = 'en-GB'): string;
}
