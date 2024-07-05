<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
                    'link'    => Storage::disk('s3')->temporaryUrl($pronunciation->path_audio, now()->addMinutes(15)),
                    'expires' => now()->addMinutes(15)->format('d-m-y H:i:s'),
                ];
            }),
        ];
    }
}
