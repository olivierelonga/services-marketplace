<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Google\Cloud\Translate\V2\TranslateClient;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Illuminate\Support\Facades\Storage;

class TranslationController extends Controller
{
    public function translate(Request $request, $id)
    {
        $request->validate([
            'target_language' => 'required|string',
        ]);

        $message = Message::findOrFail($id);
        $targetLanguage = $request->input('target_language');

        // Initialize the TranslateClient
        $translate = new TranslateClient([
            'key' => env('GOOGLE_TRANSLATE_API_KEY')
        ]);

        // Translate the message body
        $translation = $translate->translate($message->body, [
            'target' => $targetLanguage
        ]);

        $translatedText = $translation['text'];

        $translatedAudioPath = null;
        if ($message->voice_memo_path) {
            // If the message has a voice memo, translate the transcript and generate audio

            // 1. Get the transcript
            $transcript = $message->transcript;
            if (!$transcript) {
                // If the transcript is not available, you might want to generate it here
                // For simplicity, we assume the transcript is already generated.
            }

            // 2. Translate the transcript
            $translatedTranscript = $translate->translate($transcript, [
                'target' => $targetLanguage
            ])['text'];

            // 3. Use Text-to-Speech to generate audio
            $textToSpeech = new TextToSpeechClient([
                'key' => env('GOOGLE_TTS_API_KEY')
            ]);

            $input = (new SynthesisInput())->setText($translatedTranscript);
            $voice = (new VoiceSelectionParams())
                ->setLanguageCode($targetLanguage)
                ->setSsmlGender(1);
            $audioConfig = (new AudioConfig())->setAudioEncoding(AudioEncoding::MP3);

            $response = $textToSpeech->synthesizeSpeech($input, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();

            // 4. Save the translated audio
            $translatedAudioFileName = 'translated_voice_' . time() . '_' . $message->id . '.mp3';
            $translatedAudioPath = 'translated-audios/' . $translatedAudioFileName;
            
            
            Storage::disk('public')->put($translatedAudioPath, $audioContent);

        }

        return response()->json([
            'translated_text' => $translatedText,
            'translated_audio_path' => $translatedAudioPath ? asset('storage/' . $translatedAudioPath) : null,
        ]);
    }
}