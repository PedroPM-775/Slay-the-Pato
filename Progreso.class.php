<?php
//@ Proyecto por Pedro Pina Menéndez
//@ Esta clase fue creada para gestionar los elementos desbloqueados por el jugador segun va jugando.
class Progreso
{
    //@ El atributo ID es el usuario.
    private $id;
    //@ Los atributos desbloqueo 1,2 y 3 sirven para gestionar los niveles de dificultad desbloqueados por el jugador
    //@ Siendo el parametro 1 el nivel facil, el parametro 2 el nivel medio, y el parametro 3 el nivel dificil
    private $desbloqueo1;
    private $desbloqueo2;
    private $desbloqueo3;
    //@ Los demas atributos sirven para gestionar que imagenes de perfil ha desbloqueado el jugador.
    private $desbloqueo4;
    private $desbloqueo5;
    private $desbloqueo6;
    private $desbloqueo7;
    private $desbloqueo8;




    public function getid()
    {
        return $this->id;
    }

    public function getdes1()
    {
        return $this->desbloqueo1;
    }
    public function getdes2()
    {
        return $this->desbloqueo2;
    }
    public function getdes3()
    {
        return $this->desbloqueo3;
    }
    public function getdes4()
    {
        return $this->desbloqueo4;
    }
    public function getdes5()
    {
        return $this->desbloqueo5;
    }
    public function getdes6()
    {
        return $this->desbloqueo6;
    }
    public function getdes7()
    {
        return $this->desbloqueo7;
    }
    public function getdes8()
    {
        return $this->desbloqueo8;
    }



    public function desbloqueado($indice)
    {
        switch ($indice) {
            case 1:
                if ($this->desbloqueo1 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 2:
                if ($this->desbloqueo2 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 3:
                if ($this->desbloqueo3 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 4:
                if ($this->desbloqueo4 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 5:
                if ($this->desbloqueo5 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 6:
                if ($this->desbloqueo6 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 7:
                if ($this->desbloqueo7 == 1)
                    return true;
                else {
                    return false;
                }
                break;
            case 8:
                if ($this->desbloqueo8 == 1)
                    return true;
                else {
                    return false;
                }
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

    //@ Esta funcion sirve para cambiar el valor de algun elemento a estar desbloqueado
    public function desbloquear($indice)
    {
        switch ($indice) {
            case 2:
                $this->desbloqueo2 = 1;
                break;
            case 3:
                $this->desbloqueo3 = 1;
                break;
            case 5:
                $this->desbloqueo5 = 1;
                break;
            case 6:
                $this->desbloqueo6 = 1;
                break;
            case 7:
                $this->desbloqueo7 = 1;
                break;
            case 8:
                $this->desbloqueo8 = 1;
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
    //@ Esta funcion sirve para desbloquear todo el contenido, solo se ejecuta al crear una cuenta con permisos de administrador en usuarios.php

    public function cuentaadmin()
    {
        $this->setdesbloqueo(1, 1);
        $this->setdesbloqueo(2, 1);
        $this->setdesbloqueo(3, 1);
        $this->setdesbloqueo(4, 1);
        $this->setdesbloqueo(5, 1);
        $this->setdesbloqueo(6, 1);
        $this->setdesbloqueo(7, 1);
        $this->setdesbloqueo(8, 1);
    }
    //@ Esta funcion sirve para comprobar si está todo el contenido desbloqueado
    public function tododesbloqueado()
    {
        if (
            $this->desbloqueado(1) && $this->desbloqueado(2) && $this->desbloqueado(3) &&
            $this->desbloqueado(4) && $this->desbloqueado(5) && $this->desbloqueado(6) &&
            $this->desbloqueado(7) && $this->desbloqueado(8)
        ) {
            return true;
        }
    }

    //@ Esta funcion sirve para ver cual es el siguiente contenido a desbloquear, y devuelve el ID del contenido
    public function desbloquearsiguiente()
    {
        for ($i = 1; $i < 9; $i++) {
            if (!$this->desbloqueado($i)) {
                return $i;
            }
        }
    }
}
