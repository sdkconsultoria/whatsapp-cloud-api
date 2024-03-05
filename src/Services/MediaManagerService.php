<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MediaManagerService extends FacebookService
{
    public function upload(string $phoneNumberId, $file, string $filename = 'sin titulo'): array
    {
        $url = "{$this->graph_url}{$phoneNumberId}/media";

        $response = Http::withToken(config('meta.token'))
            ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName(), ['Content-Type' => $file->getClientMimeType()])
            ->post($url, [
                'filename' => $filename,
                'messaging_product' => 'whatsapp',
            ]);

        return $response->json();
    }

    public function download(string $mediaId, string $phoneNumberId, string $filename, string $disk = 'local'): string
    {
        $media = $this->getMediaUrl($mediaId, $phoneNumberId);

        return $this->downloadMedia($media['url'], $filename, $disk);
    }

    private function getMediaUrl(string $mediaId, string $phoneNumberId): array
    {
        $url = "{$this->graph_url}{$mediaId}?phone_number_id={$phoneNumberId}";
        $response = Http::withToken(config('meta.token'))->get($url);

        return $response->json();
    }

    private function downloadMedia(string $mediaUrl, string $filename, string $disk): string
    {
        $response = Http::withToken(config('meta.token'))->get($mediaUrl);

        $extension = str_replace('inline;filename=File', '', $response->getHeaders()['Content-Disposition'][0]);

        Storage::disk($disk)->put("$filename$extension", $response->getBody()->getContents());

        return Storage::disk($disk)->url("$filename$extension");
    }
}
