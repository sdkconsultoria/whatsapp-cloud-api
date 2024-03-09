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

    public function uploadFile(string $file)
    {
        $this->validate($file);
        $this->createUploadSession();
        $this->uploadOrFail();

        return $this;
    }

    private function validate(string $file)
    {
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
        $appId = config('meta.app_id');
        $url = $this->graph_url."{$appId}/uploads";
        $url .= '?file_length='.$this->file_size;
        $url .= '&file_type='.$this->mime_type;
        $url .= '&file_name=myprofile.jpg';
        $url .= '&access_token='.config('meta.token');

        $response = Http::post($url)->throw()->json();
        $this->session_id = $response['id'];
    }

    private function uploadOrFail(string $offset = '0')
    {
        $url = $this->graph_url.$this->session_id;

        $response = Http::withHeaders([
            'Authorization' => 'OAuth '.config('meta.token'),
            'file_offset' => $offset,
        ])->withBody(file_get_contents($this->file), $this->mime_type)
            ->post($url)->throw()->json();

        if (! isset($response['h'])) {
            throw new Exception(json_encode($response));
        }

        $this->handler = $response['h'];
    }
}
