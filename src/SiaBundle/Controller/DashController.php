<?php

namespace SiaBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SiaBundle\Entity\Academico;
use SiaBundle\Entity\AcademicoRepository;
use SiaBundle\Entity\User;
use SiaBundle\Entity\Plan;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dash controller.
 *
 * @Route("/dash")
 */
class DashController extends Controller
{

    /**
     * Lists all actions on Sia .
     *
     * @Route("/", name="dashboard")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $academicos = $em->getRepository('SiaBundle:Academico')->findByActivo(true);
            $solicitudes = $em->getRepository('SiaBundle:Solicitud')->findPending();
            return $this->render('solicitud/index.html.twig', array(
                'solicituds'=>$solicitudes,
                'academicos'=> $academicos,
            ));
        }
        else {
            return $this->redirectToRoute('academico_show', array('slug' => $this->getUser()->getAcademico()->getSlug()));
        }

    }

    /**
     * Lists all academicos .
     *
     * @Route("/academico", name="academico")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function academicoAction()
    {
        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $academicos = $em->getRepository('SiaBundle:Academico')->findAllOrderedByApellido();
            return $this->render('dash/admin.html.twig', array(
                'academicos' => $academicos,
            ));
        }
        else {
            $user = $this->get('security.context')->getToken()->getUser();
            $academico = $user->getAcademico();
            $solicitudes = $academico->getSolicitudes();


            return $this->render('dash/index.html.twig', array(
                'academico'=> $academico,
                'solicitudes'=> $solicitudes,
                'user'=>$user,
            ));
        }
    }

    /**
     * Visitantes
     *
     * @Route("/visitantes", name="visitantes")
     * @Method({"GET"})
     * @Template()
     */
    public function visitantesAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $visitantes = $em->getRepository('SiaBundle:Solicitud')->findVisitantes(true);
//        $coloquios = $em->getRepository('SiaBundle:Solicitud')->findColoquios();
//        $conferencias = $em->getRepository('SiaBundle:Solicitud')->findConferencias();
//        $congresos = $em->getRepository('SiaBundle:Solicitud')->findCongresos();
//        $cursos = $em->getRepository('SiaBundle:Solicitud')->findCursos();
//        $seminarios= $em->getRepository('SiaBundle:Solicitud')->findSeminarios();

        return $this->render('dash/visitantes.html.twig', array(
            'visitantes'=> $visitantes,
//            'coloquios'=> $coloquios,
//            'conferencias'=> $conferencias,
//            'congresos'=> $congresos,
//            'cursos'=> $cursos,
//            'seminarios'=> $seminarios,
        ));
    }

    /**
     * Visitantes
     *
     * @Route("/eventos-academicos", name="eventos-academicos")
     * @Method({"GET"})
     * @Template()
     */
    public function eventosAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $coloquios = $em->getRepository('SiaBundle:Solicitud')->findEventos('Coloquio');
//        $conferencias = $em->getRepository('SiaBundle:Solicitud')->findEventos('Conferencia');
//        $congresos = $em->getRepository('SiaBundle:Solicitud')->findEventos('Congreso');
//        $cursos = $em->getRepository('SiaBundle:Solicitud')->findEvento('Curso');
//        $seminarios= $em->getRepository('SiaBundle:Solicitud')->findEvento('Seminario');

        return $this->render('dash/eventos.html.twig', array(
            'coloquios'=> $coloquios,
//            'conferencias'=> $conferencias,
//            'congresos'=> $congresos,
//            'cursos'=> $cursos,
//            'seminarios'=> $seminarios,
        ));
    }
}