<?php

namespace app\Services\MinIo;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;

class StorageMinioDriver
{
    protected $minioClient;

    public function __construct()
    {
        $this->minioClient = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => env('STORAGE_MINIO_ENDPOINT', 'http://localhost:9000'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => env('MINIO_ACCESS_KEY', 'RBzkA3RUaXrZfHNjzs9Y'),
                'secret' => env('MINIO_SECRET_KEY', 'DQeLqXlAOiIqzkUDQYw6eOahvsXiHTLf6aeSXgLn'),
            ],
        ]);
    }

    public function putObject($bucket, $key, $body)
    {
        try {
            $result = $this->minioClient->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => $body,
            ]);
            return $result;
        } catch (\Exception $e) {
            Log::error("Error putting object: {$e->getMessage()}");
            return null;
        }
    }

    public function getObject($bucket, $key)
    {
        try {
            $result = $this->minioClient->getObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);
            return $result['Body'];
        } catch (\Exception $e) {
            Log::error("Error getting object: {$e->getMessage()}");
            return null;
        }
    }

    public function createPresignedUrl($bucket, $key, $expires = '+10 minutes')
    {
        try {
            $command = $this->minioClient->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);

            $presignedRequest = $this->minioClient->createPresignedRequest($command, $expires);

            return (string) $presignedRequest->getUri();
        } catch (\Exception $e) {
            Log::error("Error creating presigned URL: {$e->getMessage()}");
            return null;
        }
    }

    public function getPlainUrl($bucket, $key)
    {
        try {
            return $this->minioClient->getObjectUrl($bucket, $key);
        } catch (\Exception $e) {
            Log::error("Error getting plain URL: {$e->getMessage()}");
            return null;
        }
    }

    public function setBucketPolicy($bucket, $policyReadOnly)
    {
        try {
            $this->minioClient->putBucketPolicy([
                'Bucket' => $bucket,
                'Policy' => sprintf($policyReadOnly, $bucket, $bucket),
            ]);
        } catch (\Exception $e) {
            Log::error("Error setting bucket policy: {$e->getMessage()}");
        }
    }

    public function createBucket($bucket)
    {
        try {
            $result = $this->minioClient->createBucket([
                'Bucket' => $bucket,
            ]);
            return $result;
        } catch (\Exception $e) {
            Log::error("Error creating bucket: {$e->getMessage()}");
            return null;
        }
    }
}
