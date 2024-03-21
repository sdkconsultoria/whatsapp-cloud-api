<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WabaTest extends TestCase
{
    use WithFaker;

    public function test_get_wabas()
    {
        Waba::factory()->create();

        $this->get(route('waba.index'))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
