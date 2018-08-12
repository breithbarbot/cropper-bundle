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
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cropper")
 */
class CropperController extends Controller
{
    /**
     * Added an avatar for a user profile.
     *
     * @Route("/avatar/add", methods="POST", options={"expose"=true})
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

        // Custom Variables
        $path = '/public/uploads/user/avatar';
        $nameEntity = 'Avatar';

        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            $message = 'This is not an ajax request.';
        } else {
            // Load Entity Manager
            $em = $this->getDoctrine()->getManager();

            // Get data file from request
            $imageInput = $request->files->get('avatar_input');

            if (null !== $imageInput) {

                // [...] YOUR LOGIC OR A LITE EXAMPLE...

                // Generate filename
                $name = md5(uniqid(12345, true)).'.'.$imageInput->guessClientExtension();

                // Upload
                $resultUpload = $imageInput->move($path, $name);

                if (!empty($resultUpload)) {
                    try {
                        // Add new File
                        $file = new File();
                        $file->setPath(str_replace('\\', '/', str_replace($this->getParameter('kernel.project_dir').'/public', '', $resultUpload->getPathname())));
                        $file->setName($name);

                        $em->persist($file);
                        $em->flush();

                        $additionalData['file'] = ['id' => $file->getId()];

                        $status = 200;
                        $message = $nameEntity.' saved.';
                        $return = true;
                        // [...]
                    } catch (\Exception $e) {
                        $message = 'An error occurred when updating the '.mb_strtolower($nameEntity).'...';
                        // [...]
                    }
                } else {
                    $message = 'Error during file upload...';
                    // [...]
                }

                // [...] END YOUR LOGIC OR A LITE EXAMPLE...

            } else {
                $message = 'File does not exist!';
                // [...]
            }
        }

        return new JsonResponse(['return' => $return, 'message' => $message, 'additional_data' => $additionalData], $status);
    }

    /**
     * Delete an avatar for a user profile.
     *
     * @Route("/avatar/delete", methods="POST", options={"expose"=true})
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

        // Custom Variables
        $entityId = $request->request->get('entity_id');
        $class = User::class;
        $nameEntity = 'Avatar';

        // If AJAX request
        if (!$request->isXmlHttpRequest()) {
            $message = 'This is not an ajax request.';
        } else {
            // Load Entity Manager
            $em = $this->getDoctrine()->getManager();

            // Get User
            $entity = $em->find($class, $entityId);

            // If user entity exist
            if (!\is_object($entity) && (null === $entity->getAvatar())) {
                $message = 'Entity does not exist!';
            } else {
                try {

                    // [...] YOUR LOGIC OR A LITE EXAMPLE...

                    $getFullPath = $entity->getAvatar()->getFullPath();

                    // Remove File entity
                    $em->remove($entity->getAvatar());

                    // Remove File
                    if (is_file($getFullPath)) {
                        unset($getFullPath);
                    }

                    // Set NULL avatar field
                    $entity->setAvatar(null);
                    $em->persist($entity);

                    $em->flush();

                    // [...] END YOUR LOGIC OR A LITE EXAMPLE...

                    $message = 'Image deleted!';
                    $status = 200;
                    $return = true;
                    // [...]
                } catch (\Exception $e) {
                    $message = 'An error occurred when delete the '.mb_strtolower($nameEntity).'...';
                }
            }
        }

        return new JsonResponse(['return' => $return, 'message' => $message, $additionalData], $status);
    }
}
