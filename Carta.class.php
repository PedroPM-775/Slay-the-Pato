<?php

class Carta
{

    private $nombre;
    private $tipo;
    private $valor;


    //@ Getters
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getValor()
    {
        return $this->valor;
    }


    //@ Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }



    //@ Metodos de verdad
    public function __construct($nombre, $tipo, $valor)
    {
        $this->setNombre($nombre);
        $this->setTipo($tipo);
        $this->setValor($valor);
    }
}
