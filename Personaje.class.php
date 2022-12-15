<?php

//@ Proyecto por Pedro Pina Menéndez


//@ Clase creada para manejar los datos de los personajes, tanto heroes como villanos
class Personaje
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
    public function __construct($nombre)
    {
        switch ($nombre) {
            case 'PatoEspada':
                $this->setNombre('PatoEspada');
                $this->setVida(60);
                $this->setAtaque(2);
                $this->setDefensa(2);
                $this->setVidaGris(0);
                break;
            case 'PatoEscudo':
                $this->setNombre('PatoEscudo');
                $this->setVida(90);
                $this->setAtaque(0);
                $this->setDefensa(4);
                $this->setVidaGris(0);
                break;
            case 'PatoRifle':
                $this->setNombre('PatoRifle');
                $this->setVida(40);
                $this->setAtaque(5);
                $this->setDefensa(0);
                $this->setVidaGris(0);
                break;
            case 'vader':
                $this->setNombre('vader');
                $this->setVida(100);
                $this->setAtaque(3);
                $this->setDefensa(3);
                $this->setVidaGris(0);
                break;
            case 'akuma':
                $this->setNombre('akuma');
                $this->setVida(30);
                $this->setAtaque(9);
                $this->setDefensa(1);
                $this->setVidaGris(0);
                break;
            case 'firulais':
                $this->setNombre('firulais');
                $this->setVida(20);
                $this->setAtaque(1);
                $this->setDefensa(1);
                $this->setVidaGris(0);
                break;
        }
    }


    //@ Comrpueba si el personaje ha recibido daño y le quita la vida correspondiente
    public function hacerdanho($daño)
    {
        $danorecibido = intval($this->getVidaGris()) - intval($daño);
        if (0 < $danorecibido) {
        } else {
            $vidanueva = intval($this->getVida()) + $danorecibido;
            $this->setVida($vidanueva);
        }
    }


    public function curar($davidaño)
    {
        $this->setVida($this->getVida() + $davidaño);
    }

    //@ Metodo al cual se le pasa un parametro entre 1 y 3, y de ahi se saca la accion que hara el villano
    public function accionvillano($accion)
    {
        $intaccion = intval($accion);
        switch ($intaccion) {
            case 1:
                $vidagris = 15 + intval($this->getDefensa());
                $this->setVidaGris($vidagris);
                return false;
                break;
            case 2:
                $ataque = 20 + intval($this->getAtaque());
                return $ataque;
                break;
            case 3:
                $ataque = 10 + intval($this->getAtaque());
                $vidagris = 5 + intval($this->getDefensa());
                $this->setVidaGris($vidagris);
                return $ataque;
                break;
        }
    }
}
