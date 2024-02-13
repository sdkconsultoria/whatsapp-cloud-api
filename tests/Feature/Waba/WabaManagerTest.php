<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaManagerTest extends TestCase
{
    use FakeWabaResponses;

    public function test_get_waba_info()
    {
        $wabaId = '104996122399160';
        $wabaFakeInfo = $this->getFakeWabaInfo();

        Http::fake(["*$wabaId" => Http::response($wabaFakeInfo, 200) ]);

        $service = resolve(WabaManagerService::class);
        $service->getWabaInfo($wabaId);

        $this->assertDatabaseHas('wabas', [
            'waba_id' => $wabaFakeInfo['id'],
            'name' => $wabaFakeInfo['name'],
            'timezone_id' => $wabaFakeInfo['timezone_id'],
            'currency' => $wabaFakeInfo['currency'],
            'message_template_namespace' => $wabaFakeInfo['message_template_namespace'],
        ]);
    }

    /**
     * @depends test_get_waba_info
     */
    public function test_get_phone_numbers_from_waba()
    {
        $wabaId = '104996122399160';
        Waba::factory()->create(['waba_id' => $wabaId]);
        $wabaPhonesFake = $this->fakePhoneNumbers();

        Http::fake(["*$wabaId/phone_numbers" => Http::response($wabaPhonesFake, 200) ]);

        $service = resolve(WabaManagerService::class);
        $service->getPhoneNumbers($wabaId);

        foreach ($wabaPhonesFake['data'] as $wabaPhoneFake) {
            $this->assertDatabaseHas('waba_phones', [
                'name' => $wabaPhoneFake['verified_name'],
                'display_phone_number' => $wabaPhoneFake['display_phone_number'],
                'phone_id' => $wabaPhoneFake['id'],
                'quality_rating' => $wabaPhoneFake['quality_rating'],
            ]);
        }
    }

    public function test_set_phone_numbers_profile()
    {

    }
}
