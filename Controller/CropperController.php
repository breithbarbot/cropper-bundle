<?php
/******************************************************************************
 * Copyright (c) 2017 Cropper. All rights reserved.                           *
 * Author      : Breith Barbot                                                *
 * Updated at  : 12/03/17 20:29                                               *
 * File name   : CropperController.php                                        *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle\Controller;

use Breithbarbot\CropperBundle\Utils\Crop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CropperController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function cropAction(Request $request)
    {
        if (!array_key_exists($request->request->get('mapping'), $this->getParameter('breithbarbot_cropper.mappings'))) {
            return new JsonResponse([
                'state'   => 200,
                'message' => '<b>'.$request->request->get('mapping').'</b> is unrecognized!',
            ]);
        }

        $default_folder = !empty($this->getParameter('breithbarbot_cropper.default_folder')) ? $this->getParameter('breithbarbot_cropper.default_folder') : 'uploads';

        $avatar_src = $request->request->get('avatar_src');
        $avatar_data = $request->request->get('avatar_data');
        $avatar_file = $request->files->get('avatar_file');
        $filename = $request->request->get('filename');
        $mapping = $this->getParameter('breithbarbot_cropper.mappings')[$request->request->get('mapping')];
        $path = $mapping['path'];
        $width = $mapping['width'];
        $height = $mapping['height'];

        $base_path = dirname($_SERVER['SCRIPT_FILENAME']).'/'.$default_folder.'/';

        $crop = new Crop(
            $avatar_src ?? null,
            $avatar_data ?? null,
            $avatar_file ?? null,
            !empty($filename) ? $filename : sha1(uniqid(time(), true)),
            !empty($path) ? $base_path.$path : $base_path.'files/',
            !empty($path) ? $path : 'files/',
            ['width' => $width, 'height' => $height],
            $default_folder
        );

        return new JsonResponse([
            'state'   => 200,
            'message' => $crop->getMsg(),
            'result'  => $crop->getResult(),
        ]);
    }
}
