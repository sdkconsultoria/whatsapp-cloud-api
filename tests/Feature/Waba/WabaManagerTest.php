<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaManagerTest extends TestCase
{
    use FakeWabaResponses;

    public function test_get_waba_info()
    {
        $wabaId = '104996122399160';
        $wabaFakeInfo = $this->getFakeWabaInfo();

        Http::fake([
            '*' . $wabaId => Http::response($wabaFakeInfo, 200),
        ]);

        $service = resolve(WabaManagerService::class);
        $service->getWabaInfo($wabaId);

        $this->assertDatabaseHas('wabas', [
            'waba_id' => $wabaFakeInfo['id'],
            'name' => $wabaFakeInfo['name'],
            'timezone_id' => $wabaFakeInfo['timezone_id'],
            'message_template_namespace' => $wabaFakeInfo['message_template_namespace'],
        ]);
    }

    public function test_get_phone_numbers_from_waba()
    {
        $service = resolve(WabaManagerService::class);
        // $service->getPhoneNumbers('121544050937574');
    }


    // public function test_subscribe_waba()
    // {
    //     $service = resolve(WabaManagerService::class);
    //     $service->subscribeWaba('WABA_ID');
    // }

    // public function test_get_all_wabas()
    // {
    //     $service = resolve(WabaManagerService::class);
    //     $service->getAllWabas();
    // }
}
