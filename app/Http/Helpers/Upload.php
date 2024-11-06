<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


if(!function_exists('uploadImage')) {
    function uploadImage($file, array $resize = null, bool $upsize = false, $index = null): string
    {
        $manager =  ImageManager::imagick();
        // $generated = hexdec( uniqid(). '.' . $file->getClientOriginalExtension() );
        $generated = md5(date('YmdHis')) . '_' . $index;
        $image = $manager->read($file);
        $image = $image->resize($resize['width'], $resize['height']);
        $name = "public/events/{$generated}.jpg";
        // $image->toJpeg(80)->save(base_path('public/storage/'.$name));
        Storage::put($name, $image->toJpeg(80));
        
        // $generated = md5(date('YmdHis'));
        // $image = Image::read($file);
        // if($resize != null) {
        //     $image->resizeCanvas($resize['width'], $resize['height'], function($constraint) use ($upsize) {
        //         $constraint->aspectRatio();
        //         if($upsize) {
        //             $constraint->upsize();
        //         }
        //     });
        // }

        // $name = "events/{$generated}.jpg";

        return $name;
    }
}


if(!function_exists('uploadImageNew')) {
    function uploadImageNew($file, array $resize = null, bool $upsize = false): string
    {
        $manager =  ImageManager::imagick();
        $generated = md5(date('YmdHis'));
        $image = $manager->read($file);
        $image = $image->resize($resize['width'], $resize['height']);
        $name = "public/news/{$generated}.jpg";
        Storage::put($name, $image->toJpeg(80));
        
        return $name;
    }
}


if(!function_exists('uploadPdfNew')) {
    function uploadPdfNew($file): string
    {
        $generated = md5(date('YmdHis'));
        $name = "public/minor_autorization/{$generated}.pdf";
        Storage::put($name, $file);
        // $file->storeAs('public/minor_autorization', "{$generated}.pdf");
        return $name;      
    }
}
