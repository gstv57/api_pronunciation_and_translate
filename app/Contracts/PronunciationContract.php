<?php


namespace App\Contracts;

interface PronunciationContract
{
    public function getAudio(string $word, string $language, $limit): string;
}
