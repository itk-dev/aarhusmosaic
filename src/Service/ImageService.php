<?php

namespace App\Service;

class ImageService
{
    public function __construct(
        private readonly string $publicPath,
        private readonly int $imageMaxWidth
    )
    {
    }

    public function scaleDownLongestSide(string $file): bool
    {
        $file = $this->publicPath . $file;
        $info = $this->getInfo($file);

        if ($info['width'] > $this->imageMaxWidth) {
            $image = $this->load($info['mime'], $file);
            $image = $this->fixRotation($image, $info['orientation']);
            $scaledImage = imagescale($image, $this->imageMaxWidth);
            return $this->save($scaledImage, $info['mime'], $file);
        }

        return false;
    }

    private function save(\GdImage $image, string $mime, string $file): bool
    {
        try {
            return match ($mime)
            {
                'image/jpeg' => imagejpeg($image, $file),
                'image/png' => imagepng($image, $file),
            };
        } catch (\UnhandledMatchError $error) {
            // todo throw custom exception.
        }
    }

    private function getInfo(string $file): array
    {
        $info = getimagesize($file);

        try {
            $exif = @exif_read_data($file);
            $orientation = $exif['Orientation'] ?? 0;
        } catch (\Exception $e) {
            $orientation = 0;
        }

        return [
            'width' => $info[0],
            'height' => $info[1],
            'mime' => $info['mime'],
            'orientation' => $orientation,
        ];
    }

    private function load(string $mime, string $file): \GdImage
    {
        try {
            return match ($mime)
            {
                'image/jpeg' => imagecreatefromjpeg($file),
                'image/png' => imagecreatefrompng($file),
            };
        } catch (\UnhandledMatchError $error) {
            // todo throw custom exception.
        }
    }

    private function fixRotation(\GdImage $image, int $orientation)
    {
        if ($orientation != 1) {
            $deg = 0;
            switch ($orientation) {
                case 3:
                    $deg = 180;
                    break;
                case 6:
                    $deg = 270;
                    break;
                case 8:
                    $deg = 90;
                    break;
            }
            if ($deg) {
                $image = imagerotate($image, $deg, 0);
            }
        }

        return $image;
    }

}
