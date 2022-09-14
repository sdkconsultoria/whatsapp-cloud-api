<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ResumableUploadAPI extends FacebookService
{
    public $mime_type;
    public $file_size;
    public $file;
    public $session_id;
    public $handler;

    public static function uploadFile(string $file)
    {
        $object = new self($file);
        $object->createUploadSession();
        $object->uploadOrFail();

        return $object;
    }

    function __construct(string $file) {
        if (file_exists($file)) {
            $this->file = $file;
            $this->mime_type = mime_content_type($file);
            $this->file_size = filesize($file);
        } else {
            throw new Exception("El archivo {$file} no existe.");
        }
    }

    private function createUploadSession(): void
    {
        $url = $this->graph_url . config('facebook.app_id') . "/uploads";
        $url .= '?file_length='.$this->file_size;
        $url .= '&file_type='.$this->mime_type;
        $url .= '&access_token='.config('facebook.app_token');

        $response = Http::post($url)->throw()->json();
        $this->session_id = $response['id'];
    }

    private function uploadOrFail(string $offset = '0')
    {
        $url = $this->graph_url . $this->session_id;

        $response = Http::withHeaders([
            'Authorization' => 'OAuth '. config('facebook.app_token'),
            'file_offset' => $offset
        ])->withBody(file_get_contents($this->file), $this->mime_type)
        ->post($url)->throw()->json();

        if (!isset($response['h'])) {
            throw new Exception(json_encode($response));
        }

        $this->handler = $response['h'];
    }
}
