<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use Maestroerror\HeicToJpg as HeicConverter;

class ProductImageService
{
    private const MAX_BYTES = 5 * 1024 * 1024;

    private ?ImageManager $manager = null;

    public function store(UploadedFile $file): string
    {
        if ($file->getSize() > self::MAX_BYTES) {
            throw new \InvalidArgumentException('Ukuran file maksimal 5 MB.');
        }

        $tempPath = $this->resolveToJpegPath($file);

        try {
            $image = $this->manager()->decodePath($tempPath);
            $image->scaleDown(width: 1600, height: 1600);

            $filename = 'products/'.Str::uuid().'.jpg';
            $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 85);
            Storage::disk('public')->put($filename, (string) $encoded);

            return $filename;
        } finally {
            if ($tempPath !== $file->getRealPath() && is_file($tempPath)) {
                @unlink($tempPath);
            }
        }
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function manager(): ImageManager
    {
        return $this->manager ??= new ImageManager(new Driver);
    }

    private function resolveToJpegPath(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = strtolower((string) $file->getMimeType());

        if (in_array($extension, ['heic', 'heif'], true) || str_contains($mime, 'heic') || str_contains($mime, 'heif')) {
            $converter = new HeicConverter;
            $source = $file->getRealPath();

            if (PHP_OS_FAMILY === 'Darwin') {
                $converter->checkMacOS()->convertImageMac($source);
            } else {
                $converter->checkLinuxOS()->convertImage($source);
            }

            $temp = sys_get_temp_dir().'/'.Str::uuid().'.jpg';
            file_put_contents($temp, $converter->get());

            return $temp;
        }

        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            throw new \InvalidArgumentException('Format gambar tidak didukung.');
        }

        if ($extension === 'png' || $extension === 'webp') {
            $temp = sys_get_temp_dir().'/'.Str::uuid().'.jpg';
            $this->manager()
                ->decodePath($file->getRealPath())
                ->encodeUsingFormat(Format::JPEG, quality: 90)
                ->save($temp);

            return $temp;
        }

        return $file->getRealPath();
    }
}
