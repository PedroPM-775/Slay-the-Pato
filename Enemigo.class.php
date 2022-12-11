<?php

class enemigo
{
    private $nombre;
    private $vida;
    private $ataque;
    private $defensa;
    private $vidagris;


    //@ Getters
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getVida()
    {
        return $this->vida;
    }
    public function getAtaque()
    {
        return $this->ataque;
    }
    public function getDefensa()
    {
        return $this->defensa;
    }
    public function getVidaGris()
    {
        return $this->vidagris;
    }


    //@ Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setVida($vida)
    {
        $this->vida = $vida;
    }
    public function setAtaque($ataque)
    {
        $this->ataque = $ataque;
    }
    public function setDefensa($defensa)
    {
        $this->defensa = $defensa;
    }
    public function setVidaGris($vidagris)
    {
        $this->vidagris = $vidagris;
    }


    //@ Metodos de verdad
    public function __construct($nombre, $vida, $ataque, $defensa, $vidagris)
    {
        $this->setNombre($nombre);
        $this->setVida($vida);
        $this->setAtaque($ataque);
        $this->setDefensa($defensa);
        $this->setVidaGris($vidagris);
    }
}
