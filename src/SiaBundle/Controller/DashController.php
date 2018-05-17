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
//            $academicos = $em->getRepository('SiaBundle:Academico')->findAllOrderedByApellido();
//                return $this->render('dash/admin.html.twig', array(
//                    'academicos'=> $academicos,
//                ));
            $academicos = $em->getRepository('SiaBundle:Academico')->findByActivo(true);
            $solicitudes = $em->getRepository('SiaBundle:Solicitud')->findAllNew();
            return $this->render('solicitud/index.html.twig', array(
                'solicituds'=>$solicitudes,
                'academicos'=> $academicos,
            ));
        }

//        elseif ($this->get('security.context')->isGranted('ROLE_TECNICO'))
//        {
//            $user = $this->get('security.context')->getToken()->getUser();
//            $academico = $user->getAcademico();
//            //$tecnicos = $academico->getTecnicos();
//            //$enviado = $academico->isEnviado();
//            $solicitudes = $academico->getSolicitudes();
//
//
//            return $this->render('dash/tecnico.html.twig', array(
//                'academico'=>$academico,
//               // 'tecnicos'=> $tecnicos,
//               // 'enviado'=>$enviado,
//                'solicitudes'=>$solicitudes,
//                'user'=>$user,
//
//            ));
//        }

        else {

            return $this->redirectToRoute('academico_show', array('slug' => $this->getUser()->getAcademico()->getSlug()));
//            $user = $this->get('security.context')->getToken()->getUser();
//            $academico = $user->getAcademico();
//            $solicitudes = $academico->getSolicitudes();
//            // $estudiantes = $academico->getEstudiantes();
//            // $cursos = $academico->getCursos();
//            // $proyectos = $academico->getProyectos();
//            // $eventos = $academico->getEventos();
//            // $salidas = $academico->getSalidas();
//            // $planes = $academico->getPlanes();
//            // $posdocs = $academico->getPosdocs();
//            // $enviado = $academico->isEnviado();
//
//            return $this->render('dash/index.html.twig', array(
//                'academico'=> $academico,
//                'solicitudes'=> $solicitudes,
//                // 'estudiantes'=>$estudiantes,
//                //'cursos'=>$cursos,
//                //'proyectos'=>$proyectos,
//                //'eventos'=>$eventos,
//                //'salidas'=>$salidas,
//                //'planes'=>$planes,
//                //'posdocs'=>$posdocs,
//                'user'=>$user,
//                //'enviado'=>$enviado
//
//            ));
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
                // 'estudiantes'=>$estudiantes,
                //'cursos'=>$cursos,
                //'proyectos'=>$proyectos,
                //'eventos'=>$eventos,
                //'salidas'=>$salidas,
                //'planes'=>$planes,
                //'posdocs'=>$posdocs,
                'user'=>$user,
                //'enviado'=>$enviado

            ));
        }

    }


}