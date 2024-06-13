<?php

namespace App\Services;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class EventService
{
    private const MAX_WIDTH = 1200;
    private const CROP_SIZE = 600;

    public function handlePoster($request)
    {
        if (!$request->hasFile('poster')) {
            return false;
        }

        $image = $request->file('poster');
        $imageName = $this->generateImageName($image);

        $this->processAndSaveImage($image, $imageName);

        return $imageName;
    }

    private function generateImageName($image): string
    {
        return Str::uuid() . '.' . $image->getClientOriginalExtension();
    }

    private function processAndSaveImage($image, $imageName): void
    {
        $img = Image::read($image->path());
        if ($img->width() > self::MAX_WIDTH) {
            $img->crop(self::CROP_SIZE, self::CROP_SIZE, position: 'center-center');
        }

        $img->save(public_path('storage') . '/' . $imageName);
    }
}
