<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaManagerTest extends TestCase
{
    use FakeWabaResponses;

    public function test_get_templates_from_waba()
    {
        Http::fake([
            '*' => Http::response($this->fakeTemplates(), 200),
        ]);

        $waba = Waba::factory()->create(['waba_id' => '121544050937574']);
        $this->get(route('waba.loadtemplates', ['wabaId' => $waba->waba_id]))
            ->assertStatus(200);
    }

    public function test_get_waba_info()
    {
        $wabaId = '104996122399160';
        $wabaFakeInfo = $this->getFakeWabaInfo();

        Http::fake(["*$wabaId" => Http::response($wabaFakeInfo, 200)]);

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

    public function test_get_phone_numbers_from_waba()
    {
        $wabaId = '104996122399160';
        Waba::factory()->create(['waba_id' => $wabaId]);
        $wabaPhonesFake = $this->fakePhoneNumbers();

        Http::fake(["*$wabaId/phone_numbers" => Http::response($wabaPhonesFake, 200)]);

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
