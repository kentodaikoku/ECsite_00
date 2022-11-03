<?php

namespace App\Services;

use InterventionImage;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        dd($imageFile);
        if (is_array($imageFile)) {
            $imageFile = $imageFile['image'];
        }

        // Storage::putFile('public/' . $folderName . '/', $imageFile);
        $fileName = uniqid(rand() . '_');
        $extension = $imageFile->extension();
        $fileNameToStore = $fileName . '.' . $extension;
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

        Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;
    }
}
