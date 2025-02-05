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
        $acceptableExtension = self::getAcceptableImageExtensions();
        return in_array($extension, $acceptableExtension);
    }

    public static function clearDocuments(string $path): void
    {
        $extensions = self::getAcceptableDocsExtensions();
        foreach ($extensions as $extension)
        {
            Storage::delete($path.'.'.$extension);
        }
    }
    //Для удаления из storage всех изображений с одинаковым id,но разным расширением(чтобы при обновлении аватаров и прочего изобаржения не дублировались)
    public static function clearImages(string $path): void
    {
        $extensions = self::getAcceptableImageExtensions();
        foreach ($extensions as $extension)
        {
            Storage::delete($path.'.'.$extension);
        }
    }

    public static function getAcceptableImageExtensions(): array
    {
        return ['jpeg', 'jpg', 'png', 'webp'];
    }

    public static function getAcceptableDocsExtensions()
    {
        return ['doc', 'docx', 'pdf', 'txt'];
    }
}
