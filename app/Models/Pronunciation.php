<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Pronunciation extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'word_id',
    ];
    protected $fillable = ['path_audio'];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
    protected function getPronunciationPathS3Attribute(): string
    {
        return Storage::disk('s3')->temporaryUrl($this->path_audio, now()->addMinutes(15));
    }

}
