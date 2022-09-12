<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ResumableUploadAPI extends FacebookService
{
    public static function uploadFile(string $file)
    {
        if (file_exists($file)) {
            $object = new self();
            $session = $object->createUploadSessionAndReturn($file);
            return $object->initiateUploadoRfAIL($file, $session['id']);
        } else {
            throw new Exception("El archivo {$file} no existe.");
        }
    }

    private function createUploadSessionAndReturn(string $file)
    {
        $url = $this->graph_url . config('facebook.app_id') . "/uploads";
        $url .= '?file_length='.filesize($file);
        $url .= '&file_type='.mime_content_type($file);
        $url .= '&access_token='.config('facebook.app_token');

        return Http::post($url)->throw()->json();
    }

    private function initiateUploadoRfAIL(string $file, string $session_id, string $offset = '0')
    {
        $url = $this->graph_url . $session_id;

        $response = Http::withHeaders([
            'Authorization' => 'OAuth '. config('facebook.app_token'),
            'file_offset' => $offset
        ])->withBody(file_get_contents($file), mime_content_type($file))
        ->post($url)->throw()->json();

        if (isset($response['h'])) {
            return $response;
        }

        throw new Exception(json_encode($response));
    }
}
