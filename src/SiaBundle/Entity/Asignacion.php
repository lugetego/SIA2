<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asignacion
 *
 * @ORM\Table(name="asignacion")
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\AsignacionRepository")
 */
class Asignacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo", type="string", length=5, unique=true)
     */
    private $periodo;

    /**
     * @var string
     *
     * @ORM\Column(name="asignacion", type="string", length=8)
     */
    private $asignacion;

    /**
     * @var string
     *
     * @ORM\Column(name="diasLicencia", type="string", length=4)
     */
    private $diasLicencia;

    /**
     * @var string
     *
     * @ORM\Column(name="diasComision", type="string", length=4)
     */
    private $diasComision;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     *
     * @return Asignacion
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set asignacion
     *
     * @param string $asignacion
     *
     * @return Asignacion
     */
    public function setAsignacion($asignacion)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return string
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }

    /**
     * Set diasLicencia
     *
     * @param string $diasLicencia
     *
     * @return Asignacion
     */
    public function setDiasLicencia($diasLicencia)
    {
        $this->diasLicencia = $diasLicencia;

        return $this;
    }

    /**
     * Get diasLicencia
     *
     * @return string
     */
    public function getDiasLicencia()
    {
        return $this->diasLicencia;
    }

    /**
     * Set diasComision
     *
     * @param string $diasComision
     *
     * @return Asignacion
     */
    public function setDiasComision($diasComision)
    {
        $this->diasComision = $diasComision;

        return $this;
    }

    /**
     * Get diasComision
     *
     * @return string
     */
    public function getDiasComision()
    {
        return $this->diasComision;
    }
}

