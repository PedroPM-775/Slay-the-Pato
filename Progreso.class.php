<?php
//@ Proyecto por Pedro Pina Menéndez

class Progreso
{

    private $id;
    //
    private $desbloqueo1;
    private $desbloqueo2;
    private $desbloqueo3;
    //
    private $desbloqueo4;
    private $desbloqueo5;
    private $desbloqueo6;
    private $desbloqueo7;
    private $desbloqueo8;




    public function getid()
    {
        return $this->id;
    }
    public function getdesbloqueo($indice)
    {
        switch ($indice) {
            case 1:
                return $this->desbloqueo1;
                break;
            case 2:
                return $this->desbloqueo2;
                break;
            case 3:
                return $this->desbloqueo3;
                break;
            case 4:
                return $this->desbloqueo4;
                break;
            case 5:
                return $this->desbloqueo5;
                break;
            case 6:
                return $this->desbloqueo6;
                break;
            case 7:
                return $this->desbloqueo7;
                break;
            case 8:
                return $this->desbloqueo8;
                break;
        }
    }


    //@ Setters

    public function setid($id)
    {
        $this->id = $id;
    }
    public function setdesbloqueo($indice, $valor)
    {
        switch ($indice) {
            case 1:
                $this->desbloqueo1 = $valor;
                break;
            case 2:
                $this->desbloqueo2 = $valor;
                break;
            case 3:
                $this->desbloqueo3 = $valor;
                break;
            case 4:
                $this->desbloqueo4 = $valor;
                break;
            case 5:
                $this->desbloqueo5 = $valor;
                break;
            case 6:
                $this->desbloqueo6 = $valor;
                break;
            case 7:
                $this->desbloqueo7 = $valor;
                break;
            case 8:
                $this->desbloqueo8 = $valor;
                break;
        }
    }

    //@ Metodos de verdad
    public function __construct($id, $uno, $dos, $tres, $cuatro, $cinco, $seis, $siete, $ocho)
    {
        $this->setid($id);
        $this->setdesbloqueo(1, $uno);
        $this->setdesbloqueo(2, $dos);
        $this->setdesbloqueo(3, $tres);
        $this->setdesbloqueo(4, $cuatro);
        $this->setdesbloqueo(5, $cinco);
        $this->setdesbloqueo(6, $seis);
        $this->setdesbloqueo(7, $siete);
        $this->setdesbloqueo(8, $ocho);
    }

    public function cuentanueva($id)
    {
        $this->setid($id);
        $this->setdesbloqueo(1, 'y');
        $this->setdesbloqueo(2, 'n');
        $this->setdesbloqueo(3, 'n');
        $this->setdesbloqueo(4, 'y');
        $this->setdesbloqueo(5, 'n');
        $this->setdesbloqueo(6, 'n');
        $this->setdesbloqueo(7, 'n');
        $this->setdesbloqueo(8, 'n');
    }
}
