<?php

/*
 * This file is part of the CropperBundle package.
 *
 * (c) Breith Barbot <b.breith@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use Breithbarbot\CropperBundle\Form\Type\BreithbarbotCropperType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Mapped = "true" if avatar exist
        $edit = (null !== $builder->getData()->getAvatar());
        $builder
            ->add('avatar', BreithbarbotCropperType::class, [
                'required' => false,
                'mapped' => $edit,
                'mapping' => 'user_avatar', // From: config/packages/breithbarbot_cropper.yaml
                'additional_data' => [
                    'entity_id' => $builder->getData()->getId(), // Get current ID
                    // [...]
                ],
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
