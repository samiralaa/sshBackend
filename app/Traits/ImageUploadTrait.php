<?php

namespace App\Traits;

trait ImageUploadTrait
{
    public function uploadImage($file, $folder)
    {
        $imageName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($folder, $imageName, 'public');

        return $filePath;
    }
}
