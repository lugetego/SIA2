<?php
// src/MyCompany/MyBundle/Form/CreateVehicleForm.php
namespace SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateSolicitudForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $tipo = $options['tipo'];


        switch ($options['flow_step']) {
            case 1:
                $builder->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                    'label'=>'*Tipo de Solicitud',
                    'choices'=>array(
                        'Comisión'=>'Comisión',
                        'Licencia'=>'Licencia',
                        'Visitante'=>'Visitante',
                    ),
                    'placeholder'=>'Seleccionar',
                    'required'=>true,
                    'choices_as_values' => true,
                ));
                break;
            case 2:
                // This form type is not defined in the example.

                $builder->
                add('ambito', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                    'choices'=>array(
                        true=>'Nacional',
                        false=>'Internacional'),
                    'expanded'=>true,
                    'required'=>true,
                    'label'=>'Ámbito de la solicitud',
                    'choices_as_values' => false,

                ));

                if ( $tipo === 'Comisión') {

                    $builder->add('cartaInvitacionFile', 'vich_file', array(
                        'required'=> false,
                        'label' => 'Carta de invitacion',
                        'allow_delete' => false,
                    ));

                    $builder->add('planFile', 'vich_file', array(
                        'required'=> false,
                        'label' => 'Plan de trabajo',
                        'allow_delete' => false,
                    ));

                    $builder->add('cartaSolicitudFile', 'vich_file', array(
                        'required'      => false,
                        'label' => 'Carta de solicitud',
                        'allow_delete' => false,
                    ));

                    //$builder->add('fechaInicio');
                    $builder->add('fechaInicio', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                        'widget' => 'single_text',
                        'html5' => false,
                        'required' => false,));
                    //$builder->add('fechaFin');
                    $builder->add('fechaFin', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                        'widget' => 'single_text',
                        'html5' => false,
                        'required' => false,));
                }

                else {

                    $builder->add('fechaInicio', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                        'widget' => 'single_text',
                        'html5' => false,
                        'required' => false,));
                    //$builder->add('fechaFin');
                    $builder->add('fechaFin', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                        'widget' => 'single_text',
                        'html5' => false,
                        'required' => false,));
                }
                break;

//            case 3:
//                $builder->add('financiamiento', 'collection', array(
//                    'required'=>false,
//                    'type' => new FinanciamientoType(),
//                    'allow_add' => true
//                ));
//                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'tipo' => null,
        ));
    }

    public function getBlockPrefix() {
        return 'createSolicitud';
    }

}