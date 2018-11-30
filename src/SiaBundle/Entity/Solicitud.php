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
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var sesion
     * @ORM\ManyToOne(targetEntity="Sesion", inversedBy="solicitudes")
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
     * @var array $actividades
     *
     *
     * @ORM\OneToMany(targetEntity="SiaBundle\Entity\Actividad", mappedBy="solicitud", cascade={"remove"})
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
     * @var bool
     *
     * @ORM\Column(name="enviada", type="boolean", nullable=true)
     */
    private $enviada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEnviada", type="date", nullable=true)
     */
    private $fechaEnviada;

    /**
     * @return mixed
     */
    public function getComplementaria()
    {
        return $this->complementaria;
    }

    /**
     * @param mixed $complementaria
     */
    public function setComplementaria($complementaria)
    {
        $this->complementaria = $complementaria;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="dictamen", type="boolean", nullable=true)
     */
    private $dictamen;

    /**
     * @var bool
     *
     * @ORM\Column(name="notificada", type="boolean", nullable=true)
     */
    private $notificada;

    /**
     * @var bool
     *
     * @ORM\Column(name="erogado_asignacion", type="boolean", nullable=true)
     */
    private $erogadoAsignacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="cancelada", type="boolean", nullable=true)
     */
    private $cancelada;

    /**
     * One Solicitud has One Complementaria.
     * @ORM\OneToOne(targetEntity="Complementaria", mappedBy="solicitud")
     */
    private $complementaria;

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
     * @return Solicitud
     *
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
     * @return Solicitud
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
    public function addActividades(\SiaBundle\Entity\Actividad $actividades)
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
    public function removeActividades(\SiaBundle\Entity\Actividad $actividades)
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
    public function getTotalAsignacion()
    {
        $total_asignacion = 0;

        foreach ($this->financiamiento as $finccm)
            $total_asignacion += $finccm->getCcm();

        return $total_asignacion;
    }

    /**
     * @return boolean financiamiento CCM
     */
    public function hasFinanciamento()
    {
        foreach ($this->financiamiento as $fin) {
            if($fin->getCcm() || $fin->getPapiit() || $fin->getConacyt() || $fin->getOtro()) {
                return true;
            }
        }

        return false;
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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Solicitud
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get sesion
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return boolean
     */
    public function isEnviada()
    {
        return $this->enviada;
    }

    /**
     * @param boolean $enviada
     */
    public function setEnviada($enviada)
    {
        $this->enviada = $enviada;
    }

    /**
     * @return \DateTime
     */
    public function getFechaEnviada()
    {
        return $this->fechaEnviada;
    }

    /**
     * @param \DateTime $fechaEnviada
     */
    public function setFechaEnviada($fechaEnviada)
    {
        $this->fechaEnviada = $fechaEnviada;
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

    /**
     * @return boolean
     */
    public function isNotificada()
    {
        return $this->notificada;
    }

    /**
     * @param boolean $notificada
     */
    public function setNotificada($notificada)
    {
        $this->notificada = $notificada;
    }

    /**
     * @return boolean
     */
    public function isErogadoAsignacion()
    {
        return $this->erogadoAsignacion;
    }

    /**
     * @param boolean $erogadoAsignacion
     */
    public function setErogadoAsignacion($erogadoAsignacion)
    {
        $this->erogadoAsignacion = $erogadoAsignacion;
    }

    /**
     * @return boolean
     */
    public function isCancelada()
    {
        return $this->cancelada;
    }

    /**
     * @param boolean $cancelada
     */
    public function setCancelada($cancelada)
    {
        $this->cancelada = $cancelada;
    }

    /**
     * @return Total de días solicitados
     */
    public function getDias()
    {
        $dias = $this->fechaFin->diff($this->fechaInicio);

        return $dias->format('%d') + 1;
    }

    /**
     * @return Total de días solicitados hasta esta solicitud
     */
    public function totalDiasLicencia()
    {
        $diasLicencia = 0;

        $year = $this->getFechaInicio()->format('Y');

        // Si el tipo de solicitud es Licencia
        // Y ha sido enviada (puede no tener dictamen)
        // Suma solo licencias del año de la salida
        // Y suma solo hasta esta solicitud


        foreach ($this->getAcademico()->getSolicitudes() as $solicitud) {
            if($solicitud->getTipo() == 'Licencia'and $solicitud->isEnviada() and $year == $solicitud->getFechaInicio()->format('Y') && $solicitud->getFechaInicio() <= $this->getFechaInicio())
                $diasLicencia += $solicitud->getDias();
        }

        return $diasLicencia;
    }

    /**
     * @return Total de días solicitados hasta esta solicitud
     */
    public function totalDiasComision()
    {
        $diasComision = 0;

        $year = $this->getFechaInicio()->format('Y');

        foreach ($this->getAcademico()->getSolicitudes() as $solicitud) {
            if($solicitud->getTipo() == 'Licencia'and $solicitud->isEnviada() and $year == $solicitud->getFechaInicio()->format('Y') && $solicitud->getFechaInicio() <= $this->getFechaInicio())
                $diasComision += $solicitud->getDias();
        }

        return $diasComision;
    }

    /**
     * @return Total de días auscente hasta esta solicitud
     */
    public function totalDiasAusente()
    {
        $diasAusente = 0;

        $year = $this->getFechaInicio()->format('Y');

        foreach ($this->getAcademico()->getSolicitudes() as $solicitud) {
            if($solicitud->getTipo() != 'Visitante' and $solicitud->isEnviada() and $year == $solicitud->getFechaInicio()->format('Y') && $solicitud->getFechaInicio() <= $this->getFechaInicio())
                $diasAusente += $solicitud->getDias();
        }

        return $diasAusente;
    }

    /**
     * Para las recomendaciones
     * @return Total Erogado
     */
    public function totalErogado()
    {

        $totalErogado = 0;
        $year = $this->getFechaInicio()->format('Y');

        foreach ($this->getAcademico()->getSolicitudes() as $solicitud) {
            if($solicitud->getTipo() != 'Visitante' and $solicitud->isEnviada() and $year == $solicitud->getFechaInicio()->format('Y') && $solicitud->getFechaInicio() <= $this->getFechaInicio())
                $totalErogado += $solicitud->getTotalAsignacion();
        }

        return $totalErogado;
    }
}
