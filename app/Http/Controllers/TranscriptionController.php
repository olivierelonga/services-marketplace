<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

class TranscriptionController extends Controller
{
    public function transcribe(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        if (!$message->voice_memo_path) {
            return response()->json(['error' => 'Message does not have a voice memo.'], 404);
        }

        $audioFile = storage_path('app/public/' . $message->voice_memo_path);

        // Create the SpeechClient
        $speech = new SpeechClient([
            'key' => env('GOOGLE_SPEECH_API_KEY')
        ]);

        // Create the RecognitionConfig
        $config = new RecognitionConfig([
            'encoding' => AudioEncoding::WEBM_OPUS, // Adjust encoding based on your audio file format
            'sample_rate_hertz' => 48000, // Adjust sample rate based on your audio
            'language_code' => 'en-US' // Adjust language code
        ]);

        // Create the RecognitionAudio
        $audio = (new RecognitionAudio())->setContent(file_get_contents($audioFile));

        // Perform the recognition
        $response = $speech->recognize($config, $audio);
        $results = $response->getResults();

        $transcript = '';
        if ($results) {
            $transcript = $results[0]->getAlternatives()[0]->getTranscript();
        }

        // Save the transcript to the message
        $message->transcript = $transcript;
        $message->save();

        return response()->json([
            'transcript' => $transcript
        ]);
    }
}