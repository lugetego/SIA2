<?php
// src/MyCompany/MyBundle/Form/CreateVehicleForm.php
namespace SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateActividadForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $tipo = $options['tipo'];

        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                        'label' => '*Tipo de Actividad',
                        'choices' => array(
                            'Coloquio' => 'Coloquio',
                            'Conferencia' => 'Conferencia',
                            'Congreso' => 'Congreso',
                            'Curso' => 'Curso',
                            'Distinción Académica' => 'Distinción Académica',
                            'Feria' => 'Feria',
                            'Investigación' => 'Investigación',
                            'Jornadas' => 'Jornadas',
                            'Mesa redonda' => 'Mesa redonda',
                            'Reunión de trabajo' => 'Reunión de trabajo',
                            'Taller' => 'Taller',
                            'Seminario' => 'Seminario',
                            'Sinodal' => 'Sinodal',
                            'Asesoría Tesis' => 'Asesoría Tesis'
                        ),
                        'placeholder' => 'Seleccionar',
                        'required' => true,
                        'choices_as_values' => true,
                    ));
                break;
            case 2:

                // This form type is not defined in the example.

                if ( $tipo === 'Investigación') {

                    $builder->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                        'label'=>'Nombre del anfitrión',
                        'required'=>false,
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
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>true,
                            'read_only'=>false,
                        ))
                        ->add('fechaActividad', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                            'widget' => 'single_text',
                            'html5' => false,
                            'required' => false,));

                }
                elseif ($tipo === 'Sinodal' || $tipo === 'Asesoría Tesis')
                {
                    $builder->remove('anfitrion')

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
                        ))
                        ->add('fechaActividad', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                            'widget' => 'single_text',
                            'html5' => false,
                            'required' => false,));
                }
                elseif ($tipo === 'Conferencia' or $tipo === 'Congreso')
                {
                    $builder
                        ->add('motivo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                            'label'=>'*Motivo de la Actividad',
                            'choices'=>array(
                                'Asistencia'=>'Asistencia',
                                'Divulgación'=>'Divulgación',
                                'Participación'=>'Participación',
                                'Organización'=>'Organización',
                            ),
                            'placeholder'=>'Seleccionar',
                            'required'=>true,
                            'expanded'=>true,
                            'multiple'=>true,

                        ))
                        ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del evento',
                            'required'=>false,
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>false,
                            'read_only'=>true,

                        ))
                        ->add('plenaria', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Si',
                                false=>'No'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Conferencia plenaria',
                            'choices_as_values' => false,
                        ))
                        ->add('invitacion', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Si',
                                false=>'No'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Por invitación',
                            'choices_as_values' => false,
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
                        ))
                        ->add('fechaActividad', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                            'widget' => 'single_text',
                            'html5' => false,
                            'required' => false));
                }
                elseif( $tipo != '') {

                    $builder
                        ->add('motivo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                            'label'=>'*Motivo de la Actividad',
                            'choices'=>array(
                                'Asistencia'=>'Asistencia',
                                'Divulgación'=>'Divulgación',
                                'Participación'=>'Participación',
                                'Organización'=>'Organización',
                            ),
                            'placeholder'=>'Seleccionar',
                            'required'=>true,
                            'expanded'=>true,
                            'multiple'=>true,

                        ))
                        ->add('nombreEvento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del evento',
                            'required'=>false,
                        ))
                        ->add('tituloTrabajo', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Título del trabajo',
                            'required'=>false,
                            'read_only'=>true,

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
                        ->add('invitacion', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                            'choices'=>array(
                                true=>'Si',
                                false=>'No'),
                            'expanded'=>true,
                            'required'=>true,
                            'label'=>'Por invitación',
                            'choices_as_values' => false,
                        ))
                        ->add('institucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Institución',
                            'required'=>false,
                        ))
                        ->add('departamento', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Departamento',
                            'required'=>false,
                        ))
                        ->add('lugar', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Lugar (ciudad, estado, país)',
                            'required'=>false,
                        ))
                        ->add('fechaActividad', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                            'widget' => 'single_text',
                            'html5' => false,
                            'required' => false,));
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
        return 'createActividad';
    }

}