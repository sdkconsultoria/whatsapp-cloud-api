<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Template;

use Illuminate\Http\UploadedFile;

class FakeCreateTemplate
{
    public static function textTemplate($waba)
    {
        return [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'components' => [
                'BODY' => [
                    'text' => 'Hello World',
                ],
            ],
        ];
    }

    public static function buttonsFooterBodyVarsTemplate($waba)
    {
        return [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'components' => [
                'BODY' => [
                    'text' => 'Hi {{1}}! For can get our {{2}} for as low as {{3}} for more information.',
                    'example' => [
                        'body_text' => [
                            [
                                'Mark', 'Tuscan Getaway package', '800',
                            ],
                        ],
                    ],
                ],
                'FOOTER' => [
                    'text' => 'Shop now through to get of all merchandise.',
                ],
                'BUTTONS' => [
                    [
                        'type' => 'QUICK_REPLY',
                        'text' => 'Unsubcribe from Promos',
                    ],
                    [
                        'type' => 'PHONE_NUMBER',
                        'text' => 'Call',
                        'phone_number' => '15550051310',
                    ],
                    [
                        'type' => 'URL',
                        'text' => 'Shop Now',
                        'url' => 'https://www.examplesite.com/shop?promo={{1}}',
                        'example' => [
                            'summer2023',
                        ],
                    ],

                ],
            ],
        ];
    }

    public static function imageHeaderTemplate($waba)
    {
        $file = UploadedFile::fake()->create('file.jpg');

        return [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'components' => [
                'HEADER' => [
                    'format' => 'IMAGE',
                    'example' => [
                        'header_handle' => [$file],
                    ],
                ],
                'BODY' => [
                    'text' => 'Shop now through to get of all merchandise.',
                ],
            ],
        ];
    }
}
