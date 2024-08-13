<?php

namespace app\Services\MinIo;

use Exception;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Log;

class StorageAvatarService
{
    private StorageMinioDriver $storage;
    private string $avatarBucketName = 'avatars';

    public function __construct(StorageMinioDriver $storage)
    {
        $this->storage = $storage;
    }

    private function buildPath(int $userId): string
    {
        return "/{$userId}/originalBytes";
    }

    public function putOriginal(int $userId, $file): void
    {
        try {
            if (is_file($file)) {
                $this->storage->putObject($this->avatarBucketName, $this->buildPath($userId), file_get_contents($file));
            } elseif (is_string($file)) {
                $this->storage->putObject($this->avatarBucketName, $this->buildPath($userId), $file);
            } else {
                throw new Exception("Invalid file type provided");
            }
        } catch (Exception $e) {
            Log::error("Error in putOriginal: {$e->getMessage()}");
            throw new RuntimeException($e->getMessage());
        }
    }

    public function putWebP(int $userId, string $data): void
    {
        try {
            $this->storage->putObject($this->avatarBucketName, "/{$userId}/avatar.webp", $data);
        } catch (Exception $e) {
            Log::error("Error in putWebP: {$e->getMessage()}");
            throw new RuntimeException($e->getMessage());
        }
    }

    public function getOriginalBytes(int $userId): string
    {
        try {
            return $this->storage->getObject($this->avatarBucketName, $this->buildPath($userId));
        } catch (Exception $e) {
            Log::error("Error in getOriginalBytes: {$e->getMessage()}");
            throw new RuntimeException($e->getMessage());
        }
    }
}
