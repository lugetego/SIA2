<?php

namespace SiaBundle\Controller;

use SiaBundle\Entity\Academico;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Academico controller.
 *
 * @Route("academico")
 */
class AcademicoController extends Controller
{
    /**
     * Lists all academico entities.
     *
     * @Route("/", name="academico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $academicos = $em->getRepository('SiaBundle:Academico')->findAll();

        return $this->render('academico/index.html.twig', array(
            'academicos' => $academicos,
        ));
    }

    /**
     * Creates a new academico entity.
     *
     * @Route("/new", name="academico_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $academico = new Academico();
        $form = $this->createForm('SiaBundle\Form\AcademicoType', $academico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($academico);
            $em->flush();

            return $this->redirectToRoute('academico_show', array('slug' => $academico->getSlug()));
        }

        return $this->render('academico/new.html.twig', array(
            'academico' => $academico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a academico entity.
     *
     * @Route("/{slug}/{year}", requirements={"year" = "\d+"}, name="academico_show")
     *
     * @Method("GET")
     */
    public function showAction(Academico $academico, $year = '2018')
    {

//        $year = $this->container->getParameter('sia.year');
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $solicitudes = $em->getRepository('SiaBundle:Solicitud')->findAllByYear($academico, $year);

        $asignacionAnual = $this->container->getParameter('sia.asignacion_anual');
        $diasLicencia = $this->container->getParameter('sia.dias_licencia');
        $diasComision = $this->container->getParameter('sia.dias_comision');

        $totalDias = $diasLicencia + $diasComision;

        // Calcula Totales
        $totalAsignacionLicencia = $this->erogadoLicencias($solicitudes);
        $totalAsignacionComision = $this->erogadoComisiones($solicitudes);
        $totalAsignacionVisitante = $this->erogadoVisitantes($solicitudes);
        $totalDiasLicencia = $this->diasSolicitadosLicencia($solicitudes);
        $totalDiasComision = $this->diasSolicitadosComision($solicitudes);

        $deleteForm = $this->createDeleteForm($academico);

        return $this->render('academico/show.html.twig', array(
            'year' => $year,
            'academico' => $academico,
            'solicitudes' => $solicitudes,
            'delete_form' => $deleteForm->createView(),
            'asignacionLicencia' => $totalAsignacionLicencia,
            'asignacionComision' => $totalAsignacionComision,
            'asignacionVisitante' => $totalAsignacionVisitante,
            'diasLicencia' => $totalDiasLicencia,
            'diasComision' => $totalDiasComision,
            'totalDias' => $totalDias,
            'asignacionAnual' => $asignacionAnual,
        ));
    }

    /**
     * Displays a form to edit an existing academico entity.
     *
     * @Route("/{slug}/edit", name="academico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Academico $academico)
    {
        $deleteForm = $this->createDeleteForm($academico);
        $editForm = $this->createForm('SiaBundle\Form\AcademicoType', $academico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academico_edit', array('slug' => $academico->getSlug()));
        }

        return $this->render('academico/edit.html.twig', array(
            'academico' => $academico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a academico entity.
     *
     * @Route("/{slug}", name="academico_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Academico $academico)
    {
        $form = $this->createDeleteForm($academico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($academico);
            $em->flush();
        }

        return $this->redirectToRoute('academico_index');
    }

    /**
     * Creates a form to delete a academico entity.
     *
     * @param Academico $academico The academico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Academico $academico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('academico_delete', array('slug' => $academico->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Erogado Licencias
     * Regresa el total de la asignación anual solicitado por licencia
     *
     */
    public function erogadoLicencias($solicitudes)
    {
        $erogadoLicencias = 0;

        foreach ($solicitudes as $solicitud) {
            if($solicitud->getTipo() == 'Licencia' && $solicitud->isErogadoAsignacion())
                $erogadoLicencias += $solicitud->getTotalAsignacion();
        }
        return $erogadoLicencias;
    }

    /**
     * Erogado Comisiones
     * Regresa el total de la asignación anual solicitado por comisión
     *
     */
    public function erogadoComisiones($solicitudes)
    {
        $erogadoComisiones = 0;
        foreach ($solicitudes as $solicitud) {
            if($solicitud->getTipo() == 'Comisión' && $solicitud->isErogadoAsignacion())
                $erogadoComisiones += $solicitud->getTotalAsignacion();
        }
        return $erogadoComisiones;
    }
    /**
     * Erogado Visitantes
     * Regresa el total de la asignación anual solicitado para visitantes
     *
     */
    public function ErogadoVisitantes($solicitudes)
    {
        $erogadoVisitantes = 0;
        foreach ($solicitudes as $solicitud) {
            if($solicitud->getTipo() == 'Visitante' && $solicitud->isErogadoAsignacion())
                $erogadoVisitantes += $solicitud->getTotalAsignacion();
        }
        return $erogadoVisitantes;
    }
    /**
     * Dias Solicitados de licencia
     * Regresa el total de dias solicitados por licencia
     *
     */
    public function diasSolicitadosLicencia($solicitudes)
    {
        $dias = 0;
        foreach ($solicitudes as $solicitud) {
            if($solicitud->getTipo() == 'Licencia')
                $dias += $solicitud->getDias();
        }
        return $dias;
    }
    /**
     * Dias Solicitados de comisión
     * Regresa el total de dias solicitados por comision
     *
     */
    public function diasSolicitadosComision($solicitudes)
    {
        $dias = 0;
        foreach ($solicitudes as $solicitud) {
            if($solicitud->getTipo() == 'Comisión')
                $dias += $solicitud->getDias();
        }
        return $dias;
    }
}
