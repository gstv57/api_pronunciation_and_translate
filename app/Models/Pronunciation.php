<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pronunciation extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'word_id'
    ];

    protected $fillable = ['path_audio'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
