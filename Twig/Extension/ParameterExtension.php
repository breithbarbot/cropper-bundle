<?php
/******************************************************************************
 * Copyright (c) 2017 Cropper. All rights reserved.                           *
 * Author      : Breith Barbot                                                *
 * Updated at  : 18/06/17 23:04                                               *
 * File name   : ParameterExtension.php                                       *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle\Twig\Extension;

class ParameterExtension extends \Twig_Extension
{
    /**
     * @var $container
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