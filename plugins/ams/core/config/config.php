<?php return [
    'packages' => [
        'simplesoftwareio/simple-qrcode' => [
            'providers' => [
                '\SimpleSoftwareIO\QrCode\QrCodeServiceProvider',
            ],

            'aliases' => [
                'QrCode' => '\SimpleSoftwareIO\QrCode\Facades\QrCode',
            ],
        ],
        'intervention/image' => [
            'providers' => [
                '\Intervention\Image\ImageServiceProvider',
            ],

            'aliases' => [
                'Image' => '\Intervention\Image\Facades\Image',
            ],
        ]
    ],
];
