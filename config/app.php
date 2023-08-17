<?php



return [

    'env_path' => base_path('.env'),

    'controllers_default_path' => 'app/Http/Controllers',

    'default_uploads_dir' => base_path('storage'),

    'allowed_file_extensions' => ['jpg', 'png', 'jpeg', 'gif', 'pdf'],
    'allowed_file_size' => '500000',

    'default_driver' => 'mail',

    'drivers' => [
        'mail' => \app\Notifications\Drivers\MailDriver::class,
        'sms' => '' // for new Drivers (SMS Driver)
    ],
];