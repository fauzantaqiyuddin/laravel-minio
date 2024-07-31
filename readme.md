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
    MINIO_ENDPOINT=http://localhost:9000
    MINIO_ACCESS_KEY=your-access-key
    MINIO_SECRET_KEY=your-secret-key
    MINIO_REGION=us-east-1
    ```

2. The configuration file `config/miniojan.php` will be published to your Laravel project. You can customize it as needed.

## Usage

### Uploading Files

To upload files to Minio, use the `upload` method.

#### Example Controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fauzantaqiyuddin\LaravelMinioStorage\Miniojan;

class MinioController extends Controller
{
    protected $miniojan;

    public function __construct(Miniojan $miniojan)
    {
        $this->miniojan = $miniojan;
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('your_file_field');
        $directory = 'your-directory';
        $bucket = 'your-bucket-name';

        $response = $this->miniojan->upload($bucket, $directory, $file->getPathname());

        return response()->json(['message' => $response]);
    }

    public function getFileUrl($fileName)
    {
        $directory = 'your-directory';
        $bucket = 'your-bucket-name';

        $url = $this->miniojan->getUrl($bucket, $directory, $fileName);

        return response()->json(['url' => $url]);
    }

    public function deleteFile($fileName)
    {
        $directory = 'your-directory';
        $bucket = 'your-bucket-name';

        $response = $this->miniojan->delete($bucket, $directory, $fileName);

        return response()->json(['message' => $response]);
    }
}
