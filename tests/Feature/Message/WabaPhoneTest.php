<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaPhoneTest extends TestCase
{
    use WithFaker;

    public function test_get_all_waba_numbers()
    {
        WabaPhone::factory()->count(10)->create();

        $this->get(route('waba.waba_number'))
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }

    public function test_get_all_waba_numbers_filter_by_waba()
    {
        $waba = Waba::factory()->create();
        WabaPhone::factory()->count(10)->create();
        WabaPhone::factory(['waba_id' => $waba->id])->count(5)->create();
        WabaPhone::factory()->count(10)->create();

        $this->get(route('waba.waba_number')."?waba_id=$waba->id")
            ->assertJsonCount(5, 'data')
            ->assertStatus(200);
    }
}