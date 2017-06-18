<?php
/******************************************************************************
 * Copyright (c) 2017 Breithbarbot.name. All rights reserved.                 *
 * Author      : Breith Barbot                                                *
 * Updated at  : 27/03/17 01:12                                               *
 * File name   : CropperExtension.php                                         *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle\Twig\Extension;

use Symfony\Component\Asset\Packages;

class AssetExtension extends \Twig_Extension
{
    /**
     * @var Packages
     */
    private $packages;

    /**
     * CropperExtension constructor.
     *
     * @param Packages $packages
     */
    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('breithbarbot_cropper_asset', [$this, 'getPath']),
        ];
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    public function getPath($entity)
    {
        if (!empty($entity)) {
            return $this->packages->getUrl($entity->getPath());
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'breithbarbot_cropper_asset';
    }
}