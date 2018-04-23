<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Academico
 *
 * @ORM\Table(name="academico")
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\AcademicoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Academico
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
     * @var array $solicitudes
     *
     * @ORM\OneToMany(targetEntity="SiaBundle\Entity\Solicitud", mappedBy="academico")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=120)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=120)
     */
    private $apellido;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $nacimiento;

    /**
     * @ORM\Column(type="string", length=13)
     * @Assert\NotBlank()
     */
    protected $rfc;

    /**
     *
     * @ORM\OneToOne(targetEntity="SiaBundle\Entity\User", inversedBy="academico")
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @Gedmo\Slug(fields={"apellido", "nombre"}, updatable=false)
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
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
     * Set nombre
     *
     * @param string $nombre
     * @return Academico
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Academico
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @return mixed
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    /**
     * @param mixed $nacimiento
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;
    }

    /**
     * @return mixed
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * @param mixed $rfc
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;
    }

    /**
     * Set user
     *
     * @param \SiaBundle\Entity\User $user
     * @return Academico
     */
    public function setUser(\SiaBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SiaBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->nombre;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();

    }



    /**
     * Set id
     *
     * @param integer $id
     * @return Academico
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Add solicitudes
     *
     * @param \SiaBundle\Entity\Solicitud $solicitudes
     * @return Academico
     */
    public function addSolicitude(\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;

        return $this;
    }

    /**
     * Remove solicitudes
     *
     * @param \SiaBundle\Entity\Solicitud $solicitudes
     */
    public function removeSolicitude(\SiaBundle\Entity\Solicitud $solicitudes)
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
     * Set slug
     *
     * @param string $slug
     * @return Academico
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
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


    /**
     * @return boolean
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
