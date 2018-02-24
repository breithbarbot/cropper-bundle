<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\Controller;

use Breithbarbot\CropperBundle\Utils\Crop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Creation of variables for cropping and return of the result.
 */
class CropperController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function cropAction(Request $request): JsonResponse
    {
        if (!array_key_exists($request->request->get('mapping'), $this->getParameter('breithbarbot_cropper.mappings'))) {
            return new JsonResponse([
                'state' => 200,
                'message' => '<b>'.$request->request->get('mapping').'</b> is unrecognized!',
            ]);
        }

        $defaultFolder = !empty($this->getParameter('breithbarbot_cropper.default_folder')) ? $this->getParameter('breithbarbot_cropper.default_folder') : 'uploads';

        $basePath = \dirname($_SERVER['SCRIPT_FILENAME']).'/'.$defaultFolder.'/';
        $avatarSrc = $request->request->get('avatar_src');
        $avatarData = $request->request->get('avatar_data');
        $avatarFile = $request->files->get('avatar_file');
        $filename = $request->request->get('filename');
        $mapping = $this->getParameter('breithbarbot_cropper.mappings')[$request->request->get('mapping')];
        $path = $mapping['path'];
        $width = $mapping['width'];
        $height = $mapping['height'];

        $crop = new Crop(
            $avatarSrc ?? null,
            $avatarData ?? null,
            $avatarFile ?? null,
            !empty($filename) ? $filename : sha1(uniqid(time(), true)),
            !empty($path) ? $basePath.$path : $basePath.'files/',
            !empty($path) ? $path : 'files/',
            ['width' => $width, 'height' => $height],
            $defaultFolder
        );

        return new JsonResponse([
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult(),
        ]);
    }
}
