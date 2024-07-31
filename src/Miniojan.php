<?php

namespace Fauzantaqiyuddin\LaravelMinio;

use Aws\S3\S3Client;
use Exception;

class Miniojan
{
    private $client;

    public function __construct($endpoint, $accessKey, $secretKey, $region = 'us-east-1')
    {
        $this->client = new S3Client([
            'version'     => 'latest',
            'region'      => $region,
            'endpoint'    => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ],
        ]);
    }

    public function upload($bucket, $dir, $file)
    {
        try {
            $objectName = $dir . '/' . basename($file);

            // Upload ke Minio
            $result = $this->client->putObject([
                'Bucket' => $bucket,
                'Key'    => $objectName,
                'SourceFile' => $file,
            ]);

            return "File successfully uploaded to Minio: {$result['ObjectURL']}";
        } catch (Exception $e) {
            return 'Upload failed: ' . $e->getMessage();
        }
    }
}
