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

class ParameterExtension extends \Twig_Extension
{
    /**
     * @var
     */
    private $container;

    /**
     * ParameterExtension constructor.
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('breithbarbot_cropper_parameter', [$this, 'getParameter']),
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
