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
        'id',
        'created_at',
        'updated_at',
    ];

    public function pronunciations(): hasMany
    {
        return $this->hasMany(Pronunciation::class);
    }
}
