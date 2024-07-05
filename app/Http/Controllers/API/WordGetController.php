<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WordInvokeGetRequestValidation;
use App\Http\Resources\WordGetResource;
use App\Models\Word;
use Exception;

class WordGetController extends Controller
{
    public function __invoke(WordInvokeGetRequestValidation $request)
    {

        try {
            $word = Word::where('word_original', $request->query('word'))
                ->with('pronunciations')
                ->firstOrFail();

            return new WordGetResource($word);

        } catch(Exception $exception) {
            return response()->json([
                'message' => 'Error: ' . $exception->getMessage(),
            ], 500);
        }
    }
}
