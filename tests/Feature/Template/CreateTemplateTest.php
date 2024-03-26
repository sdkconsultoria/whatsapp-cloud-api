<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Template\FakeCreateTemplate;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Template\FakeTemplateToMetaFormat;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class CreateTemplateTest extends TestCase
{
    use WithFaker;

    public function test_create_text_template()
    {
        $waba = Waba::factory()->create();
        $templateId = $this->faker()->uuid;
        $templateRequest = FakeCreateTemplate::textTemplate($waba);
        $templateMetaFormat = FakeTemplateToMetaFormat::convert($templateRequest, $templateId);

        Http::fake([
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $templateId,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
            "*/$templateId" => Http::response($templateMetaFormat),
        ]);

        $this->post(route('template.store'), $templateRequest)->assertStatus(201);
        $this->assertDatabase($waba);
    }

    public function test_create_template_with_buttons_footer_buttons()
    {
        $waba = Waba::factory()->create();
        $templateId = $this->faker()->uuid;
        $templateRequest = FakeCreateTemplate::buttonsFooterBodyVarsTemplate($waba);
        $templateMetaFormat = FakeTemplateToMetaFormat::convert($templateRequest, $templateId);

        Http::fake([
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $templateId,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
            "*/$templateId" => Http::response($templateMetaFormat),
        ]);

        $this->post(route('template.store'), $templateRequest)->assertStatus(201);
        $this->assertDatabase($waba);
    }

    public function test_create_template_with_image_header()
    {
        $sessionId = $this->faker()->uuid;
        $waba = Waba::factory()->create();
        $templateId = $this->faker()->uuid;
        $templateRequest = FakeCreateTemplate::imageHeaderTemplate($waba);
        $templateMetaFormat = FakeTemplateToMetaFormat::convert($templateRequest, $templateId);
        $templateMetaFormat['components'][0]['example']['header_handle'] = ['4::aW1hZ2U6Ly9pb'];

        Http::fake([
            "*/$templateId" => Http::response($templateMetaFormat),
            '*/uploads*' => Http::response(['id' => $sessionId]),
            "*/$sessionId" => Http::response(['h' => $this->faker()->uuid]),
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $templateId,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
        ]);

        Storage::fake('local');
        $this->post(route('template.store'), $templateRequest)->assertStatus(201);
        $this->assertDatabase($waba);
    }

    private function assertDatabase(Waba $waba)
    {
        return $this->assertDatabaseHas('templates', [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'status' => 'PENDING',
        ]);
    }
}
