<?php

namespace SiaBundle\Service;

use Doctrine\ORM\EntityManager;
use SiaBundle\Entity\Solicitud;

class Recomendacion
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return Total de días solicitados hasta esta solicitud
     */
    public function totalDiasLicencia(Solicitud $solicitud)
    {
        $diasLicencia = 0;

        $year = $solicitud->getFechaInicio()->format('Y');

        $solicitudes = $this->em->getRepository('SiaBundle:Solicitud')->findAllByYear($solicitud->getAcademico(), $year);

        // Si el tipo de solicitud es Licencia
        // Y ha sido enviada (puede no tener dictamen)
        // Suma solo licencias del año de la salida
        // Y suma solo hasta esta solicitud

        foreach ($solicitudes as $s) {
            if($s->getTipo() == 'Licencia' and $s->isEnviada() and $s->getFechaInicio() <= $solicitud->getFechaInicio())
                $diasLicencia += $s->getDias();
        }

        return $diasLicencia;
    }

    /**
     * @return Total de días solicitados hasta esta solicitud
     */
    public function totalDiasComision(Solicitud $solicitud)
    {
        $diasComision = 0;

        $year = $solicitud->getFechaInicio()->format('Y');
        $solicitudes = $this->em->getRepository('SiaBundle:Solicitud')->findAllByYear($solicitud->getAcademico(), $year);

        foreach ($solicitudes as $s) {
            if($s->getTipo() == 'Comision'and $s->isEnviada() and $s->getFechaInicio() <= $solicitud->getFechaInicio())
                $diasComision += $s->getDias();
        }

        return $diasComision;
    }

    /**
     * @return Total de días auscente hasta esta solicitud
     */
    public function totalDiasAusente(Solicitud $solicitud)
    {
        $diasAusente = 0;

        $year = $solicitud->getFechaInicio()->format('Y');
        $solicitudes = $this->em->getRepository('SiaBundle:Solicitud')->findAllByYear($solicitud->getAcademico(), $year);


        foreach ($solicitudes as $s) {
            if($s->getTipo() != 'Visitante' and $s->isEnviada() and $s->getFechaInicio() <= $solicitud->getFechaInicio())
                $diasAusente += $s->getDias();
        }

        return $diasAusente;
    }

    // Calcula el total erogado hasta una solicitud
    //
    public function totalErogado(Solicitud $solicitud)
    {
        // $solicitud = $this->em->getRepository('Solicitud')->findOneBy($id);

        $totalErogado = 0;
        $year = $solicitud->getFechaInicio()->format('Y');

        $solicitudes = $this->em->getRepository('SiaBundle:Solicitud')->findAllByYear($solicitud->getAcademico(), $year);

        foreach ($solicitudes as $s) {
            if($s->getTipo() != 'Visitante' and $s->isEnviada() && $s->getFechaInicio() <= $solicitud->getFechaInicio())
                $totalErogado += $s->getTotalAsignacion();
        }

        return $totalErogado;
    }
}
