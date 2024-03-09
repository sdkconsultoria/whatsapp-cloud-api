<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Waba\FakeWabaResponses;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaPhoneTest extends TestCase
{
    use WithFaker;

    public function test_get_all_waba_numbers()
    {
        WabaPhone::factory()->count(10)->create();

        $this->get(route('waba_phone.waba_number'))
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }

    public function test_get_all_waba_numbers_filter_by_waba()
    {
        $waba = Waba::factory()->create();
        WabaPhone::factory()->count(10)->create();
        WabaPhone::factory(['waba_id' => $waba->id])->count(5)->create();
        WabaPhone::factory()->count(10)->create();

        $this->get(route('waba_phone.waba_number')."?waba_id=$waba->id")
            ->assertJsonCount(5, 'data')
            ->assertStatus(200);
    }

    public function test_get_bussines_profile()
    {
        $wabaPhone = WabaPhone::factory()->create();
        Http::fake([
            "*/$wabaPhone->phone_id/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical" => Http::response(FakeWabaResponses::fakeBussinesProfile(), 200),
        ]);

        $this->get(route('waba_phone.bussines_profile', ['phoneId' => $wabaPhone->phone_id]))->assertStatus(200);
    }

    public function test_set_bussines_profile()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $sessionId = $this->faker()->uuid;
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg');

        Http::fake([
            '*/uploads*' => Http::response(['id' => $sessionId]),
            "*/$sessionId" => Http::response(['h' => $this->faker()->uuid]),
            "*/$wabaPhone->phone_id/whatsapp_business_profile" => Http::response(['success' => true], 200),
            "*/$wabaPhone->phone_id/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical" => Http::response(FakeWabaResponses::fakeBussinesProfile(), 200),
        ]);

        $this->post(route('waba_phone.storage_bussines_profile', ['phoneId' => $wabaPhone->phone_id]), [
            'address' => $wabaPhone['address'],
            'description' => $wabaPhone['description'],
            'vertical' => $wabaPhone['vertical'],
            'about' => $wabaPhone['about'],
            'email' => $wabaPhone['email'],
            'websites' => json_decode($wabaPhone['websites']),
            'picture_profile' => $file,
        ])->assertStatus(200);
    }

    public function test_set_bussines_profile_without_profile_picture()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $sessionId = $this->faker()->uuid;

        Http::fake([
            '*/uploads*' => Http::response(['id' => $sessionId]),
            "*/$sessionId" => Http::response(['h' => $this->faker()->uuid]),
            "*/$wabaPhone->phone_id/whatsapp_business_profile" => Http::response(['success' => true], 200),
            "*/$wabaPhone->phone_id/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical" => Http::response(FakeWabaResponses::fakeBussinesProfile(), 200),
        ]);

        $this->post(route('waba_phone.storage_bussines_profile', ['phoneId' => $wabaPhone->phone_id]), [
            'address' => $wabaPhone['address'],
            'description' => $wabaPhone['description'],
            'vertical' => $wabaPhone['vertical'],
            'about' => $wabaPhone['about'],
            'email' => $wabaPhone['email'],
            'websites' => json_decode($wabaPhone['websites']),
        ])->assertStatus(200);
    }
}
