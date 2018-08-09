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
use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * New post.
     *
     * @Route("/new", methods="GET|POST", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        // [...]

        try {
            $em = $this->getDoctrine()->getManager();

            // Set Avatar
            $fileId = $request->request->get('user')['avatar']['id'];
            if (!empty($fileId)) {
                $entity->setAvatar($em->find(File::class, $fileId));
            }

            $em->persist($entity);
            $em->flush();

            // [...]
        } catch (\Exception $e) {
            // [...]
        }

        // [...]
    }
}
