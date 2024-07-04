<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'language',
        'word_original',
        'word_translated',
    ];

    public function pronunciations()
    {
        return $this->hasMany(Pronunciation::class);
    }
}
