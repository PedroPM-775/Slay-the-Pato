<?php

//@ Proyecto por Pedro Pina Menéndez

//@ Clase hecha para guardar los datos de los personajes y las manos, asi como otros parametros relevantes en la partida
class Partida
{
    private $heroe;
    private $villano;
    private $manoJugador;
    private $manoTurnoAnterior;
    private $ronda;
    private $ia;


    //@ Getters
    public function getheroe()
    {
        return $this->heroe;
    }
    public function getvillano()
    {
        return $this->villano;
    }
    public function getmanojugador()
    {
        return $this->manoJugador;
    }
    public function getmanoturnoanterior()
    {
        return $this->manoTurnoAnterior;
    }
    public function getronda()
    {
        return $this->ronda;
    }
    public function getia()
    {
        return $this->ia;
    }


    //@ Setters
    public function setheroe($heroe)
    {
        $this->heroe = $heroe;
    }
    public function setvillano($villano)
    {
        $this->villano = $villano;
    }
    public function setbaraja($baraja)
    {
        $this->baraja = $baraja;
    }
    public function setmanojugador($manoJugador)
    {
        $this->manoJugador = $manoJugador;
    }
    public function setmanoturnoanterior($manoTurnoAnterior)
    {
        $this->manoTurnoAnterior = $manoTurnoAnterior;
    }
    public function setia($ia)
    {
        $this->ia = $ia;
    }


    //@ Metodos de verdad
    public function __construct($heroe, $villano, $baraja)
    {
        $this->setheroe($heroe);
        $this->setvillano($villano);
        $this->setbaraja($baraja);
        $this->ronda = 0;
        $this->ia = 1;
    }

    public function empezarpartida()
    {
        $this->ronda = 1;
    }
}
