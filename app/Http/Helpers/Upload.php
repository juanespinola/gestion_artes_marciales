<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

if(!function_exists('uploadImage')) {
    function uploadImage($file, array $resize = null, bool $upsize = false): string
    {
        $generated = md5(date('YmdHis'));
        $image = Image::read($file);

        if($resize != null) {
            $image->resizeCanvas($resize['width'], $resize['height'], function($constraint) use ($upsize) {
                $constraint->aspectRatio();
                if($upsize) {
                    $constraint->upsize();
                }
            });
        }

        $name = "events/{$generated}.jpg";
        Storage::put($name, $image->toJpeg(80));

        return $name;
    }
}
