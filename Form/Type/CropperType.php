<?php
/******************************************************************************
 * Copyright (c) 2017 Cropper. All rights reserved.                           *
 * Author      : Breith Barbot                                                *
 * Updated at  : 12/03/17 19:30                                               *
 * File name   : CropperType.php                                              *
 * Description :                                                              *
 ******************************************************************************/

namespace Breithbarbot\CropperBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropperType extends AbstractType
{
    private $dataClass;

    /**
     * CropperType constructor.
     *
     * @param $dataClass
     */
    function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_path', HiddenType::class, ['attr' => ['data-id' => 'full_path']])
            ->add('path', HiddenType::class, ['attr' => ['data-id' => 'path']])
            ->add('name', HiddenType::class, ['attr' => ['data-id' => 'name']])
            ->add('mime_type', HiddenType::class, ['attr' => ['data-id' => 'mime_type']])
            ->add('size', HiddenType::class, ['attr' => ['data-id' => 'size']]);

        // TODO: a finir...
        // If Image
        if (false) {
            $builder->add('image_delete', CheckboxType::class, ['mapped' => false, 'label' => 'Supprimer l\'image', 'attr' => ['data-id' => 'image_delete']]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'breithbarbot_cropper_bundle_cropper_type';
    }
}
