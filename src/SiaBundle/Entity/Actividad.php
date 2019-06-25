<?php

namespace SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table(name="actividad")
 * @ORM\Entity(repositoryClass="SiaBundle\Repository\ActividadRepository")
 */
class Actividad
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
     * @var solicitud
     * @ORM\ManyToOne(targetEntity="Solicitud", inversedBy="actividades")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=20, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="anfitrion", type="string", length=255, nullable=true)
     */
    private $anfitrion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEvento", type="string", length=255, nullable=true)
     */
    private $nombreEvento;

    /**
     * @var string
     *
     * @ORM\Column(name="tituloTrabajo", type="string", length=255, nullable=true)
     */
    private $tituloTrabajo;

    /**
     * @var bool
     *
     * @ORM\Column(name="nacional", type="boolean", nullable=true)
     */
    private $nacional;

    /**
     * @var string
     *
     * @ORM\Column(name="plenaria", type="boolean", nullable=true)
     */
    private $plenaria;

    /**
     * @var string
     *
     * @ORM\Column(name="invitacion", type="boolean", nullable=true)
     */
    private $invitacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="sinodalGrado", type="string", length=255, nullable=true)
     */
    private $sinodalGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="sinodalAlumno", type="string", length=255, nullable=true)
     */
    private $sinodalAlumno;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="array", length=255, nullable=true)
     */
    private $motivo;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion", type="string", length=255, nullable=true)
     */
    private $institucion;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=255, nullable=true)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=255, nullable=true)
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaActividad", type="date", nullable=true)
     */
    private $fechaActividad;

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
     * @return Actividad
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
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * Set anfitrion
     *
     * @param string $anfitrion
     * @return Actividad
     */
    public function setAnfitrion($anfitrion)
    {
        $this->anfitrion = $anfitrion;

        return $this;
    }

    /**
     * Get anfitrion
     *
     * @return string 
     */
    public function getAnfitrion()
    {
        return $this->anfitrion;
    }

    /**
     * Set nombreEvento
     *
     * @param string $nombreEvento
     * @return Actividad
     */
    public function setNombreEvento($nombreEvento)
    {
        $this->nombreEvento = $nombreEvento;

        return $this;
    }

    /**
     * Get nombreEvento
     *
     * @return string 
     */
    public function getNombreEvento()
    {
        return $this->nombreEvento;
    }

    /**
     * Set tituloTrabajo
     *
     * @param string $tituloTrabajo
     * @return Actividad
     */
    public function setTituloTrabajo($tituloTrabajo)
    {
        $this->tituloTrabajo = $tituloTrabajo;

        return $this;
    }

    /**
     * Get tituloTrabajo
     *
     * @return string 
     */
    public function getTituloTrabajo()
    {
        return $this->tituloTrabajo;
    }

    /**
     * Set nacional
     *
     * @param boolean $nacional
     * @return Actividad
     */
    public function setNacional($nacional)
    {
        $this->nacional = $nacional;

        return $this;
    }

    /**
     * Get nacional
     *
     * @return boolean 
     */
    public function getNacional()
    {
        return $this->nacional;
    }

    /**
     * @return string
     */
    public function getPlenaria()
    {
        return $this->plenaria;
    }

    /**
     * @param string $plenaria
     */
    public function setPlenaria($plenaria)
    {
        $this->plenaria = $plenaria;
    }

    /**
     * @return string
     */
    public function getInvitacion()
    {
        return $this->invitacion;
    }

    /**
     * @param string $invitacion
     */
    public function setInvitacion($invitacion)
    {
        $this->invitacion = $invitacion;
    }

    /**
     * Set sinodalGrado
     *
     * @param string $sinodalGrado
     * @return Actividad
     */
    public function setSinodalGrado($sinodalGrado)
    {
        $this->sinodalGrado = $sinodalGrado;

        return $this;
    }

    /**
     * Get sinodalGrado
     *
     * @return string 
     */
    public function getSinodalGrado()
    {
        return $this->sinodalGrado;
    }

    /**
     * Set sinodalAlumno
     *
     * @param string $sinodalAlumno
     * @return Actividad
     */
    public function setSinodalAlumno($sinodalAlumno)
    {
        $this->sinodalAlumno = $sinodalAlumno;

        return $this;
    }

    /**
     * Get sinodalAlumno
     *
     * @return string 
     */
    public function getSinodalAlumno()
    {
        return $this->sinodalAlumno;
    }

    /**
     * Set solicitud
     *
     * @param \SiaBundle\Entity\Solicitud $solicitud
     * @return Actividad
     */
    public function setSolicitud(\SiaBundle\Entity\Solicitud $solicitud = null)
    {
        $this->solicitud = $solicitud;
        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \SiaBundle\Entity\Solicitud 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param string $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    /**
     * @return string
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * @param string $institucion
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
    }

    /**
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param string $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return \DateTime
     */
    public function getFechaActividad()
    {
        return $this->fechaActividad;
    }

    /**
     * @param \DateTime $fechaActividad
     */
    public function setFechaActividad($fechaActividad)
    {
        $this->fechaActividad = $fechaActividad;
    }


}
