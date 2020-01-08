<?php

/*
 * This file is part of the Cropper package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle;

use Breithbarbot\CropperBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BreithbarbotCropperBundle class.
 *
 * @author Breith Barbot <b.breith@gmail.com>
 */
class BreithbarbotCropperBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }
}
