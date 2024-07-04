<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pronunciation extends Model
{
    use HasFactory;

    protected $fillable = ['path_audio'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
