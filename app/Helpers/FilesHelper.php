<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesHelper
{
    public static function acceptableDocumentFile(UploadedFile $file): bool
    {
        $extension = $file->extension();
        $acceptableExtension = self::getAcceptableDocsExtensions();
        return in_array($extension, $acceptableExtension);
    }

    public static function acceptableImport(UploadedFile $file): bool
    {
        $extension = $file->extension();
        $acceptableExtension = ['xls', 'csv', 'xlsx'];
        return in_array($extension, $acceptableExtension);
    }

    public static function acceptableImage(UploadedFile $image): bool
    {
        $extension = $image->extension();
        Log::debug('extension = ' . $extension);
        $acceptableExtension = self::getAcceptableImageExtensions();
        return in_array($extension, $acceptableExtension);
    }

    public static function clearDocuments(string $path)
    {
        $extensions = self::getAcceptableDocsExtensions();
        foreach ($extensions as $extension)
        {
            Storage::delete($path.'.'.$extension);
        }
    }

    public static function getAcceptableImageExtensions()
    {
        return ['jpeg', 'jpg', 'png', 'webp'];
    }

    public static function getAcceptableDocsExtensions()
    {
        return ['doc', 'docx', 'pdf', 'txt'];
    }
}
