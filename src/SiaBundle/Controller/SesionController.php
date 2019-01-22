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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $today = new \DateTime(date('Y-m-d'));
        $em = $this->getDoctrine()->getManager();

        $sesions = $em->getRepository('SiaBundle:Sesion')->findBy(array(),array('fecha'=>'DESC'));

        $proximaSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($today);

        $diff = $proximaSesion->getFecha()->diff($today);

//        // Dos días antes de la sesión busca la siguiente en el calendario
//        if($diff->format('d') < 2) {
//            $proximaSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($proxSesion->getFecha());
//        }

        // Diff < 2 busca siguiente sesión de consejo

        return $this->render(':sesion:index.html.twig', array(
            'sesions' => $sesions,
            'proximaSesion' => $proximaSesion,
            'diff' => $diff,
            'today' => $today,
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $licencias = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Licencia', $sesion);
        $comisiones = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Comisión', $sesion);
        $visitantes = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Visitante', $sesion);

        return $this->render('sesion/recomendaciones.html.twig', array(
            'sesion' => $sesion,
            'licencias' => $licencias,
            'comisiones' => $comisiones,
            'visitantes' => $visitantes,
        ));
    }

    /**
     * Aprueba las solicitudes de una sesión
     *
     * @Route("/{slug}/aprueba-solicitudes/", name="sesion_aprueba")
     * @Method("GET")
     */
    public function apruebaSolicitudesAction(Sesion $sesion)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
//        $solicitudes = $em->getRepository('SiaBundle:Sesion')->findAllSolicitudesBySesion($sesion);

        $solicitudes = $sesion->getSolicitudes();

        $i = 0;
        foreach($solicitudes as $solicitud) {

            if($solicitud->isEnviada()) {
                $solicitud->setDictamen(true);
                $em->persist($solicitud);
                $i = $i + 1;
            }

            $em->flush();
        }

        $this->addFlash(
            'notice',
            $i . ' Solicitudes fueron aprobadas'
        );

        return $this->redirectToRoute('sesion_show', array('slug' => $sesion->getSlug()));

    }

    /**
     * Export to PDF
     *
     * @Route("/{slug}/recomendaciones/pdf", name="sesion_recomendaciones_pdf")
     */
    public function recomendacionespdfAction(Sesion $sesion)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $licencias = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Licencia', $sesion);
        $comisiones = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Comisión', $sesion);
        $visitantes = $em->getRepository('SiaBundle:Sesion')->findSolicitudes('Visitante', $sesion);

        $html = $this->renderView('sesion/recomendacionespdf.html.twig', array(
            'sesion'=>$sesion,
            'licencias' => $licencias,
            'comisiones' => $comisiones,
            'visitantes' => $visitantes,
        ));

        $filename = sprintf('Recomendaciones-'.$sesion->getSlug().'%s.pdf','-'. $sesion->getFecha()->format('d/m/Y'));

        $footer = $this->renderView('sesion/footer.html.twig');

        $pdfOptions = array(

            'viewport-size'=> '1920x1080',
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
            'encoding' => 'utf-8',
            'footer-html' => $footer,
            'footer-center'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'page-width'=> 210,
            'page-height'=> 333,
            'user-style-sheet'=> $path = $this->get('kernel')->getRootDir() . '/../web/css/pdf.css'
        ,
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

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->remove('name');
        $editForm->remove('fecha');
        $editForm->remove('varios');
        $editForm->remove('estudiantes');

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
     * @Route("/{slug}/estudiantes", name="sesion_estudiantes")
     * @Method({"GET", "POST"})
     */
    public function estudiantesAction(Request $request, Sesion $sesion)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->remove('name');
        $editForm->remove('fecha');
        $editForm->remove('orden');
        $editForm->remove('varios');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sesion_recomendaciones', array('slug' => $sesion->getSlug()));
        }

        return $this->render('sesion/estudiantes.html.twig', array(
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deleteForm = $this->createDeleteForm($sesion);
        $editForm = $this->createForm('SiaBundle\Form\SesionType', $sesion);
        $editForm->remove('name');
        $editForm->remove('fecha');
        $editForm->remove('orden');
        $editForm->remove('estudiantes');

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
