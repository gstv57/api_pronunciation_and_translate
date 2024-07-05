<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\WordInvokeRequestValidation;
use Exception;
use App\Models\Word;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Contracts\TranslatorContract;
use Illuminate\Support\Facades\Storage;
use App\Contracts\PronunciationContract;
use App\Services\AudioDownloaderService;

class WordController extends Controller
{
    protected $translator;
    protected $pronunciation;
    protected $audio_downloader;
    public function __construct()
    {
        $this->translator = app(TranslatorContract::class);
        $this->pronunciation = app(PronunciationContract::class);
        $this->audio_downloader  = new AudioDownloaderService();
    }
    public function __invoke(WordInvokeRequestValidation $request)
    {
        try {
            // translate word
            $translated = $this->translator->translate($request->input('word_original'), $request->input('target_language'));

            // link audio pronunciation
            $audio_path = $this->pronunciation->getAudio($request->input('word_original'), $translated['detect_language'], 1);

            // download audio local
            $audio_content = $this->audio_downloader->download($audio_path, $request->input('word_original'));

            // storage s3 and get name file
            $audio_path = $this->saveAudioToS3($audio_content, $request->input('word_original'));

            // storage word model and pronunciation
            $word = Word::create([
                'word_original' => $request->input('word_original'),
                'language' => $translated['detect_language'],
                'word_translated' => $translated['text'],
            ]);
            $word->pronunciations()->create([
                'path_audio' => $audio_path,
            ]);

            $path_audio_s3 = Storage::disk('s3')->temporaryUrl($audio_path, now()->addMinutes(15));

            return response()->json([
                'word_translated' => $translated['text'],
                'audio_path' => $path_audio_s3,
                'message' => 'Pronunciation link with expiration time of 15 minutes. Enjoy and listen!'
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    private function saveAudioToS3($audioPath, $word): ?string
    {
        try {
            $fileName = $word . '.mp3';
            Storage::disk('s3')->put($fileName, file_get_contents($audioPath));

            return $fileName;
        } catch (Exception $e) {
            Log::error("Erro ao salvar áudio $fileName no S3: " . $e->getMessage());
            return null;
        }
    }
}
