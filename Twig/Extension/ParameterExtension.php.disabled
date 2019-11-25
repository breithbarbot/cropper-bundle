<?php

/*
 * This file is part of the CropperBundle package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Breithbarbot\CropperBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\Container;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @see https://symfony.com/doc/current/templating/twig_extension.html
 */
class ParameterExtension extends AbstractExtension
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('breithbarbot_cropper_parameter', [$this, 'getParameter']),
        ];
    }

    public function getParameter(string $name): array
    {
        if (!empty($name)) {
            return $this->container->getParameter($name);
        }

        return [];
    }

    public function getName(): string
    {
        return 'breithbarbot_cropper_parameter';
    }
}
