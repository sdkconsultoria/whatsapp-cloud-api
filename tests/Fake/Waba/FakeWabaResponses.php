<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Waba;

class FakeWabaResponses
{
    public static function getFakeWabaInfo()
    {
        return [
            'id' => '104996122399160',
            'currency' => 'USD',
            'name' => 'Lucky Shrub',
            'timezone_id' => '1',
            'message_template_namespace' => '58e6d318_b627_4112_b9c7_2961197553ea',
        ];
    }

    public static function fakePhoneNumbers()
    {
        return [
            'data' => [
                [
                    'verified_name' => "Jasper's Market",
                    'display_phone_number' => '+1 631-555-5555',
                    'id' => '1906385232743451',
                    'quality_rating' => 'GREEN',
                ],
                [
                    'verified_name' => "Jasper's Ice Cream",
                    'display_phone_number' => '+1 631-555-5556',
                    'id' => '1913623884432103',
                    'quality_rating' => 'NA',
                ],
            ],
        ];
    }

    public static function fakeTemplates()
    {
        return [
            'data' => [
                [
                    'name' => 'hello_world',
                    'previous_category' => 'ACCOUNT_UPDATE',
                    'components' => [
                        [
                            'type' => 'HEADER',
                            'format' => 'TEXT',
                            'text' => 'Hello World',
                        ],
                        [
                            'type' => 'BODY',
                            'text' => 'Welcome and congratulations!! This message demonstrates your ability to send a message notification from WhatsApp Business Platform’s Cloud API. Thank you for taking the time to test with us.',
                        ],
                        [
                            'type' => 'FOOTER',
                            'text' => 'WhatsApp Business API Team',
                        ],
                    ],
                    'language' => 'en_US',
                    'status' => 'APPROVED',
                    'category' => 'MARKETING',
                    'id' => '1192339204654487',
                ],
            ],
            'paging' => [
                'cursors' => [
                    'before' => 'MAZDZD',
                    'after' => 'MjQZD',
                ],
            ],
        ];
    }

    public static function fakeBussinesProfile()
    {
        return [
            'data' => [
                [
                    'about' => 'Hey there! I am using WhatsApp.',
                    'address' => 'Aldama #703',
                    'description' => 'Empresa de desarrollo de software, desde ERPS hasta sitios web Ecommerce',
                    'email' => 'ventas@sdkconsultoria.com',
                    'profile_picture_url' => 'https://pps.whatsapp.net/v/t61.24694-24/343259757_536735815203707_3565496183133281608_n.jpg?ccb=11-4&oh=01_AdRPsqmjabi6keV4__SnK7x_dlRYwFb_SicAa46sJkQbsQ&oe=65EFEB2F&_nc_sid=e6ed6c&_nc_cat=106',
                    'websites' => [
                        'https://sdkconsultoria.com/',
                    ],
                    'vertical' => 'PROF_SERVICES',
                    'messaging_product' => 'whatsapp',
                ],
            ],
        ];
    }
}
