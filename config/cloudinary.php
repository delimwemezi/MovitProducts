<?php

return [
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    'cloud_url' => env('CLOUDINARY_URL'),

    'cloud'  => env('CLOUDINARY_CLOUD_NAME'),
    'key'    => env('CLOUDINARY_API_KEY'),
    'secret' => env('CLOUDINARY_API_SECRET'),
    'secure' => true,

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'upload_route'  => env('CLOUDINARY_UPLOAD_ROUTE'),
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),
];
