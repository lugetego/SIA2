<?php

namespace SiaBundle\Controller;

use SiaBundle\Entity\Complementaria;
use SiaBundle\Entity\Solicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Complementaria controller.
 *
 * @Route("complementaria")
 */
class ComplementariaController extends Controller
{
    /**
     * Lists all complementaria entities.
     *
     * @Route("/", name="complementaria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $complementarias = $em->getRepository('SiaBundle:Complementaria')->findAll();

        return $this->render('complementaria/index.html.twig', array(
            'complementarias' => $complementarias,
        ));
    }

    /**
     * Creates a new complementarium entity.
     *
     * @Route("/new/{id}", name="complementaria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Solicitud $solicitud)
    {
        $complementaria = new Complementaria();

        $complementaria->setSolicitud($solicitud);
        $complementaria->setFechaInicio($solicitud->getFechaInicio());
        $complementaria->setFechaFin($solicitud->getFechaFin());

        if($solicitud->hasFinanciamento()) {
            $complementaria->setFinanciamiento($solicitud->getFinanciamiento());
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($complementaria);
        $em->flush();

//          return $this->redirectToRoute('complementaria_show', array('id' => $complementarium->getId()));
        return $this->redirectToRoute('complementaria_show', array('id' => $complementaria->getId()));

//        return $this->render('complementaria/new.html.twig', array(
//            'complementaria' => $complementaria,
//            'form' => $form->createView(),
//            'solicitud' => $solicitud,
//            'actividades'=> $solicitud->getActividades(),
//            'hasfinanciamiento' => $hasFinanciamiento,
//        ));
    }

    /**
     * Finds and displays a complementaria entity.
     *
     * @Route("/{id}", name="complementaria_show")
     * @Method("GET")
     */
    public function showAction(Complementaria $complementaria)
    {

        $solicitud = $complementaria->getSolicitud();
        $hasFinanciamiento = $solicitud->hasFinanciamento();

        return $this->render('complementaria/show.html.twig', array(
            'complementaria' => $complementaria,
            'solicitud' => $solicitud,
            'actividades'=> $solicitud->getActividades(),
            'hasfinanciamiento' => $hasFinanciamiento,
        ));
    }


    /**
     * Displays a form to edit an existing complementaria entity.
     *
     * @Route("/{id}/financiamiento", name="complementaria_financiamiento")
     * @Method({"GET", "POST"})
     */
    public function financiamientoAction(Request $request, Complementaria $complementaria)
    {

        $deleteForm = $this->createDeleteForm($complementaria);
        $editForm = $this->createForm('SiaBundle\Form\ComplementariaType', $complementaria);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $financiamientos = $complementaria->getFinanciamiento();
            $financiamiento[0] = clone $financiamientos[0];
            $financiamiento[1] = clone $financiamientos[1];
            $financiamiento[2] = clone $financiamientos[2];
            $financiamiento[3] = clone $financiamientos[3];

            $complementaria->setFinanciamiento($financiamiento);

            $this->getDoctrine()->getManager()->flush();

            //dump($editForm->get('financiamiento')->getData());
            return $this->redirectToRoute('complementaria_show', array('id' => $complementaria->getId()));
        }

        return $this->render('complementaria/financiamiento.html.twig', array(
            'complementaria' => $complementaria,
            'id'=>$complementaria->getId(),
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing complementarium entity.
     *
     * @Route("/{id}/edit", name="complementaria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Complementaria $complementarium)
    {
         $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deleteForm = $this->createDeleteForm($complementarium);
        $editForm = $this->createForm('SiaBundle\Form\ComplementariaType', $complementarium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('complementaria_edit', array('id' => $complementarium->getId()));
        }

        return $this->render('complementaria/edit.html.twig', array(
            'complementarium' => $complementarium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a complementarium entity.
     *
     * @Route("/{id}", name="complementaria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Complementaria $complementarium)
    {
        $form = $this->createDeleteForm($complementarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($complementarium);
            $em->flush();
        }

        return $this->redirectToRoute('complementaria_index');
    }

    /**
     * Creates a form to delete a complementarium entity.
     *
     * @param Complementaria $complementarium The complementarium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Complementaria $complementarium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('complementaria_delete', array('id' => $complementarium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
