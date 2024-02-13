<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class TemplateTest extends TestCase
{
    public function test_get_all_templates()
    {
        $this->get(route('template.index'))
            ->assertStatus(200);
    }
}
