<?php
// src/MyCompany/MyBundle/Form/CreateVehicleForm.php
namespace SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateActividadVisitanteForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $tipo = $options['tipo'];

        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                        'label' => '*Tipo de Actividad',
                        'choices' => array(
                            'Coloquio CCM' => 'Coloquio CCM',
                            'Coloquio PCCM' => 'Coloquio PCCM',
                            'Congreso' => 'Congreso',
                            'Curso' => 'Curso',
                            'Simposio' => 'Simposio',
                            'Divulgacion' => 'Divulgacion',
                            'Investigación' => 'Investigación',
                            'Seminario' => 'Seminario',
                            'Sinodal' => 'Sinodal'
                        ),
                        'placeholder' => 'Seleccionar',
                        'required' => true,
                        'choices_as_values' => true,
                    ));
                break;
            case 2:

                // This form type is not defined in the example.

                if ( $tipo === 'Investigación') {

                    $builder
                        ->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'label'=>'Título',
                            'required'=>true,
                            'choices'=>array(
                                'Dr.'=>'Dr.',
                                'Dra.'=>'Dra.',
                                'Est.'=>'Est.',
                                'Lic.' => 'Lic.',
                                'Mat.'=>'Mat.',
                                'M.C.'=>'M.C.',
                                'Sr.'=>'Sr.',
                                'Sra.'=>'Sra.',
                            ),
                        ))
                        ->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del invitado',
                            'required'=>false,
                        ))
                        ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Institución de origen',
                            'required'=>false,
                        ))
                        ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Departamento',
                            'required'=>false,
                        ))
                        ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Nacional',
                                false=>'Internacional'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Ámbito de la actividad',
                            'choices_as_values' => false,
                        ))
                        ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Lugar (ciudad, estado, país)',
                            'required'=>false,
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>false,
                        ));
                }
                elseif ($tipo === 'Sinodal')
                {
                    $builder//->remove('anfitrion')
                        ->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                        'label'=>'Título',
                        'required'=>true,
                        'choices'=>array(
                            'Dr.'=>'Dr.',
                            'Dra.'=>'Dra.',
                            'Est.'=>'Est.',
                            'Lic.' => 'Lic.',
                            'Mat.'=>'Mat.',
                            'M.C.C.'=>'M.C.C.',
                            'Sr.'=>'Sr.',
                            'Sra.'=>'Sra.',
                        ),
                    ))
                        ->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del invitado',
                            'required'=>false,
                        ))
                        ->add('sinodalAlumno', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del alumno',
                            'required'=>false,
                        ))
                        ->add('sinodalGrado', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                            'label'=>'Grado',
                            'choices'=>array(
                                'Licenciatura'=>'Licenciatura',
                                'Maestría'=>'Maestría',
                                'Doctorado'=>'Doctorado',
                                'Segunda etapa de candidatura' => 'Segunda etapa de candidatura',
                            ),
                            'placeholder'=>'Seleccionar',
                            'required'=>true,
                            'choices_as_values' => true,
                        ))
                        ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Institución',
                            'required'=>false,
                        ))
                        ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Departamento',
                            'required'=>false,
                        ))
                        ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Nacional',
                                false=>'Internacional'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Ámbito de la actividad',
                            'choices_as_values' => false,
                        ))
                        ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Lugar (ciudad, estado, país)',
                            'required'=>false,
                        ));
                }
                elseif ($tipo === 'Conferencia')
                {
                    $builder
                        ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del evento o actividad',
                            'required'=>false,
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>false,
                            'read_only'=>true,

                        ))
                        ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Institución',
                            'required'=>false,
                        ))
                        ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Departamento',
                            'required'=>false,
                        ))
                        ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Nacional',
                                false=>'Internacional'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Ámbito de la actividad',
                            'choices_as_values' => false,
                        ))
                        ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Lugar (ciudad, estado, país)',
                            'required'=>false,
                        ));
                }

                elseif( $tipo != '') {

                    $builder
                        ->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'label'=>'Título',
                            'required'=>true,
                            'choices'=>array(
                                'Dr.'=>'Dr.',
                                'Dra.'=>'Dra.',
                                'Est.'=>'Est.',
                                'Lic.' => 'Lic.',
                                'Mat.'=>'Mat.',
                                'M.C.C.'=>'M.C.C.',
                                'Sr.'=>'Sr.',
                                'Sra.'=>'Sra.',
                            ),
                        ))
                        ->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del invitado',
                            'required'=>false,
                        ))
                        ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del evento o actividad',
                            'required'=>false,
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>false,
                        ))
                        ->add('nacional', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Nacional',
                                false=>'Internacional'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Ámbito de la actividad',
                            'choices_as_values' => false,
                        ))
                        ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Institución de origen del invitado',
                            'required'=>false,
                        ))
                        ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Departamento',
                            'required'=>false,
                        ))
                        ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Lugar (ciudad, estado, país de origen)',
                            'required'=>false,
                        ));
                }

                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'tipo' => null,
        ));
    }

    public function getBlockPrefix() {
        return 'createActividadVisitante';
    }

}