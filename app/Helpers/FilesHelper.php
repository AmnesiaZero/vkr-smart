<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FilesHelper
{
   public static function acceptableDocumentFile(UploadedFile $file): bool
   {
       $extension = $file->extension();
       $acceptableExtension = ['doc','docx','pdf','txt'];
       return in_array($extension,$acceptableExtension);
   }

   public static function acceptableImport(UploadedFile $file):bool
   {
       $extension = $file->extension();
       $acceptableExtension = ['xls','csv','xlsx'];
       return in_array($extension,$acceptableExtension);
   }

   public static function acceptableImage(UploadedFile $image):bool
   {
       $extension = $image->extension();
       Log::debug('extension = '.$extension);
       $acceptableExtension = ['jpeg','jpg','png','webp'];
       return in_array($extension,$acceptableExtension);
   }
}
