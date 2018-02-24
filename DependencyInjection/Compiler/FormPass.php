<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        $template = 'BreithbarbotCropperBundle:Form:fields.html.twig';
        $resources = $container->getParameter('twig.form.resources');

        // Check if the template is not already added via config
        if (!\in_array($template, $resources, true)) {
            // If fields.html.twig template is found, insert BreithbarbotCropperBundle:Form:fields.html.twig template after
            // Else i place in first position
            if (false !== ($key = array_search('fields.html.twig', $resources, true))) {
                array_splice($resources, ++$key, 0, $template);
            } else {
                array_unshift($resources, $template);
            }

            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
