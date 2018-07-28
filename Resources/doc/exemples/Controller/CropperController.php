<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

// [...]
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cropper")
 */
class CropperController extends Controller
{
    /**
     * Added/Edit an avatar for a user profile.
     *
     * @Route("/avatar/edit", name="app_cropper_avatar_add", methods="POST", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function avatarAdd(Request $request): JsonResponse
    {
        // Variables
        $status = 400;
        $return = false;
        $additionalData = [];

        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            $message = 'This is not an ajax request.';
        } else {
            // Load Entity Manager
            $em = $this->getDoctrine()->getManager();

            // Get data user ID from request
            $userId = (int) $request->request->get('user_id');

            // Get User
            $user = $em->find(User::class, $userId);

            // If user entity exist
            if (!\is_object($user)) {
                $message = 'User does not exist!';
            } else {
                // Get data file from request
                $avatarInput = $request->files->get('avatar_input');

                if (null !== $avatarInput) {
                    // Generate filename
                    $name = md5(uniqid($userId, true)).'.'.$avatarInput->guessClientExtension();

                    // Upload
                    $resultUpload = $avatarInput->move('/public/uploads/user/avatar', $name);

                    if (!empty($resultUpload)) {
                        // Set the entity name
                        $entity = 'Avatar';

                        try {
                            // Add new File
                            $file = new File();
                            $file->setFullPath($resultUpload->getPathname());
                            $file->setPath(str_replace('\\', '/', str_replace($this->getParameter('kernel.project_dir').'/public', '', $resultUpload->getPathname())));
                            $file->setTitle($avatarInput->getClientOriginalName());
                            $em->persist($file);

                            $additionalData = ['file' => ['id' => $file->getId()]];

                            // Update User
                            $user->setAvatar($file);
                            $em->persist($user);

                            // Save all data
                            $em->flush();

                            $status = 200;
                            $message = $entity.' updated.';
                            $return = true;
                        } catch (\Exception $e) {
                            $message = 'An error occurred when updating the '.mb_strtolower($entity).'...';
                        }
                    } else {
                        $message = 'Error during file upload...';
                    }
                } else {
                    $status = 400;
                    $message = 'File does not exist!';
                }
            }
        }

        return new JsonResponse(['return' => $return, 'message' => $message, $additionalData], $status);
    }

    /**
     * Delete an avatar for a user profile.
     *
     * @Route("/avatar/delete", name="app_cropper_avatar_delete", methods="POST", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function avatarDelete(Request $request): JsonResponse
    {
        // Variables
        $status = 400;
        $return = false;
        $additionalData = [];

        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            $message = 'This is not an ajax request.';
        } else {
            // Load Entity Manager
            $em = $this->getDoctrine()->getManager();

            // Get data user ID from request
            $userId = (int) $request->request->get('user_id');

            // Get User
            $user = $em->find(User::class, $userId);

            // If user entity exist
            if (!\is_object($user)) {
                $message = 'User does not exist!';
            } elseif (null === $user->getAvatar()) {
                $message = 'User does not exist!';
            } else {
                // Set the entity name
                $entity = 'Avatar';

                try {
                    $getFullPath = $user->getAvatar()->getFullPath();

                    // Remove File entity
                    $em->remove($user->getAvatar());

                    // Remove File
                    if (is_file($getFullPath)) {
                        unset($getFullPath);
                    }

                    // Set NULL avatar field
                    $user->setAvatar(null);
                    $em->persist($user);

                    $em->flush();

                    $message = 'Image deleted!';
                    $status = 200;
                    $return = true;
                } catch (\Exception $e) {
                    $message = 'An error occurred when delete the '.mb_strtolower($entity).'...';
                }
            }
        }

        return new JsonResponse(['return' => $return, 'message' => $message, $additionalData], $status);
    }
}
