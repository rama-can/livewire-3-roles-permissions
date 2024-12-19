<?php

namespace App\Services\Translation;

class TranslationServiceImplement implements TranslationService
{
    protected $translator;

    public function __construct()
    {
        $authKey = env('DEEPL_AUTH_KEY');
        $this->translator = new \DeepL\Translator($authKey);
    }

    /**
     * Translate a text to the target language.
     *
     * @param string $text
     * @param string|null $sourceLang
     * @param string $targetLang
     * @return string
     */
    public function translate(string $text, ?string $sourceLang = null, string $targetLang = 'en-GB'): string
    {
        return $this->translator->translateText($text, $sourceLang, $targetLang)->text;
    }
}
