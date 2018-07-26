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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// [...]

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Add/Edit a avatar for a user.
     *
     * @Route("/avatar", name="app_user_avatar_add", methods="POST", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addAvatar(Request $request): Response
    {
        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();

        // From additioanl data
        $user_id = (int) $request->request->get('user_id');

        // Get user
        $user = $em->find(User::class, $user_id);

        // If user entity exist
        if (!\is_object($user)) {
            throw new AccessDeniedException();
        }

        $avatar_input = $request->files->get('avatar_input');
        if (null !== $avatar_input) {
            $name = uniqid($user_id, true).'.'.$avatar_input->guessClientExtension();

            $result_avatar_input = $avatar_input->move('/public/uploads/user/avatar', $name);
            if (!empty($result_avatar_input)) {
                try {
                    // Set File
                    $file = new File();
                    $file->setPath(str_replace('\\', '/', str_replace($this->getParameter('kernel.project_dir').'/public', '', $result_avatar_input->getPathname())));
                    $file->setName($name);
                    $em->persist($file);

                    // Set User (avatar)
                    $user->setAvatar($file);
                    $em->persist($user);

                    $em->flush();

                    return new JsonResponse(['return' => true, 'message' => 'Updated!'], 200);
                } catch (\Exception $e) {
                    // Write log & flash message
                    $message = 'Error when updating...';
                }
            } else {
                $message = 'Error during file upload';
            }
        } else {
            $message = 'No file found';
        }

        return new JsonResponse(['return' => false, 'message' => $message], 200);
    }

    /**
     * Remove a avatar for a user.
     *
     * @Route("/avatar/delete", name="app_user_avatar_delete", methods="POST", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAvatar(Request $request): Response
    {
        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        // [...]
    }
}
