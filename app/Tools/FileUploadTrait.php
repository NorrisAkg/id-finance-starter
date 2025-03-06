<?php

namespace App\Tools;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait FileUploadTrait
{
    /**
     * Upload a single file in the server
     *
     * @param UploadedFile $file
     * @param null $folder
     * @param null $filename
     * @param string $disk
     * @return false|string
     */
    public function upload(UploadedFile $file, ?string $folder = null, ?string $filename = null, string $disk = 'uploads')
    {
        $name = !is_null($filename) ? $filename : Str::random(25) . '.' . $file->getClientOriginalExtension();

        $file->storeAs(
            $folder,
            $name,
            $disk
        );

        return $name;
    }
}
