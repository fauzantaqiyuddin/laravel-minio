<?php

namespace Miniojan;

use Minio\MinioClient;
use Exception;

class Miniojan
{
    private $client;

    public function __construct($endpoint, $accessKey, $secretKey)
    {
        $this->client = new MinioClient($endpoint, $accessKey, $secretKey);
    }

    public function upload($dir, $file)
    {
        try {
            $bucket = 'your-bucket-name'; // Ganti dengan nama bucket Anda
            $objectName = $dir . '/' . basename($file);

            // Baca file
            $fileStream = fopen($file, 'rb');
            if (!$fileStream) {
                throw new Exception('File not found: ' . $file);
            }

            // Upload ke Minio
            $this->client->putObject($bucket, $objectName, $fileStream, filesize($file));
            fclose($fileStream);

            return "File successfully uploaded to Minio: $objectName";
        } catch (Exception $e) {
            return 'Upload failed: ' . $e->getMessage();
        }
    }
}
