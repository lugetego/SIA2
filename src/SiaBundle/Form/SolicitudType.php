<?php

namespace SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SiaBundle\Form\EventListener\AddNameFieldSubscriber;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SiaBundle\Entity\Actividad;
use SiaBundle\Entity\Financiamiento;



class SolicitudType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $tipo = $options['tipo'];

        $builder
            ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Tipo de Solicitud',
                'choices'=>array(
                    'Comision'=>'Comision',
                    'Licencia'=>'Licencia',
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
                'choices_as_values' => true,

            ))
            ->add('ambito', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    true=>'Nacional',
                    false=>'Internacional'),
                'expanded'=>true,
                'required'=>true,
                'label'=>'Ámbito de la solicitud',
                'choices_as_values' => false,
                'placeholder' => false

            ))
        ;

        $builder->add('financiamiento', 'collection', array(
            'required'=>false,
            'type' => new FinanciamientoType(),
            'allow_add' => true
        ));


        if ( $tipo === 'Comisión') {

            $builder->add('cartaInvitacionFile', 'vich_file', array(
                'required' => false,
                'label' => 'Carta de invitacion',
                'allow_delete' => false,
            ));

            $builder->add('planFile', 'vich_file', array(
                'required' => false,
                'label' => 'Plan de trabajo',
                'allow_delete' => false,
            ));

            $builder->add('cartaSolicitudFile', 'vich_file', array(
                'required' => false,
                'label' => 'Carta de solicitud',
                'allow_delete' => false,
            ));
        }

        $builder->add('fechaInicio', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
            'widget' => 'single_text',
            'html5' => false,
            'required' => false,));
        //$builder->add('fechaFin');
        $builder->add('fechaFin', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
            'widget' => 'single_text',
            'html5' => false,
            'required' => false,));

        $builder
            ->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                'required'=>false,
                'label'=>'Descripción',
            ))
            ->add('sesion')
            ->add('dictamen', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    true=>'Aprobada',
                    false=>'Rechazada'),
                'expanded'=>true,
                'required'=>false,
                'label'=>'Dictamen de la solicitud',
                'choices_as_values' => false,
                'placeholder' => false

            ))
            ->add('enviada', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    true=>'Si',
                    false=>'No'),
                'expanded'=>true,
                'required'=>false,
                'label'=>'Solicitud enviada',
                'choices_as_values' => false,
                'placeholder' => false

            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiaBundle\Entity\Solicitud',
            'tipo' => null,

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siabundle_solicitud';
    }


}
