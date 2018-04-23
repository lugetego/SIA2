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

            return $this->redirectToRoute('academico_show', array('id' => $academico->getId()));
        }

        return $this->render('academico/new.html.twig', array(
            'academico' => $academico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a academico entity.
     *
     * @Route("/{id}", name="academico_show")
     * @Method("GET")
     */
    public function showAction(Academico $academico)
    {
        $deleteForm = $this->createDeleteForm($academico);

        return $this->render('academico/show.html.twig', array(
            'academico' => $academico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing academico entity.
     *
     * @Route("/{id}/edit", name="academico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Academico $academico)
    {
        $deleteForm = $this->createDeleteForm($academico);
        $editForm = $this->createForm('SiaBundle\Form\AcademicoType', $academico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academico_edit', array('id' => $academico->getId()));
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
     * @Route("/{id}", name="academico_delete")
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
            ->setAction($this->generateUrl('academico_delete', array('id' => $academico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
