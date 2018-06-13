<?php

namespace SiaBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;



class Financiamiento {

    /**
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $nombre;

    /**
     * @Assert\NotBlank(groups={"solicitud"})
     * @Assert\Type(type="float", message="The value is not a valid.")
     */
    private $ccm;

    /**
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $papiit;

    /**
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $conacyt;

    /**
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $otro;

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return;
    }

    public function getCcm()
    {
        return $this->ccm;
    }

    public function setCcm($ccm)
    {
        $this->ccm = $ccm;
        return;
    }

    public function getPapiit()
    {
        return $this->papiit;
    }

    public function setPapiit($papiit)
    {
        $this->papiit = $papiit;
        return;
    }

    public function getConacyt()
    {
        return $this->conacyt;
    }

    public function setConacyt($conacyt)
    {
        $this->conacyt = $conacyt;
        return;
    }

    public function getOtro()
    {
        return $this->otro;
    }

    public function setOtro($otro)
    {
        $this->otro = $otro;
        return;
    }

    public function hasFinanciamiento()
    {
        if($this->getCcm() || $this->getConacyt() || $this->getPapiit() || $this->getOtro()) {
            return true;
        }

        return false;
    }
}