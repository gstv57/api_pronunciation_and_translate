<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Word;
use Illuminate\Http\Request;
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
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'word_original' => 'required|string',
            'language' => 'required|string|max:2',
            'target_language' => 'required|string|max:5',
        ]);
        try {
            // storage word model
            $word = Word::create($validated);

            // translate word
            $translated = $this->translator->translate($validated['word_original'], $validated['target_language']);

            // link audio
            $audio_path = $this->pronunciation->getAudio($validated['word_original'], $validated['language'], 1);

            // download audio
            $audio_content = $this->audio_downloader->download($audio_path, $validated['word_original']);

            // storage s3
            $audio_path = $this->saveAudioToS3($audio_content, $validated['word_original']);

            // update word model
            $word->update([
                'word_translated' => $translated,
            ]);

            $word->pronunciations()->create([
                'path_audio' => $audio_path,
            ]);

            $path_audio_s3 = Storage::disk('s3')->temporaryUrl($audio_path, now()->addMinutes(5));

            return response()->json([
                'word_translated' => $translated,
                'audio_path' => $path_audio_s3,
                'message' => 'Pronunciation link with expiration time of 5 minutes. Enjoy and listen!'
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
