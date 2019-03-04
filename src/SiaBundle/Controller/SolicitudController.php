<?php

namespace SiaBundle\Controller;

use SiaBundle\Entity\Solicitud;
use SiaBundle\Entity\Actividad;
use SiaBundle\Entity\Financiamiento;
use SiaBundle\Entity\Sesion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use SiaBundle\Security\SiaVoter;
use SiaBundle\Entity\User;
use SiaBundle\Entity\Academico;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Solicitud controller.
 *
 * @Route("solicitud")
 */
class SolicitudController extends Controller
{
    /**
     * Lists all solicitud entities.
     *
     * @Route("/", name="solicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('dashboard');
        }

        $solicitudes = $em->getRepository('SiaBundle:Solicitud')-> findAllByYear($user->getAcademico(), '2019');

        return $this->render('solicitud/index.html.twig', array(
            'solicituds' => $solicitudes,

        ));
    }

    /**
     * Lists all solicitud entities.
     *
     * @Route("/step", name="solicitud_step")
     * @Method({"GET", "POST"})
     */
    public function createSolicitudAction()
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $formData = new Solicitud(); // Your form data class. Has to be an object, won't work properly with an array.

        $securityContext = $this->container->get('security.token_storage');

        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

       $viaticos = new Financiamiento();
       $viaticos->setNombre("Viáticos");
       $viaticos->setCcm(0);
       $viaticos->setPapiit(0);
       $viaticos->setConacyt(0);
//       $viaticos->setOtro('');
       $formData->getFinanciamiento()->add($viaticos);

       $aereo = new Financiamiento();
       $aereo->setNombre("Pasaje aéreo");
       $aereo->setCcm(0);
       $aereo->setPapiit(0);
       $aereo->setConacyt(0);
//       $aereo->setOtro('');
       $formData->getFinanciamiento()->add($aereo);

       $terrestre = new Financiamiento();
       $terrestre->setNombre("Pasaje terrestre");
       $terrestre->setCcm(0);
       $terrestre->setPapiit(0);
       $terrestre->setConacyt(0);
//       $terrestre->setOtro('');
       $formData->getFinanciamiento()->add($terrestre);

       $inscripciones = new Financiamiento();
       $inscripciones->setNombre("Inscripciones");
       $inscripciones->setCcm(0);
       $inscripciones->setPapiit(0);
       $inscripciones->setConacyt(0);
//       $inscripciones->setOtro('');
       $formData->getFinanciamiento()->add($inscripciones);

