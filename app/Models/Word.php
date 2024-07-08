<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    protected $fillable = [
        'language',
        'word_original',
        'word_translated',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pronunciations(): hasMany
    {
        return $this->hasMany(Pronunciation::class);
    }
    public function wordWrongs()
    {
        return $this->belongsToMany(Word::class, 'word_wrong_word');
    }
}
