<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\Container;
use Twig_Extension;
use Twig_SimpleFunction;

class ParameterExtension extends Twig_Extension
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('breithbarbot_cropper_parameter', [$this, 'getParameter']),
        ];
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        if (!empty($name)) {
            return $this->container->getParameter($name);
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'breithbarbot_cropper_parameter';
    }
}
