<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WordGetByQuantityRequest;
use App\Http\Resources\WordGetByQuantityResource;
use App\Models\Word;
use Illuminate\Http\Request;

class WordGetByQuantity extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(WordGetByQuantityRequest $request)
    {
        $quantity = (int) $request->quantity;

        $words = Word::with('pronunciations')
            ->inRandomOrder()
            ->limit($quantity)
            ->get();

        return WordGetByQuantityResource::collection($words);
    }
}
