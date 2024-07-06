<?php

namespace App\Jobs;

use App\Contracts\FetchWordRandomContract;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\{Http, Log};

class FetchWordAndStorage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    private $generator;
    public function __construct()
    {
        $this->generator = app(FetchWordRandomContract::class);
    }

    public function handle(): void
    {
        try {
            for (
                $i = 0;
                $i < 10;
                $i++
            ){
                $response = Http::withOptions([
                    'verify'      => false,
                ])->post("http://127.0.0.1:8000/api/words", [
                    "word_original"   => $this->getWord(),
                    "target_language" => "pt-BR",
                ]);
                echo print_r($response->json(), true);
            }

        } catch (Exception $e) {
            Log::warning($e->getMessage());
        }
    }
    private function getWord(): string
    {
        return $this->generator->fetchWordRandom();
    }
}
