<?php

namespace SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SesionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha','Symfony\Component\Form\Extension\Core\Type\DateType',
                array(
                    'widget' => 'single_text',
                    'html5' => false,
                    'required' => true,))
            ->add('name','Symfony\Component\Form\Extension\Core\Type\TextType',
                array(
                    'label'=>'Nombre',
                    'required'=>true,))
            ->add('orden', 'ckeditor', array(
                'config_name' => 'sesion_config',
                'required' => false,
            ))
            ->add('estudiantes', 'ckeditor', array(
                'config_name' => 'sesion_config',
                'required' => false,
            ))
            ->add('varios', 'ckeditor', array(
                'config_name' => 'sesion_config',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiaBundle\Entity\Sesion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siabundle_sesion';
    }


}
