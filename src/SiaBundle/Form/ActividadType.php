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


class ActividadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'label'=>'*Tipo de Actividad',
                'choices'=>array(
                    'Coloquio'=>'Coloquio',
                    'Conferencia'=>'Conferencia',
                    'Congreso'=>'Congreso',
                    'Curso'=>'Curso',
                    'Distinción'=>'Distinción',
                    'Feria'=>'Feria',
                    'Investigación'=>'Investigación',
                    'Jornadas'=>'Jornadas',
                    'Mesa redonda'=>'Mesa redonda',
                    'Reunión de trabajo'=>'Reunión de trabajo',
                    'Taller'=>'Taller',
                    'Seminario'=>'Seminario',
                    'Sinodal'=>'Sinodal'
                ),
                'placeholder'=>'Seleccionar',
                'required'=>true,
                'choices_as_values' => true,
            ))

        ;


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event)  {
                // this would be your entity, i.e. SportMeetup

                $tipo = $event->getData();
                $form = $event->getForm();



                // if ( $tipo->getTipo() === 'Investigación') {
                // $form->add('anfitrion');

                //}

                //else{
                //  $form->remove('anfitrion');

                //}

            }
        );


        $builder->get('tipo')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)

                // $tipo = $event->getData();


                $form = $event->getForm()->getParent();

                $form->remove('anfitrion');

                $tipo = $event->getData();

                if ( $tipo === 'Investigación') {

                    $form->add('anfitrion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
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
                        ->add('fechaActividad');

                }
                elseif ($tipo === 'Sinodal')
                {
                    $form->remove('anfitrion')

                        ->add('sinodalAlumno', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre del alumno',
                            'required'=>false,
                        ))
                        ->add('sinodalInstitucion', 'Symfony\Component\Form\Extension\Core\Type\TextType',array(
                            'label'=>'Nombre de la Institución',
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
                        ->add('fechaActividad')

                    ;
                }
                elseif ($tipo === 'Conferencia')
                {
                    $form
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
                        ->add('fechaActividad')
                    ;
                }

                elseif( $tipo != '') {

                    $form
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
                        ->add('fechaActividad')
                    ;
                }



                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                //$formModifier($event->getForm()->getParent(), $sport);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiaBundle\Entity\Actividad',
            'allow_extra_fields'=>true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siabundle_actividad';
    }


}
