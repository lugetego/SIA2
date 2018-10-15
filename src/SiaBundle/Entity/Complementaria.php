<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Complementaria
 *
 * @ORM\Table(name="complementaria")
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\ComplementariaRepository")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Complementaria
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
     * One Complementaria has One Solicitud.
     * @ORM\OneToOne(targetEntity="Solicitud", inversedBy="complementaria")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;

    /**
     * @return mixed
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * @param mixed $solicitud
     */
    public function setSolicitud($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * @var sesion
     * @ORM\ManyToOne(targetEntity="Sesion", inversedBy="complementarias")
     * @ORM\JoinColumn(name="sesion_id", referencedColumnName="id", nullable=true)
     *
     */
    private $sesion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $financiamiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="dictamen", type="boolean", nullable=true)
     */
    private $dictamen;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->financiamiento = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param \DateTime $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param \DateTime $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;


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
     * Get sesion
     *
     * @return \Doctrine\Common\Collections\Collection
     *
     */
    public function getSesion()
    {
        return $this->sesion;
    }

    /**
     * Set sesion
     *
     * @param string $sesion
     */
    public function setSesion($sesion)
    {
        $this->sesion = $sesion;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Complementaria
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Get financiamiento
     *
     * @return array
     */
    public function getFinanciamiento()
    {
        return $this->financiamiento;
    }

    /**
     * Set financiamiento
     *
     * @param array
     */
    public function setFinanciamiento(array $financiamiento)
    {
        if (!empty($financiamiento) && $financiamiento === $this->financiamiento) {
            reset($financiamiento);
            $financiamiento[key($financiamiento)] = clone current($financiamiento);
        }
        $this->financiamiento = $financiamiento;
    }

    public function __toString()
    {
        return (string) $this->id;

    }

    /**
     * @return boolean
     */
    public function isDictamen()
    {
        return $this->dictamen;
    }

    /**
     * @param boolean $dictamen
     */
    public function setDictamen($dictamen)
    {
        $this->dictamen = $dictamen;
    }

}

