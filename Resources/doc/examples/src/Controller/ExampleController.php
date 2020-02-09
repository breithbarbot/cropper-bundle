<?php

/*
 * This file is part of the CropperBundle package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

// [...]
use App\Entity\File;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * Example controller.
     *
     * @Route("/example", methods="GET|POST", options={"expose": true}, name="app_example")
     */
    public function index(Request $request): Response
    {
        // [...]
        $entity = new User();
        $form = $this->createForm(UserType::class, $entity);

        if ($form->isSubmitted() && $form->isValid()) {
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

        return $this->render('example/index.html.twig', [
            'form' => $form->createView(),
            'user' => $entity,
        ]);
    }
}
