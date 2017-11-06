<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;


class AcademicoType extends AbstractType
{

    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->securityContext->getToken()->getUser();

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder
            ->add('name','text',array(
                'required'=>false,
                'label'=>'Nombre'))
            ->add('apellido','text',array(
                'required'=>false,
                'label'=>'Apellido(s)'))
            ->add('nacimiento', 'date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=>'Fecha de nacimiento',
                'required'=>false,
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')))
            ->add('rfc','text',array(
                'required'=>false,
                'label'=>'RFC'));
            if ( true === $this->securityContext->isGranted('ROLE_ADMIN') ) {
                $builder
                ->add('user', null, array(
                    'label' => 'Usuario',
                    'required' => false));
                    }
        $builder
            ->add('dias','text',array('required'=>false,'label'=>'Días de licencia'))
            ->add('asignacion','text',array('required'=>false,'label'=>'Asignación anual'))
            ->add('save', 'submit', array('label' => 'Guardar'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ccm\SiaBundle\Entity\Academico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ccm_siabundle_academico';
    }
}
