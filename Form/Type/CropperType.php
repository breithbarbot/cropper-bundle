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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropperType extends AbstractType
{
    /**
     * @var $dataClass
     */
    private $dataClass;

    /**
     * @var $container
     */
    private $container;

    /**
     * CropperType constructor.
     *
     * @param $dataClass
     * @param $container
     */
    public function __construct($dataClass, $container)
    {
        $this->dataClass = $dataClass;
        $this->container = $container;
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
            ->add('size', HiddenType::class, ['attr' => ['data-id' => 'size']])
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);

        if (!empty($options['mapped'])) {
            $mapping = $this->container->getParameter('breithbarbot_cropper.mappings')[$options['mapping']];
            $builder->add('_width', HiddenType::class, ['mapped' => false, 'data' => $mapping['width']]);
            $builder->add('_height', HiddenType::class, ['mapped' => false, 'data' => $mapping['height']]);
        }

        // If data, add delete field
        if ($builder->getData()) {
            $builder->add('delete', CheckboxType::class, ['mapped' => false, 'required' => false, 'label' => 'deleteImage', 'translation_domain' => 'BreithbarbotCropperBundle']);
        }
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!$data || !isset($data['delete'])) {
            return;
        }

        if ($data['delete']) {
//            $event->setData(null);
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
            'mapping'    => null,
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
