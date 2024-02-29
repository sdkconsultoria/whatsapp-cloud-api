<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MediaManagerServiceTest extends TestCase
{
    public function test_get_media_url()
    {
        $this->fakeDownloadFile();
        Storage::fake('local');

        $service = resolve(MediaManagerService::class);
        $service->download('7096261007159140', '104246142661561', 'archivo');

        Storage::disk('local')->assertExists('archivo.jpg');
    }

    private function fakeDownloadFile()
    {
        Http::fake([
            'https://graph.facebook.com/*' => Http::response([
                'url' => 'https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=7096',
                'mime_type' => 'image/jpeg',
                'sha256' => 'b2888367f26694b854d12e1c7895f5402944b70b121370014a610822ea318eb2',
                'file_size' => 21619,
                'id' => '7096261007159140',
                'messaging_product' => 'whatsapp',
            ], 200),
            'https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=7096' => Http::response('file', 200, [
                'Content-Disposition' => 'inline;filename=File.jpg',
            ]),
        ]);
    }
}
