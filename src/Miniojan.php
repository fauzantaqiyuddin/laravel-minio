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

    public static function upload($dir, $file)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . basename($file);

            $result = $client->putObject([
                'Bucket' => config('minio.bucket'),
                'Key'    => $objectName,
                'SourceFile' => $file,
            ]);

            return $result['ObjectURL'];
        } catch (Exception $e) {
            return 'Upload failed: ' . $e->getMessage();
        }
    }

    public static function getUrl($dir, $fileName)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . $fileName;
            $url = $client->getObjectUrl(config('minio.bucket'), $objectName);
            return $url;
        } catch (Exception $e) {
            return 'Get URL failed: ' . $e->getMessage();
        }
    }

    public static function delete($dir, $fileName)
    {
        try {
            $client = self::getClient();
            $objectName = $dir . '/' . $fileName;

            $result = $client->deleteObject([
                'Bucket' => config('minio.bucket'),
                'Key'    => $objectName,
            ]);

            return "File successfully deleted from Minio: {$objectName}";
        } catch (Exception $e) {
            return 'Delete failed: ' . $e->getMessage();
        }
    }
}
