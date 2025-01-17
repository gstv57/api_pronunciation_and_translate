<?php

namespace App\Services;

use App\Contracts\TranslatorContract;
use DeepL\{DeepLException, Translator};
use Exception;
use Illuminate\Support\Facades\Log;

class TranslatorService implements TranslatorContract
{
    private $api_key;

    protected Translator $instance;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->api_key = getenv('DEEPL_API_KEY');

        try {
            $this->instance = new Translator($this->api_key);
        } catch (Exception $exception) {
            throw new Exception('DeepL instance could not be created.. debug: ' . $exception->getMessage());
        }
    }
    public function translate(string $word, string $language_target): array
    {
        try {
            $translate = $this->instance->translateText(
                [strtolower($word)],
                null,
                $language_target,
            );

            return [
                'text'            => $translate[0]->text,
                'detect_language' => $translate[0]->detectedSourceLang,
            ];

        } catch (DeepLException $e) {
            Log::warning('Translate Error: ' . $e->getMessage());

            return [
                'text'            => 'error',
                'detect_language' => 'error',
            ];
        }
    }
}
