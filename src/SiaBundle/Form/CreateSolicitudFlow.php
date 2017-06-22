<?php

// src/MyCompany/MyBundle/Form/CreateVehicleFlow.php

namespace SiaBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class CreateSolicitudFlow extends FormFlow {

    protected $allowDynamicStepNavigation = true;
    protected $revalidatePreviousSteps = true;

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'Tipo de solicitud',
                'form_type' => 'SiaBundle\Form\CreateSolicitudForm',
            ),
            array(
                'label' => 'Detalles de la solicitud',
                'form_type' => 'SiaBundle\Form\CreateSolicitudForm',
            ),
/*            array(
                'label' => 'Detalles de Financiamiento',
                'form_type' => 'SiaBundle\Form\CreateSolicitudForm',
            ),
    */        array(
                'label' => 'Confirmación',
            ),
        );
    }

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);

        $formData = $this->getFormData();

        if ($step === 2) {

            $options['tipo'] = $formData->getTipo();
        }

        return $options;
    }

}