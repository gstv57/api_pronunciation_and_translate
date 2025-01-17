<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'word'           => $this->word_original,
            'translated'     => $this->word_translated,
            'language'       => $this->language,
            'pronunciations' => $this->pronunciations->map(function ($pronunciation) {
                return [
                    'link'    => $pronunciation->pronunciationPathS3,
                    'expires' => now()->addMinutes(20)->format('d-m-y H:i:s'),
                ];
            }),
        ];
    }
}
