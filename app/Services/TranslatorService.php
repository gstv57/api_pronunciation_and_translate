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
    public function translate(string $word, string $language_target): string
    {
        // word: hello world
        // targetLang: pt-BR, en-US
        try {
            $translate = $this->instance->translateText(
                [$word],
                null,
                $language_target,
            );

            return $translate[0]->text;
        } catch (DeepLException $e) {
            Log::warning('Translate Error: ' . $e->getMessage());
            return 'Error translating word..';
        }
    }
}
