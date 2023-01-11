<?php

//@ Proyecto por Pedro Pina Menéndez


include "Usuario.class.php";
include "Personaje.class.php";
include "Carta.class.php";
include "Partida.class.php";
include "Guardado.class.php";
include "Progreso.class.php";
//@ Clase creada para interactuar con los archivos CSV
class DAO
{
    private $rutaUsuarios = "./CSV/usuarios.csv";
    private $rutaPartidas = "./CSV/partidas.csv";
    private $rutaProgresos = "./CSV/progreso.csv";
    private $rutaMazo1 = "./MAZOS/mazo.csv";
    private $rutaMazo2 = "./MAZOS/mazo2.csv";
    private $rutaMazo3 = "./MAZOS/mazo3.csv";

    public function __construct()
    {
    }

    //@ Este metodo devuelve un array de objetos Usuario, relleno con los datos del archivo /csv/usuarios.csv
    function devolverArrayUsuarios()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaUsuarios, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                $usuario = new Usuario($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4]);
                $arrayDatos[] = $usuario;
            }
        } else {
            echo "Error, no se puede acceder al archivo " . $this->rutaUsuarios . "<br>";
            return false;
        }
        fclose($fp);
        return $arrayDatos;
    }

    //@ Este metodo recibe como parametro un array de objetos de tipo Usuario y escribe su contenido en el archivo /csv/usuarios.csv
    function escribirArrayUsuarios($arrayObjetos)
    {
        $arrayEscribir = array();
        for ($i = 0; $i < count($arrayObjetos); $i++) {
            $objeto = $arrayObjetos[$i];
            $arrayIntermedio = array();
            array_push($arrayIntermedio, $objeto->getNombre());
            array_push($arrayIntermedio, $objeto->getContrasena());
            array_push($arrayIntermedio, $objeto->getCorreo());
            array_push($arrayIntermedio, $objeto->getuserName());
            array_push($arrayIntermedio, $objeto->getRol());
            $arrayEscribir[] = $arrayIntermedio;
        }

        if ($fp = fopen($this->rutaUsuarios, "w")) {
            foreach ($arrayEscribir as $filaDatos) {
                fputcsv($fp, $filaDatos);
            }
        } else {
            echo "Error, no se pudo abrir el archivo";
            return false;
        }
        fclose($fp);
        return true;
    }


    //@ Este metodo devuelve un array de objetos Guardado, relleno con los datos del archivo /csv/partidas.csv
    function devolverArrayGuardados()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaPartidas, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                $usuario = new Guardado($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4]);
                $arrayDatos[] = $usuario;
            }
        } else {
            echo "Error, no se puede acceder al archivo " . $this->rutaPartidas . "<br>";
            return false;
        }
        fclose($fp);
        return $arrayDatos;
    }

    //@ Este metodo recibe como parametro un array de objetos de tipo Guardado y escribe su contenido en el archivo /csv/partidas.csv
    function escribirArrayGuardados($arrayObjetos)
    {
        $arrayEscribir = array();
        for ($i = 0; $i < count($arrayObjetos); $i++) {
            $objeto = $arrayObjetos[$i];
            $arrayIntermedio = array();
            array_push($arrayIntermedio, $objeto->getpersonaje());
            array_push($arrayIntermedio, $objeto->getenemigo());
            array_push($arrayIntermedio, $objeto->getresultado());
            array_push($arrayIntermedio, $objeto->getid());
            array_push($arrayIntermedio, $objeto->getusuario());
            $arrayEscribir[] = $arrayIntermedio;
        }

        if ($fp = fopen($this->rutaPartidas, "w")) {
            foreach ($arrayEscribir as $filaDatos) {
                fputcsv($fp, $filaDatos);
            }
        } else {
            echo "Error, no se pudo abrir el archivo";
            return false;
        }
        fclose($fp);
        return true;
    }



    //@ Este metodo devuelve un array de objetos Progreso, relleno con los datos del archivo /csv/progreso.csv
    function devolverArrayProgresos()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaProgresos, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                $progreso = new Progreso(
                    $filaDatos[0],
                    $filaDatos[1],
                    $filaDatos[2],
                    $filaDatos[3],
                    $filaDatos[4],
                    $filaDatos[5],
                    $filaDatos[6],
                    $filaDatos[7],
                    $filaDatos[8]
                );
                $arrayDatos[] = $progreso;
            }
        } else {
            echo "Error, no se puede acceder al archivo " . $this->rutaProgresos . "<br>";
            return false;
        }
        fclose($fp);
        return $arrayDatos;
    }

    //@ Este metodo recibe como parametro un array de objetos de tipo Progreso y escribe su contenido en el archivo /csv/progreso.csv
    function escribirArrayProgresos($arrayObjetos)
    {
        $arrayEscribir = array();
        for ($i = 0; $i < count($arrayObjetos); $i++) {
            $objeto = $arrayObjetos[$i];
            $arrayIntermedio = array();
            array_push($arrayIntermedio, $objeto->getid());
            array_push($arrayIntermedio, $objeto->getdes1());
            array_push($arrayIntermedio, $objeto->getdes2());
            array_push($arrayIntermedio, $objeto->getdes3());
            array_push($arrayIntermedio, $objeto->getdes4());
            array_push($arrayIntermedio, $objeto->getdes5());
            array_push($arrayIntermedio, $objeto->getdes6());
            array_push($arrayIntermedio, $objeto->getdes7());
            array_push($arrayIntermedio, $objeto->getdes8());
            $arrayEscribir[] = $arrayIntermedio;
        }

        if ($fp = fopen($this->rutaProgresos, "w")) {
            foreach ($arrayEscribir as $filaDatos) {
                fputcsv($fp, $filaDatos);
            }
        } else {
            echo "Error, no se pudo abrir el archivo";
            return false;
        }
        fclose($fp);
        return true;
    }




    //@ Este metodo devuelve un array de objetos Carta, relleno con los datos del archivo /mazos/(mazo que se le pase).csv
    function leerMazo($parametro)
    {
        if ($parametro == 'PatoEspada') {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo1, "r")) {
                while ($filadatos = fgetcsv($fp, 0, ",")) {
                    $carta = new Carta($filadatos[0], $filadatos[1], $filadatos[2]);
                    $arrayDatos[] = $carta;
                }
            } else {
                echo "Error, no se puede acceder al archivo " . $this->rutaMazo1 . "<br>";
                return false;
            }
            fclose($fp);
            return $arrayDatos;
        }
        if ($parametro == 'PatoEscudo') {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo2, "r")) {
                while ($filadatos = fgetcsv($fp, 0, ",")) {
                    $carta = new Carta($filadatos[0], $filadatos[1], $filadatos[2]);
                    $arrayDatos[] = $carta;
                }
            } else {
                echo "Error, no se puede acceder al archivo " . $this->rutaMazo2 . "<br>";
                return false;
            }
            fclose($fp);
            return $arrayDatos;
        }
        if ($parametro == 'PatoRifle') {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo3, "r")) {
                while ($filadatos = fgetcsv($fp, 0, ",")) {
                    $carta = new Carta($filadatos[0], $filadatos[1], $filadatos[2]);
                    $arrayDatos[] = $carta;
                }
            } else {
                echo "Error, no se puede acceder al archivo " . $this->rutaMazo3 . "<br>";
                return false;
            }
            fclose($fp);
            return $arrayDatos;
        }
    }
}
