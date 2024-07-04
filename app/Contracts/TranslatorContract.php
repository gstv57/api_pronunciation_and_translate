<?php

namespace App\Contracts;

interface TranslatorContract
{
    public function translate(string $word, string $language): string;
}
