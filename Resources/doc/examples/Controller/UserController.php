<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

// [...]
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * Edit user.
     *
     * @Route("/edit", methods="GET|POST", options={"expose"=true}, name="app_user_edit")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Request $request): Response
    {
        // [...]
        try {
            $em = $this->getDoctrine()->getManager();
            // Set Avatar
            $fileId = $request->request->get('user')['avatar']['id'];
            if (!empty($fileId)) {
                // Remove avatar if exist
                if ($entity->getAvatar()) {
                    $file = $em->find(File::class, $entity->getAvatar());
                    $em->remove($file);
                }
                $entity->setAvatar($em->find(File::class, $fileId));
            }
            $em->persist($entity);
            $em->flush();
            // [...]
        } catch (\Exception $e) {
            // [...]
        }
    }
}
