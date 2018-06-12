<?php

namespace SiaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\SesionRepository")
 * @ORM\Table(name="sesion")
 * @ORM\HasLifecycleCallbacks
 */
class Sesion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $fecha;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    protected $name;

    /**
     * @var string $orden
     *
     * @ORM\Column(name="orden", type="text", nullable=true)
     */
    protected $orden;

    /**
     * @var string $varios
     *
     * @ORM\Column(name="varios", type="text", nullable=true)
     */
    protected $varios;

    /**
     * @var array $solicitudes
     *
     * @ORM\OneToMany(targetEntity="SiaBundle\Entity\Solicitud", mappedBy="sesion", cascade={"persist"})
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=50, unique=true )
     */
    private $slug;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updated
     */
    public function setUpdatedAt($updated)
    {
        $this->updatedAt = $updated;
    }

    /**
     * Get updated
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Sesiones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Sesiones
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add solicitudes
     *
     * @param \SiaBundle\Entity\Solicitud $solicitudes
     * @return Sesiones
     */
    public function addSolicitudes(\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;

        return $this;
    }

    /**
     * Remove solicitudes
     *
     * @param \SiaBundle\Entity\Solicitud $solicitudes
     */
    public function removeSolicitudes(\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes->removeElement($solicitudes);
    }

    /**
     * Get solicitudes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

        /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }




    public function __toString() {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param string $orden
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    /**
     * @return string
     */
    public function getVarios()
    {
        return $this->varios;
    }

    /**
     * @param string $varios
     */
    public function setVarios($varios)
    {
        $this->varios = $varios;
    }

}

