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


class FinanciamientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('ccm', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                'grouping' => true,
            ))
            ->add('conacyt', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                'grouping' => true,
            ))
            ->add('papiit', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                'grouping' => true,
            ))
            ->add('otro', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'=>array(
                    'Comité organizador'=>'Comité organizador',
                    'Entidad convidante'=>'Entidad convidante',
                    'Entidad de adscripción'=>'Entidad de adscripción',
                    'Intercambio académico'=>'Intercambio académico',
                    'Partida especial evento'=>'Partida especial evento',
                    'PAEP'=>'PAEP',
                    'PAPIME'=>'PAPIME',
                    'Proyecto externo'=>'Proyecto externo',
                    'Recursos propios'=>'Recursos propios',
                    'No especifica'=>'No especifica'
                ),
                'placeholder'=>'Seleccionar',
                'required'=>false,
                'choices_as_values' => true,
            ))
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiaBundle\Entity\Financiamiento',

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siabundle_financiamiento';
    }



}