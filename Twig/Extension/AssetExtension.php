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
