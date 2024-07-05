<?php

namespace App\Services;

use DeepL\Translator;
use DeepL\DeepLException;
use Illuminate\Support\Facades\Log;
use App\Contracts\TranslatorContract;

class TranslatorService implements TranslatorContract
{
    private $api_key;
    protected Translator $instance;

    public function __construct()
    {
        $this->api_key = getenv('DEEPL_API_KEY');
        try {
            $this->instance = new Translator($this->api_key);
        } catch (\Exception $exception) {
            Log::warning('DeepL instance could not be created.. debug and try again');
            throw new \Exception($exception->getMessage());
        }
    }
    public function translate(string $word, string $language_target): array
    {
        try {
            $translate = $this->instance->translateText(
                [$word],
                null,
                $language_target,
            );

            return [
                'text' => $translate[0]->text,
                'detect_language' => $translate[0]->detectedSourceLang,
            ];

        } catch (DeepLException $e) {
            Log::warning('Translate Error: ' . $e->getMessage());
            return [
                'text' => 'error',
                'detect_language' => 'error',
            ];
        }
    }
}
