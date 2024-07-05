<?php

namespace App\Services;

use App\Contracts\PronunciationContract;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PronunciationService implements PronunciationContract
{
    private $api_key;

    private $proxy;
    public function __construct()
    {
        $this->api_key = getenv('FORVO_API_KEY');
        $this->proxy   = getenv('PROXYSCRAPE');
    }

    public function getAudio(string $word, string $language, $limit = 1): string
    {
        $url    = "https://apifree.forvo.com/key/{$this->api_key}/format/json/action/word-pronunciations/word/{$word}/language/{$language}/limit/{$limit}";
        $guzzle = new Client();

        try {
            $response = $guzzle->get($url, [
                'headers' => [
                    'User-Agent' => 'insomnia/9.2.0',
                ],
                'proxy' => $this->proxy,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['items'][0]['pathmp3'];

        } catch (Exception $e) {
            return 'error function:' . $e->getMessage();
        } catch (GuzzleException $e) {
            return 'error guzzle:' . $e->getMessage();
        }
    }
}
