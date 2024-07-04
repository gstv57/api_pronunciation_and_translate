<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\GuzzleException;

class AudioDownloaderService
{
    private $client;
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }
    public function download($link, $word)
    {
        try {
            $response = $this->client->request('GET', $link);
            $storagePath = storage_path('app/mp3s/' . $word . '.mp3');
            Storage::disk('local')->put('mp3s/' . $word . '.mp3', $response->getBody()->getContents());

            return $storagePath;
        } catch (Exception $e) {
            Log::error("Erro ao baixar áudio da palavra $word: " . $e->getMessage());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Erro ao fazer requisição para $link: " . $e->getMessage());
            return null;
        }
    }
}
