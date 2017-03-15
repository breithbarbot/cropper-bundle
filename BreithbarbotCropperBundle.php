<?php
/******************************************************************************
 * Copyright (c) 2017 Cropper. All rights reserved.                           *
 * Author      : Breith Barbot                                                *
 * Updated at  : 12/03/17 19:05                                               *
 * File name   : BreithbarbotCropperBundle.php                                *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle;


use Breithbarbot\CropperBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BreithbarbotCropperBundle class
 *
 * @author Breith Barbot <b.breith@gmail.com>
 */
class BreithbarbotCropperBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }
}
