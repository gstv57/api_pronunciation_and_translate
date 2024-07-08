<?php

namespace App\Http\Resources;

use App\Models\WordWrong;
use Illuminate\Http\Resources\Json\JsonResource;

class WordGetByQuantityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'word'           => $this->word_original,
            'translated'     => $this->word_translated,
            'language'       => $this->language,
            'pronunciations' => $this->pronunciations->map(function ($pronunciation) {
                return [
                    'link'    => $pronunciation->pronunciationPathS3,
                    'expires' => now()->addMinutes(20)->format('d-m-y H:i:s'),
                ];
            }),
            'words_wrongs'   => WordWrong::getWordWrong(4, $this->word_original)->map(function ($word) {
                return [
                    'word'     => $word->content,
                ];
            }),
        ];
    }
}
