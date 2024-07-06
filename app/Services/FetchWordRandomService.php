<?php

namespace App\Services;

use App\Contracts\FetchWordRandomContract;
use App\Models\Word;
use Exception;
use Illuminate\Support\Facades\Http;

class FetchWordRandomService implements FetchWordRandomContract
{
    /**
     * @throws Exception
     */
    public function fetchWordRandom(): string
    {
        try {
            $url        = "https://www.palabrasaleatorias.com/random-words.php?fs=1&fs2=0&Submit=New+word";
            $i          = 0;
            $tentativas = 5;

            while ($i < $tentativas) {

                $wordExists = Word::where('word_original', 'word')->exists();

                if (!$wordExists) {
                    return strtolower('palavra');
                }
                $i++;
                if($i == $tentativas) {
                    break;
                }
            }

        } catch (Exception $e) {
            throw new Exception('FetchWordRandomService say: ' . $e->getMessage());
        }
        return '';
    }
}
