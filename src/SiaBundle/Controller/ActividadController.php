<?php

namespace SiaBundle\Controller;

use Proxies\__CG__\SiaBundle\Entity\Solicitud;
use SiaBundle\Entity\Actividad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Actividad controller.
 *
 * @Route("actividad")
 */
class ActividadController extends Controller
{
    /**
     * Lists all actividad entities.
     *
     * @Route("/", name="actividad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actividads = $em->getRepository('SiaBundle:Actividad')->findAll();

        return $this->render('actividad/index.html.twig', array(
            'actividads' => $actividads,
        ));
    }

    /**
     *
     * @Route("/step/{id}", name="actividad_step",)
     * @Method({"GET", "POST"})
     */
    public function createActividadAction($id)
    {
        $formData = new Actividad(); // Your form data class. Has to be an object, won't work properly with an array.
        $solicitud = $this->getDoctrine()
            ->getRepository('SiaBundle:Solicitud')
            ->find($id);

        $flow = $this->get('Ccm.form.flow.createActividad'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
//        $form = $flow->createForm($formData,array('tipo'=>$tipo));
        $form = $flow->createForm('SiaBundle\Form\CreateActividadForm', $formData, array('tipo' => null));

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();

                $solicitud->addActividades($formData);

                $em->persist($formData);

                $em->flush();

                $flow->reset(); // remove step data from the session

                //return $this->redirect($this->generateUrl('solicitud_index')); // redirect when done
                return $this->redirectToRoute('solicitud_show', array('id' => $id));

            }
        }
        return $this->render('solicitud/createActividad.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'id'=>$id,
            'formdata' => $formData,

        ));
    }

    /**
     *
     * @Route("/step-visitante/{id}", name="actividad_visitante_step",)
     * @Method({"GET", "POST"})
     */
    public function createActividadVisitanteAction($id)
    {
        $formData = new Actividad(); // Your form data class. Has to be an object, won't work properly with an array.
        $solicitud = $this->getDoctrine()
            ->getRepository('SiaBundle:Solicitud')
            ->find($id);

        $flow = $this->get('Ccm.form.flow.createActividadVisitante'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
//        $form = $flow->createForm($formData,array('tipo'=>$tipo));
        $form = $flow->createForm('SiaBundle\Form\CreateActividadVisitanteForm', $formData, array('tipo' => null));

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();

                $solicitud->addActividades($formData);

                $em->persist($formData);

                $em->flush();

                $flow->reset(); // remove step data from the session

                //return $this->redirect($this->generateUrl('solicitud_index')); // redirect when done
                return $this->redirectToRoute('solicitud_show', array('id' => $id));

            }
        }
        return $this->render('solicitud/createActividadVisitante.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'id'=>$id,
            'formdata' => $formData,

        ));
    }

    /**
     * Creates a new actividad entity.
     *
     * @Route("/new", name="actividad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $actividad = new Actividad();
        $form = $this->createForm('SiaBundle\Form\ActividadType', $actividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actividad);
            $em->flush();

            return $this->redirectToRoute('actividad_show', array('id' => $actividad->getId()));
            //return $this->redirectToRoute('a_new');

        }

        return $this->render('actividad/new.html.twig', array(
            'actividad' => $actividad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a actividad entity.
     *
     * @Route("/{id}", name="actividad_show")
     * @Method("GET")
     */
    public function showAction(Actividad $actividad)
    {
        $deleteForm = $this->createDeleteForm($actividad);
        $solicitud = $actividad->getSolicitud();

        return $this->render('actividad/show.html.twig', array(
            'actividad' => $actividad,
            'delete_form' => $deleteForm->createView(),
            'solicitud' => $solicitud
        ));
    }

    /**
     * Finds and displays actividades from a solicitud.
     *
     * @Route("/{id}/recomendacion", name="actividad_formato")
     * @Method("GET")
     */
    public function recomendacionAction(Actividad $actividad)
    {
        // TODO grant access

        return $this->render('actividad/recomendacion.html.twig', array(
            'actividad' => $actividad,
        ));
    }

    /**
     * Displays a form to edit an existing actividad entity.
     *
     * @Route("/{id}/edit", name="actividad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Actividad $actividad)
    {
        $deleteForm = $this->createDeleteForm($actividad);
        $editForm = $this->createForm('SiaBundle\Form\ActividadType', $actividad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actividad_edit', array('id' => $actividad->getId()));
        }

        return $this->render('actividad/edit.html.twig', array(
            'actividad' => $actividad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actividad entity.
     *
     * @Route("/{id}", name="actividad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Actividad $actividad)
    {
        $form = $this->createDeleteForm($actividad);
        $form->handleRequest($request);
        $solicitud = $actividad->getSolicitud()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actividad);
            $em->flush();
        }

       // return $this->redirectToRoute('actividad_index');
        return $this->redirectToRoute('solicitud_show', array('id' => $solicitud));

    }

    /**
     * Creates a form to delete a actividad entity.
     *
     * @param Actividad $actividad The actividad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actividad $actividad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actividad_delete', array('id' => $actividad->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
