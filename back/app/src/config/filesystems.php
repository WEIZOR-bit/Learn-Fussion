<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'minio_public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],


        'minio_public' => [
            'driver' => 's3',
            'key' => env('MINIO_API_USER_PUBLIC_KEY'),
            'secret' => env('MINIO_API_USER_SECRET_KEY'),
            'region' => 'us-east-1',
            'bucket' => env('MINIO_BUCKET_PUBLIC'),
            'url' => env('MINIO_URL'),
            'endpoint' => env('MINIO_URL'),
            'use_path_style_endpoint' => true,
            'throw' => true,
        ],

        'minio_private' => [
            'driver' => 's3',
            'key' => env('MINIO_API_USER_PUBLIC_KEY'),
            'secret' => env('MINIO_API_USER_SECRET_KEY'),
            'region' => 'us-east-1',
            'bucket' => env('MINIO_BUCKET_PRIVATE'),
            'url' => env('MINIO_URL'),
            'endpoint' => env('MINIO_URL'),
            'use_path_style_endpoint' => true,
            'throw' => true,
        ],

        'minio_avatars' => [
            'driver' => 's3',
            'key' => env('MINIO_API_USER_PUBLIC_KEY'),
            'secret' => env('MINIO_API_USER_SECRET_KEY'),
            'region' => 'us-east-1',
            'bucket' => env('MINIO_BUCKET_AVATARS'),
            'url' => env('MINIO_URL'),
            'endpoint' => env('MINIO_URL'),
            'use_path_style_endpoint' => true,
            'throw' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
