<?php

namespace App\Service;

use App\Exception\UnknownImageFormatException;

/**
 * Image service ot handle image scaling.
 */
class ImageService
{
    /**
     * Default constructor.
     *
     * @param string $publicPath
     *   The public image path
     * @param int $imageMaxWidth
     *   The max image with to scale down to
     */
    public function __construct(
        private readonly string $publicPath,
        private readonly int $imageMaxWidth
    ) {
    }

    /**
     * Scale down image.
     *
     * @param string $file
     *   The relative file path store en Tile entity
     *
     * @return bool
     *   True on success or false (also false when now scaled)
     *
     * @throws unknownImageFormatException
     *   If image type it not supported
     */
    public function scaleDown(string $file): bool
    {
        $file = $this->publicPath.$file;
        $info = $this->getInfo($file);

        if ($info['width'] > $this->imageMaxWidth) {
            $image = $this->load($info['mime'], $file);
            $image = $this->fixRotation($image, $info['orientation']);
            $scaledImage = imagescale($image, $this->imageMaxWidth);

            return $this->save($scaledImage, $info['mime'], $file);
        }

        return false;
    }

    /**
     * Save image to disk.
     *
     * @param \GdImage $image
     *   The image save
     * @param string $mime
     *   Image mime type
     * @param string $file
     *   The file to save image to
     *
     * @return bool
     *   True on success else false
     *
     * @throws unknownImageFormatException
     *   If image type it not supported
     */
    private function save(\GdImage $image, string $mime, string $file): bool
    {
        try {
            return match ($mime) {
                'image/jpeg' => imagejpeg($image, $file),
                'image/png' => imagepng($image, $file),
            };
        } catch (\UnhandledMatchError $error) {
            throw new UnknownImageFormatException($file);
        }
    }

    /**
     * Get image information.
     *
     * @param string $file
     *   The file to probe
     *
     * @return array
     *   Image 'width', 'height', 'mime' and 'orientation'
     */
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

    /**
     * Load image into object.
     *
     * @param string $mime
     *   Image mime type
     * @param string $file
     *   File to load
     *
     * @return \GdImage
     *   Loaded image
     *
     * @throws unknownImageFormatException
     *   If image type it not supported
     */
    private function load(string $mime, string $file): \GdImage
    {
        try {
            return match ($mime) {
                'image/jpeg' => imagecreatefromjpeg($file),
                'image/png' => imagecreatefrompng($file),
            };
        } catch (\UnhandledMatchError $error) {
            throw new UnknownImageFormatException($file);
        }
    }

    /**
     * Rotate image, if needed.
     *
     * Images upload from mobil-phones contains metadata about image orientation and if not handled all images will
     * "lay down".
     *
     * @param \GdImage $image
     *   The image
     * @param int $orientation
     *   The detected image orientation
     *
     * @return \GdImage
     *   The rotate image if need else the image
     */
    private function fixRotation(\GdImage $image, int $orientation)
    {
        if (1 != $orientation) {
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
                $newImage = imagerotate($image, $deg, 0);
                if (false !== $newImage) {
                    $image = $newImage;
                }
            }
        }

        return $image;
    }
}
