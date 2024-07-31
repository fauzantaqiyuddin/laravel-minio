<?php

namespace Fauzantaqiyuddin\LaravelMinio;

use Aws\S3\S3Client;
use Exception;

class Miniojan
{
    private static function getClient()
    {
        return new S3Client([
            'version'     => 'latest',
            'region'      => config('minio.region'),
            'endpoint'    => config('minio.endpoint'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => config('minio.access_key'),
                'secret' => config('minio.secret_key'),
            ],
        ]);
    }

    public static function upload($bucket, $dir, $file)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . basename($file);

            $result = $client->putObject([
                'Bucket' => $bucket,
                'Key'    => $objectName,
                'SourceFile' => $file,
            ]);

            return "File successfully uploaded to Minio: {$result['ObjectURL']}";
        } catch (Exception $e) {
            return 'Upload failed: ' . $e->getMessage();
        }
    }

    public static function getUrl($bucket, $dir, $fileName)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . $fileName;
            $url = $client->getObjectUrl($bucket, $objectName);
            return $url;
        } catch (Exception $e) {
            return 'Get URL failed: ' . $e->getMessage();
        }
    }

    public static function delete($bucket, $dir, $fileName)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . $fileName;

            $result = $client->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $objectName,
            ]);

            return "File successfully deleted from Minio: {$objectName}";
        } catch (Exception $e) {
            return 'Delete failed: ' . $e->getMessage();
        }
    }
}
