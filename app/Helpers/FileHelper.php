<?php

namespace App\Helpers;

use App\Exceptions\FileUploadFailException;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Generate a unique filename for the given file.
     *
     * @param \Illuminate\Http\UploadedFile
     * @return string
     */
    public static function generateUniqueFilename(UploadedFile $file, $path): string
    {
        $extension = $file->extension();
        $filename = $path . '/' . uniqid() . '.' . $extension;

        while (Storage::disk('minio')->exists($filename)) {
            $filename = $path . '/' . uniqid() . '.' . $extension;
        }

        return $filename;
    }

    public static function uploadFile($file, $path): string
    {
        try {
            $filename = self::generateUniqueFilename($file, $path);
            Storage::disk('minio')->put($filename, file_get_contents($file));
            return $filename;
        } catch (Exception $e) {
            throw new FileUploadFailException($e->getMessage());
        }
    }
}
