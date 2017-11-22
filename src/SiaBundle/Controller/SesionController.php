<?php

namespace SiaBundle\Controller;

use SiaBundle\Entity\Sesion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sesion controller.
 *
 * @Route("sesion")
 */
class SesionController extends Controller
{
    /**
     * Lists all sesion entities.
     *
     * @Route("/", name="sesion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sesions = $em->getRepository('SiaBundle:Sesion')->findAll();

        return $this->render('sesion/index.html.twig', array(
            'sesions' => $sesions,
        ));
    }

    /**
     * Creates a new sesion entity.
     *
     * @Route("/new", name="sesion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sesion = new Sesion();
        $form = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sesion);
            $em->flush();

            return $this->redirectToRoute('sesion_show', array('id' => $sesion->getId()));
        }

        return $this->render('sesion/new.html.twig', array(
            'sesion' => $sesion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sesion entity.
     *
     * @Route("/{id}", name="sesion_show")
     * @Method("GET")
     */
    public function showAction(Sesion $sesion)
    {
        $deleteForm = $this->createDeleteForm($sesion);

        return $this->render('sesion/show.html.twig', array(
            'sesion' => $sesion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sesion entity.
     *
     * @Route("/{id}/edit", name="sesion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sesion $sesion)
    {
        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sesion_edit', array('id' => $sesion->getId()));
        }

        return $this->render('sesion/edit.html.twig', array(
            'sesion' => $sesion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sesion entity.
     *
     * @Route("/{id}", name="sesion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sesion $sesion)
    {
        $form = $this->createDeleteForm($sesion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sesion);
            $em->flush();
        }

        return $this->redirectToRoute('sesion_index');
    }

    /**
     * Creates a form to delete a sesion entity.
     *
     * @param Sesion $sesion The sesion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sesion $sesion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sesion_delete', array('id' => $sesion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
