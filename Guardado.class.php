<?php
//@ Proyecto por Pedro Pina Menéndez

//@ Esta clase es una clase creada para poder almacenar y gestionar el historial de partidas del juego
class Guardado
{

    //@ Los atributos de la clase son los elementos que se guardan de cada partida en el historial
    //@ El personaje del jugador, el enemigo al que se enfrentó, el resultado de la partida, el id y el nombre de usuario del jugador
    private $personaje;
    private $enemigo;
    private $resultado;
    private $id;
    private $usuario;



    //@ Getters
    public function getpersonaje()
    {
        return $this->personaje;
    }
    public function getenemigo()
    {
        return $this->enemigo;
    }
    public function getresultado()
    {
        return $this->resultado;
    }
    public function getid()
    {
        return $this->id;
    }
    public function getusuario()
    {
        return $this->usuario;
    }


    //@ Setters
    public function setpersonaje($personaje)
    {
        $this->personaje = $personaje;
    }
    public function setenemigo($enemigo)
    {
        $this->enemigo = $enemigo;
    }
    public function setresultado($resultado)
    {
        $this->resultado = $resultado;
    }
    public function setid($id)
    {
        $this->id = $id;
    }
    public function setusuario($usuario)
    {
        $this->usuario = $usuario;
    }


    //@ Metodos de verdad
    public function __construct($personaje, $enemigo, $resultado, $id, $usuario)
    {
        $this->setpersonaje($personaje);
        $this->setenemigo($enemigo);
        $this->setresultado($resultado);
        $this->setid($id);
        $this->setusuario($usuario);
    }
}
