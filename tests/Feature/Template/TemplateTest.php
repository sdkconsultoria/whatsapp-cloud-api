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

    public function test_get_all_templates_filter_by_approved()
    {
        Template::factory()->count(1)->create();
        Template::factory(['status' => 'PENDING'])->count(10)->create();

        $this->get(route('template.index').'?status='.Template::STATUS_APPROVED)
            ->assertJsonCount(1, 'data')
            ->assertStatus(200);
    }

    public function test_get_all_templates_filter_by_name()
    {
        Template::factory()->count(1)->create();
        Template::factory(['status' => 'PENDING'])->count(3)->create();
        $template = Template::factory()->create();

        $this->get(route('template.index').'?name='.$template->name)
            ->assertJsonCount(1, 'data')
            ->assertStatus(200);
    }
}
