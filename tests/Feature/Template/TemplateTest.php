<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class TemplateTest extends TestCase
{
    public function test_get_all_templates()
    {
        Template::factory()->count(10)->create();

        $this->get(route('template.index'))
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }
}
