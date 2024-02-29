<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MediaManagerService extends FacebookService
{
    public function download(string $mediaId, string $phoneNumberId, string $filename, string $disk = 'local')
    {
        $media = $this->getMediaUrl($mediaId, $phoneNumberId);
        $this->downloadMedia($media['url'], $filename);
    }

    private function getMediaUrl(string $mediaId, string $phoneNumberId): array
    {
        $url = "{$this->graph_url}{$mediaId}?phone_number_id={$phoneNumberId}";
        $response = Http::withToken(config('meta.token'))->get($url);

        return $response->json();
    }

    private function downloadMedia(string $mediaUrl, string $filename, string $disk = 'local'): Response
    {
        $response = Http::withToken(config('meta.token'))->get($mediaUrl);

        $extension = str_replace('inline;filename=File', '', $response->getHeaders()['Content-Disposition'][0]);

        Storage::disk($disk)->put("$filename$extension", $response->getBody()->getContents());

        return $response;
    }
}
