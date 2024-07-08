<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WordWrong extends Model
{
    use HasFactory;
    public function words()
    {
        return $this->belongsToMany(Word::class, 'word_wrong_word');
    }
    public static function getWordWrong(int $quantity, string $correct_word): Collection
    {
        return self::query()
            ->where('content', '!=', $correct_word)
            ->inRandomOrder()
            ->limit($quantity)
            ->get();
    }
}
