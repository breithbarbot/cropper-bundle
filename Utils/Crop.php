<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\Utils;

use Symfony\Component\HttpFoundation\Request;

class Crop
{
    private $src;
    private $data;
    private $dst;
    private $type;
    private $extension;
    private $msg;
    private $infoFile;

    /**
     * Crop constructor.
     *
     * @param $src
     * @param $data
     * @param $file
     * @param $filename
     * @param $path
     * @param $folder
     * @param $size
     * @param $defaultFolder
     */
    public function __construct($src, $data, $file, $filename, $path, $folder, $size, $defaultFolder)
    {
        $this->setSrc($src, $filename, $path);
        $this->setData($data);
        $this->setFile($file, $filename, $path, $folder, $defaultFolder);
        $this->crop($this->src, $this->dst, $this->data, $size);
    }

    /**
     * @param $src
     * @param $filename
     * @param $path
     */
    private function setSrc($src, $filename, $path)
    {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
                $this->src = $src;
                $this->type = $type;
                $this->extension = image_type_to_extension($type);
                $this->setDst($filename, $path);
            }
        }
    }

    /**
     * @param $data
     */
    private function setData($data)
    {
        if (!empty($data)) {
            $this->data = json_decode(stripslashes($data));
        }
    }

    /**
     * @param $file
     * @param $filename
     * @param $path
     * @param $folder
     * @param $defaultFolder
     */
    private function setFile($file, $filename, $path, $folder, $defaultFolder)
    {
        $errorCode = $file->getError();

        if (UPLOAD_ERR_OK === $errorCode) {
            $type = exif_imagetype($file->getRealPath());

            // Create folder
            if (!@mkdir('uploads/'.$folder, 0755, true) && !is_dir('uploads/'.$folder)) {
                die('Failed to create folders...');
            }

            if (is_dir($path)) {
                if ($type) {
                    $extension = image_type_to_extension($type);
                    $src = $path.$filename.'.original'.$extension;

                    if (IMAGETYPE_GIF === $type || IMAGETYPE_JPEG === $type || IMAGETYPE_PNG === $type) {
                        if (file_exists($src)) {
                            unlink($src);
                        }

                        $this->setInfoFile($file, $filename, $folder, $defaultFolder, $extension);

                        $result = move_uploaded_file($file->getRealPath(), $src);

                        if ($result) {
                            $this->src = $src;
                            $this->type = $type;
                            $this->extension = $extension;
                            $this->setDst($filename, $path);
                        } else {
                            $this->msg = 'Failed to save file';
                        }
                    } else {
                        $this->msg = 'Please upload image with the following types: JPG, PNG, GIF';
                    }
                } else {
                    $this->msg = 'Please upload image file';
                }
            } else {
                $this->msg = 'Upload folder is missing';
            }
        } else {
            $this->msg = $this->codeToMessage($errorCode);
        }
    }

    /**
     * @param $filename
     * @param $path
     */
    private function setDst($filename, $path)
    {
        $this->dst = $path.$filename.$this->extension;
    }

    /**
     * @param $file
     * @param $filename
     * @param $folder
     * @param $defaultFolder
     * @param $extension
     */
    private function setInfoFile($file, $filename, $folder, $defaultFolder, $extension)
    {
        $this->infoFile = [
            'path' => '/'.$defaultFolder.'/'.$folder.$filename.$extension,
            'name' => $filename.$extension,
            'nameOriginal' => $filename.'.original'.$extension,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }

    /**
     * @param $src
     * @param $dst
     * @param $data
     * @param $size_data
     */
    private function crop($src, $dst, $data, $size_data)
    {
        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this->type) {
                case IMAGETYPE_GIF:
                    $src_img = @imagecreatefromgif($src);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = @imagecreatefromjpeg($src);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = @imagecreatefrompng($src);
                    break;
                default:
                    $src_img = null;
            }

            if (!$src_img) {
                $this->msg = 'Failed to read the image file';

                return;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data->rotate;

            // Rotate the source image
            if (is_numeric($degrees) && 0 !== $degrees) {
                // PHP's degrees is opposite to CSS's degrees
                $new_img = imagerotate($src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127));

                imagedestroy($src_img);
                $src_img = $new_img;

                $deg = abs($degrees) % 180;
                $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                // Fix rotated image miss 1px issue when degrees < 0
                --$src_img_w;
                --$src_img_h;
            }

            $tmp_img_w = $data->width;
            $tmp_img_h = $data->height;
            $dst_img_w = $size_data['width'];
            $dst_img_h = $size_data['height'];

            $src_x = $data->x;
            $src_y = $data->y;

            $src_w = $dst_y = $dst_x = $dst_w = $dst_h = $src_h = 0;

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } else {
                if ($src_x <= 0) {
                    $dst_x = -$src_x;
                    $src_x = 0;
                    $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
                } else {
                    if ($src_x <= $src_img_w) {
                        $dst_x = 0;
                        $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
                    }
                }
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } else {
                if ($src_y <= 0) {
                    $dst_y = -$src_y;
                    $src_y = 0;
                    $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
                } else {
                    if ($src_y <= $src_img_h) {
                        $dst_y = 0;
                        $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
                    }
                }
            }

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = @imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

            if ($result) {
                switch ($this->type) {
                    case IMAGETYPE_GIF:
                        if (!imagegif($dst_img, $dst)) {
                            $this->msg = 'Failed to save the cropped image file';
                        }
                        break;

                    case IMAGETYPE_JPEG:
                        if (!imagejpeg($dst_img, $dst)) {
                            $this->msg = 'Failed to save the cropped image file';
                        }
                        break;

                    case IMAGETYPE_PNG:
                        if (!imagepng($dst_img, $dst)) {
                            $this->msg = 'Failed to save the cropped image file';
                        }
                        break;
                }
            } else {
                $this->msg = 'Failed to crop the image file';
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    private function codeToMessage($code)
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        ];

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return 'Unknown upload error';
    }

    public function getResult(): array
    {
        $request = new Request();

        $dirname = (mb_strlen(\dirname($_SERVER['SCRIPT_NAME'])) > 1) ? \dirname($_SERVER['SCRIPT_NAME']) : '';

        // Fix for app work with subfolders
        $path = $this->infoFile['path'];
        if ($this->infoFile['path'][0] === '/') {
            $path = mb_substr($this->infoFile['path'], 1);
        }

        return [
            'path_image' => $request->getBaseUrl().$dirname.$this->infoFile['path'],
            'full_path' => !empty($this->data) ? $this->dst : $this->src,
            'path' => $path,
            'name' => $this->infoFile['name'],
            'nameOriginal' => $this->infoFile['nameOriginal'],
            'mime_type' => $this->infoFile['mime_type'],
            'size' => $this->infoFile['size'],
        ];
    }

    public function getMsg()
    {
        return $this->msg;
    }
}
