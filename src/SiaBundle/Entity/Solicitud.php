<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud")
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\SolicitudRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Solicitud
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
     * @var academico
     * @ORM\ManyToOne(targetEntity="Academico", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="academico_id", referencedColumnName="id")
     */
    private $academico;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="sia_cartaInvitacion", fileNameProperty="cartaInvitacionName")
     *
     * @Assert\File(
     *     maxSize = "2M",
     * uploadFormSizeErrorMessage = "El archivo debe ser menor a 2 MB",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     *
     * @var File
     */
    public $cartaInvitacionFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cartaInvitacionName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="sia_plan", fileNameProperty="planName")
     *
     * @Assert\File(
     *     maxSize = "2M",
     * uploadFormSizeErrorMessage = "El archivo debe ser menor a 2 MB",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     *
     * @var File
     */
    public $planFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $planName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="sia_cartaSolicitud", fileNameProperty="cartaSolicitudName")
     *
     * @Assert\File(
     *     maxSize = "2M",
     * uploadFormSizeErrorMessage = "El archivo debe ser menor a 2 MB",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     *
     * @var File
     */
    public $cartaSolicitudFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cartaSolicitudName;

    /**
     * @var bool
     *
     * @ORM\Column(name="ambito", type="boolean", nullable=true)
     */
    private $ambito;

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
     * @var array $actividades
     *
     *
     * @ORM\OneToMany(targetEntity="SiaBundle\Entity\Actividad", mappedBy="solicitud", cascade={"persist"})
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $actividades;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $financiamiento;


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
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
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
     * Set tipo
     *
     * @param string $tipo
     * @return Solicitud
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }


    /**
     * Set cartaInvitacionFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $recommendation
     */
    public function setCartaInvitacionFile(File $cartaInvitacion = null)
    {
        $this->cartaInvitacionFile = $cartaInvitacion;
        if ($cartaInvitacion) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * Get cartaInvitacionFile
     *
     * @return File
     */
    public function getCartaInvitacionFile()
    {
        return $this->cartaInvitacionFile;
    }

    /**
     * @return mixed
     */
    public function getCartaInvitacionName()
    {
        return $this->cartaInvitacionName;
    }

    /**
     * @param mixed $cartaInvitacionName
     */
    public function setCartaInvitacionName($cartaInvitacionName)
    {
        $this->cartaInvitacionName = $cartaInvitacionName;
    }


    /**
     * Set cartaSolicitudFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $recommendation
     */
    public function setCartaSolicitudFile(File $cartaSolicitud = null)
    {
        $this->cartaSolicitudFile = $cartaSolicitud;
        if ($cartaSolicitud) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTime('now');
        }
    }

    /**
     * Get cartaSolicitudFile
     *
     * @return File
     */
    public function getCartaSolicitudFile()
    {
        return $this->cartaSolicitudFile;
    }

    /**
     * @return mixed
     */
    public function getCartaSolicitudName()
    {
        return $this->cartaSolicitudName;
    }

    /**
     * @param mixed $cartaSolicitudName
     */
    public function setCartaSolicitudName($cartaSolicitudName)
    {
        $this->cartaSolicitudName = $cartaSolicitudName;
    }


    /**
     * Set planFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $recommendation
     */
    public function setPlanFile(File $plan = null)
    {
        $this->planFile = $plan;
        if ($plan) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTime('now');
        }
    }



    /**
     * Get planFile
     *
     * @return File
     */
    public function getPlanFile()
    {
        return $this->planFile;
    }

    /**
     * @return mixed
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     * @param mixed $planName
     */
    public function setPlanName($planName)
    {
        $this->planName = $planName;
    }

    /**
     * @return boolean
     */
    public function isAmbito()
    {
        return $this->ambito;
    }

    /**
     * @param boolean $ambito
     */
    public function setAmbito($ambito)
    {
        $this->ambito = $ambito;
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


    public function __toString()
    {
        return (string) $this->id;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->financiamiento = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add actividades
     *
     * @param \SiaBundle\Entity\Actividad $actividades
     * @return Solicitud
     */
    public function addActividade(\SiaBundle\Entity\Actividad $actividades)
    {
        $this->actividades[] = $actividades;
        $actividades->setSolicitud($this);

        return $this;
    }

    /**
     * Remove actividades
     *
     * @param \SiaBundle\Entity\Actividad $actividades
     */
    public function removeActividade(\SiaBundle\Entity\Actividad $actividades)
    {
        $this->actividades->removeElement($actividades);
    }

    /**
     * Get actividades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActividades()
    {
        return $this->actividades;
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
    //public function setFinanciamiento($financiamiento)
    //{
      //  $this->financiamiento = $financiamiento;
    //}

    public function setFinanciamiento(array $financiamiento)
    {
        if (!empty($financiamiento) && $financiamiento === $this->financiamiento) {
            reset($financiamiento);
            $financiamiento[key($financiamiento)] = clone current($financiamiento);
        }
        $this->financiamiento = $financiamiento;
    }

    // -----------------------------------------------------------------------------------------------------------------
    /**
     * @return suma financiamiento CCM
     */
    public function getTotalAsignación()
    {
        $total_asignacion = 0;

        foreach ($this->financiamiento as $finccm)
            $total_asignacion += $finccm->getCcm();

        return $total_asignacion;
    }

    /**
     * @return Total de días solicitados
     */
    public function getDias()
    {

//    $datetime1 = new DateTime('2009-10-11');
//    $datetime2 = new DateTime('2009-10-13');
//    $interval = $datetime1->diff($datetime2);
//    echo $interval->format('%R%a days');

        $dias = $this->fin->diff($this->inicio);

        return $dias->format('%d') + 1;
    }

    /**
     * Set academico
     *
     * @param \SiaBundle\Entity\academico $academico
     */
    public function setAcademico($academico)
    {
        $this->academico = $academico;
    }

    /**
     * Get academico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcademico()
    {
        return $this->academico;
    }

}