        $flow = $this->get('Ccm.form.flow.createSolicitud'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
//        $form = $flow->createForm($formData,array('tipo'=>$tipo));
        $form = $flow->createForm('SiaBundle\Form\CreateSolicitudForm', $formData, array('tipo'=>null));

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();
                $formData->setAcademico($academico);
                $formData->setErogadoAsignacion(true);
                $formData->setCancelada(false);
                $em->persist($formData);
                $em->flush();

                $flow->reset(); // remove step data from the session

                //return $this->redirect($this->generateUrl('solicitud_index')); // redirect when done
                return $this->redirectToRoute('solicitud_show', array('id' => $formData->getId()));

            }
        }

        return $this->render('solicitud/createSolicitud.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'formdata' => $formData,
        ));
    }


    /**
     * Creates a new solicitud entity.
     *
     * @Route("/new", name="solicitud_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $solicitud = new Solicitud();

        $form = $this->createForm('SiaBundle\Form\SolicitudType', $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()  ) {

            $em = $this->getDoctrine()->getManager();
            $solicitud->setErogadoAsignacion(true);
            $solicitud->setCancelada(false);
            $em->persist($solicitud);
            $em->flush();

            return $this->redirectToRoute('solicitud_show', array('id' => $solicitud->getId()));
        }

        return $this->render('solicitud/new.html.twig', array(
            'solicitud' => $solicitud,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a solicitud entity.
     *
     * @Route("/{id}", name="solicitud_show")
     * @Method("GET")
     */
    public function showAction(Solicitud $solicitud)
    {
        $this->denyAccessUnlessGranted('edit', $solicitud);

        $deleteForm = $this->createDeleteForm($solicitud);

        $em = $this->getDoctrine()->getManager();

        $now = new \DateTime('NOW');
        $proxSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($now);

        $diff = $proxSesion->getFecha()->diff($now);

        // Si es menor a dos días busca la próxima sesión
        // Se cierra el viernes anterior
        if($diff->format('%a') < 3) {
            $proxSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($proxSesion->getFecha());
        }

        $hasFinanciamiento = $solicitud->hasFinanciamento();

        return $this->render('solicitud/show.html.twig', array(
            'solicitud' => $solicitud,
            'delete_form' => $deleteForm->createView(),
            'actividades'=> $solicitud->getActividades(),
            'hasfinanciamiento' => $hasFinanciamiento,
            'proxSesion' => $proxSesion,
            'diff' => $diff->format('%a'),
        ));
    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/{id}/edit", name="solicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Solicitud $solicitud)
    {
        $this->denyAccessUnlessGranted('edit', $solicitud);

        $deleteForm = $this->createDeleteForm($solicitud);
        $editForm = $this->createForm('SiaBundle\Form\SolicitudType', $solicitud, array('tipo'=>$solicitud->getTipo()));

        $editForm->remove('tipo');
        $editForm->remove('financiamiento');


        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $editForm->remove('descripcion');
            $editForm->remove('sesion');
            $editForm->remove('dictamen');
            $editForm->remove('aprobada');
            $editForm->remove('enviada');
            $editForm->remove('erogadoAsignacion');
            $editForm->remove('cancelada');
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'La solicitud se ha modificado'
            );

            return $this->redirectToRoute('solicitud_show', array('id' => $solicitud->getId()));
        }

        return $this->render('solicitud/edit.html.twig', array(
            'solicitud' => $solicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Envío de solicitud
     *
     * @Route("/{id}/envio", name="solicitud_envio")
     */
    public function sendAction(Request $request, Solicitud $solicitud)
    {

        $em = $this->getDoctrine()->getManager();
        $fechaEnvio = new \DateTime(date('NOW'));

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $academico = $user->getAcademico();

        $solicitud->setEnviada(true);
        $solicitud->setFechaEnviada($fechaEnvio);

        $proxSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($fechaEnvio);

        $diff = $proxSesion->getFecha()->diff($fechaEnvio);

        // Si es menor a dos días busca la próxima sesión
        // Se cierra el viernes anterior
        if($diff->format('%a') < 3) {
            $proxSesion = $em->getRepository('SiaBundle:Sesion')->findProxSesion($proxSesion->getFecha());
        }

        $solicitud->setSesion($proxSesion);
        $em->persist($solicitud);
        $em->flush();

        // Obtiene correo y msg de la forma de contacto
        $subject = 'Solicitud '. ' '. $solicitud->getTipo() .' - ' . $solicitud->getAcademico()->getNombre() . ' ' . $solicitud->getAcademico()->getApellido();

        $mailer = $this->get('mailer');

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('webmaster@matmor.unam.mx')
//            ->setTo('miguel@matmor.unam.mx')
            ->setTo(array($user->getEmail()))
            ->setCc('vorozco@matmor.unam.mx')
            ->setBcc(array('rudos@matmor.unam.mx'))
            ->setBody($this->renderView('solicitud/mail.txt.twig', array('solicitud' => $solicitud)))
        ;
        $mailer->send($message);

//        return $this->redirectToRoute('academico_show', {});
        return $this->redirectToRoute('academico_show', array('slug' => $this->getUser()->getAcademico()->getSlug()));

    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/{id}/financiamiento", name="solicitud_financiamiento")
     * @Method({"GET", "POST"})
     */
    public function financiamientoAction(Request $request, Solicitud $solicitud)
    {

        $deleteForm = $this->createDeleteForm($solicitud);
        $editForm = $this->createForm('SiaBundle\Form\SolicitudType', $solicitud);

        $editForm->remove('tipo');
        $editForm->remove('ambito');
        $editForm->remove('fechaInicio');
        $editForm->remove('fechaFin');
        $editForm->remove('descripcion');
        $editForm->remove('sesion');
        $editForm->remove('dictamen');
        $editForm->remove('enviada');
        $editForm->remove('erogadoAsignacion');
        $editForm->remove('cancelada');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $financiamientos = $solicitud->getFinanciamiento();
            $financiamiento[0] = clone $financiamientos[0];
            $financiamiento[1] = clone $financiamientos[1];
            $financiamiento[2] = clone $financiamientos[2];
            $financiamiento[3] = clone $financiamientos[3];

            $solicitud->setFinanciamiento($financiamiento);

            $this->getDoctrine()->getManager()->flush();

            //dump($editForm->get('financiamiento')->getData());
            return $this->redirectToRoute('solicitud_show', array('id' => $solicitud->getId()));
        }

        return $this->render('solicitud/financiamiento.html.twig', array(
            'solicitud' => $solicitud,
            'id'=>$solicitud->getId(),
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Notificación solicitud
     *
     * @Route("/{id}/notificacion", name="solicitud_notificacion")
     */
    public function noticeAction(Request $request, Solicitud $solicitud)
    {

        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $academico = $solicitud->getAcademico();

        $solicitud->setNotificada(true);
        $em->persist($solicitud);
        $em->flush();

        // Obtiene correo y msg de la forma de contacto
        $mailer = $this->get('mailer');

        $message = \Swift_Message::newInstance()
            ->setSubject('Solicitud '.$solicitud->getId())
            ->setFrom('webmaster@matmor.unam.mx')
//            ->setTo(array($user->getEmail() ))
            ->setTo('gerardo@matmor.unam.mx')
//            ->setBcc(array('webmaster@matmor.unam.mx','vorozco@matmor.unam.mx'))
            ->setBody($this->renderView('solicitud/notificacion.txt.twig', array('entity' => $solicitud)))
        ;
        $mailer->send($message);

//        return $this->redirectToRoute('academico_show', array('slug'=>$academico->getSlug()));
        return $this->redirectToRoute('academico_show', array('slug' => $academico->getSlug()));

    }

    /**
     * Debería ser solo método no controlador!!!
     *
     * Dictamen de la solicitud
     *
     * @Route("/{id}/dictamen-email", name="solicitud_dictamen-email")
     */
    public function dictamenEmailAction(Request $request, Solicitud $solicitud)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        if($solicitud->getDictamen() == false) {
            return false;
        }

        $solicitud->setDictamen(true);
        $em->persist($solicitud);
        $em->flush();

        return true;
        // return $this->redirectToRoute('academico_show', array('slug' => $this->getUser()->getAcademico()->getSlug()));

    }

    /**
     * Deletes a solicitud entity.
     *
     * @Route("/{id}", name="solicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Solicitud $solicitud)
    {
        $form = $this->createDeleteForm($solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($solicitud);
            $em->flush();
        }

        return $this->redirectToRoute('solicitud_index');
    }

    /**
     * Creates a form to delete a solicitud entity.
     *
     * @param Solicitud $solicitud The solicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Solicitud $solicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitud_delete', array('id' => $solicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
