
![Logo](https://i.ibb.co.com/WVtCgRz/Black-Minimal-Business-Personal-Profile-Linkedin-Banner.png)


# Laravel Minio Storage

A Laravel package to upload files to Minio Object Storage.

## Installation

1. Install the package via Composer:

    ```bash
    composer require fauzantaqiyuddin/laravel-minio
    ```

2. Publish the configuration file:

    ```bash
    php artisan vendor:publish --provider="Fauzantaqiyuddin\LaravelMinio\MiniojanServiceProvider" 
    ```

## Configuration

1. Add the following environment variables to your `.env` file:

    ```env
    MINIO_REGION=us-east-1
    MINIO_ENDPOINT=http://127.0.0.1:9000
    MINIO_ACCESS_KEY=your-access-key
    MINIO_SECRET_KEY=your-secret-key
    MINIO_BUCKET=your-bucket-name
    ```

2. The configuration file `config/miniojan.php` will be published to your Laravel project. You can customize it as needed.

## Usage

### Uploading Files

To upload files to Minio, use the `upload` method.

#### Example Controller

```php
<?php

namespace App\Http\Controllers;

use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'berkas' => 'required|image',
            'directory' => 'required|string',
        ]);

        $file = $request->file('berkas'); 
        $directory = $request->input('directory');
    
        $path = $file->store('temp');
        $filePath = storage_path('app/' . $path); 

        // Upload file ke MinIO
        $response = Miniojan::upload($directory, $filePath);
        unlink($filePath);
        return back()->with('message', $response);
    }

    public function getFileUrl(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'directory' => 'required|string',
            'bucket' => 'required|string',
        ]);

        $fileName = $request->input('file_name');
        $directory = $request->input('directory');

        $url = Miniojan::getUrl($directory, $fileName);

        return back()->with('url', $url);
    }

    public function deleteFile(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'directory' => 'required|string',
            'bucket' => 'required|string',
        ]);

        $fileName = $request->input('file_name');
        $directory = $request->input('directory');

        $response = Miniojan::delete($directory, $fileName);

        return back()->with('message', $response);
    }
}
