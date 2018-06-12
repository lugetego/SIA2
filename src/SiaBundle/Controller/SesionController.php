<?php

namespace SiaBundle\Controller;

use SiaBundle\Entity\Sesion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $sesions = $em->getRepository('SiaBundle:Sesion')->findBy(array(),array('fecha'=>'DESC'));

        return $this->render(':sesion:index.html.twig', array(
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $sesion = new Sesion();
        $form = $this->createForm('SiaBundle\Form\SesionType', $sesion);

        $form->remove('orden');
        $form->remove('varios');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sesion);
            $em->flush();

//            return $this->redirectToRoute('sesion_show', array('id' => $sesion->getId()));
            return $this->redirectToRoute('sesion_index');
        }

        return $this->render('sesion/new.html.twig', array(
            'sesion' => $sesion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Genera el acta de recomendaciones.
     *
     * @Route("/{slug}/recomendaciones/", name="sesion_recomendaciones")
     * @Method("GET")
     */
    public function recomendacionesAction(Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('sesion/recomendaciones.html.twig', array(
            'sesion' => $sesion,
        ));
    }

    /**
     * Export to PDF
     *
     * @Route("/{slug}/recomendaciones/pdf", name="sesion_recomendaciones_pdf")
     */
    public function recomendacionespdfAction(Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $html = $this->renderView('sesion/recomendacionespdf.html.twig', array(
            'sesion'=>$sesion,
        ));

        $filename = sprintf($sesion->getSlug().'%s.pdf','-'. $sesion->getFecha()->format('d/m/Y'));

        $footer = $this->renderView('sesion/footer.html.twig');


        $pdfOptions = array(

            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
            'encoding' => 'utf-8',
            'footer-html' => $footer,
            'footer-center'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,

        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );
    }

    /**
     * Finds and displays a sesion entity.
     *
     * @Route("/{slug}", name="sesion_show")
     * @Method("GET")
     */
    public function showAction(Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($sesion);

        return $this->render('sesion/show.html.twig', array(
            'sesion' => $sesion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sesion entity.
     *
     * @Route("/{slug}/edit", name="sesion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

//            return $this->redirectToRoute('sesion_edit', array('id' => $sesion->getId()));
            return $this->redirectToRoute('sesion_index');


        }

        return $this->render('sesion/edit.html.twig', array(
            'sesion' => $sesion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sesion entity.
     *
     * @Route("/{slug}/orden", name="sesion_orden")
     * @Method({"GET", "POST"})
     */
    public function ordenAction(Request $request, Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->remove('name');
        $editForm->remove('fecha');
        $editForm->remove('varios');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sesion_recomendaciones', array('slug' => $sesion->getSlug()));
        }

        return $this->render('sesion/orden.html.twig', array(
            'sesion' => $sesion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sesion entity.
     *
     * @Route("/{slug}/varios", name="sesion_varios")
     * @Method({"GET", "POST"})
     */
    public function variosAction(Request $request, Sesion $sesion)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->remove('name');
        $editForm->remove('fecha');
        $editForm->remove('orden');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sesion_recomendaciones', array('slug' => $sesion->getSlug()));
        }

        return $this->render('sesion/varios.html.twig', array(
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

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
