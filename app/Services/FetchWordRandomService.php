<?php

namespace App\Services;

use App\Contracts\FetchWordRandomContract;
use App\Models\WordWrong;
use GuzzleHttp\Client;

class FetchWordRandomService implements FetchWordRandomContract
{
    public $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    public function fetchWordRandom($quantity)
    {
        try {
            $response = $this->guzzle->post('https://www.invertexto.com/ajax/words.php', [
                'headers' => [
                    'accept'                 => 'application/json, text/javascript, */*; q=0.01',
                    'accept-language'        => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
                    'content-type'           => 'application/x-www-form-urlencoded; charset=UTF-8',
                    'cookie'                 => '_ga=GA1.1.282606079.1719005681; _ga_QJVXDQ96GJ=GS1.1.1719008113.2.1.1719008139.0.0.0; PHPSESSID=ul4gn15dm6nejh0n0p7c65cupg; __gads=ID=ae55297cc92dac26:T=1718992989:RT=1720409132:S=ALNI_MaW3mhv-MVJR2aeJK8XmI9DEz-Zfw; __gpi=UID=00000a2fec2aa424:T=1718992989:RT=1720409132:S=ALNI_MY3RZlylLS94GWGEEpWDrWoj-615A; __eoi=ID=dd0ddbf5bc15c441:T=1718992989:RT=1720409132:S=AA-AfjZ9Ppd8qWE4stkqNCCd2sxG; FCNEC=%5B%5B%22AKsRol_f696rFXT4VQHeng6hCEIZe0dKrbPTnsQYw9x4xAgBgvKY3lXATboNKZsystYVTZSTdyhRYHZc1wrd2qGXRUsGhVp2kaBaeVH_rTl_VAT7wVFJ22_GSEoAufzI3x1A7clOrXAjuQ4LKGAau1FIO0WqqrZL7w%3D%3D%22%5D%5D',
                    'origin'                 => 'https://www.invertexto.com',
                    'priority'               => 'u=1, i',
                    'referer'                => 'https://www.invertexto.com/gerador-palavras-aleatorias',
                    'sec-ch-ua'              => '"Not/A)Brand";v="8", "Chromium";v="126", "Google Chrome";v="126"',
                    'sec-ch-ua-mobile'       => '?0',
                    'sec-ch-ua-platform'     => '"Windows"',
                    'sec-fetch-dest'         => 'empty',
                    'sec-fetch-mode'         => 'cors',
                    'sec-fetch-site'         => 'same-origin',
                    'user-agent'             => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                    'x-kl-saas-ajax-request' => 'Ajax_Request',
                    'x-requested-with'       => 'XMLHttpRequest',
                ],
                'form_params' => [
                    'type'        => '',
                    'num_words'   => "$quantity",
                    'num_letters' => '',
                    'starts_with' => '',
                    'ends_with'   => '',
                ],
                'proxy' => getenv('PROXYSCRAPE'),
            ]);

            $response = json_decode($response->getBody()->getContents(), true);

            if ($response['status'] == 'ok') {
                $result = [];

                foreach ($response['result'] as $word) {
                    $result[] = $word['word'];
                }

                foreach ($result as $wordContent) {
                    $exists = WordWrong::where('content', $wordContent)->exists();

                    if (!$exists) {
                        WordWrong::insert([
                            'content'    => $wordContent,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
