<?php
include "Usuario.class.php";
include "Publicacion.class.php";
class DAO
{
    private $rutaUsuarios = "./CSV/usuarios.csv";
    private $rutaMazo1 = "./MAZOS/mazo.csv";
    private $rutaMazo2 = "./MAZOS/mazo2.csv";
    private $rutaMazo3 = "./MAZOS/mazo3.csv";

    public function __construct()
    {
    }

    function devolverArrayUsuarios()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaUsuarios, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                $usuario = new Usuario($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4], $filaDatos[5]);
                $arrayDatos[] = $usuario;
            }
        } else {
            echo "Error, no se puede acceder al archivo " . $this->rutaUsuarios . "<br>";
            return false;
        }
        fclose($fp);
        return $arrayDatos;
    }

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

    function leerMazo($parametro)
    {
        if ($parametro == 1) {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo1, "r")) {
                while ($filaDatos = fgetcsv($fp, 0, ",")) {
                    $arrayDatos[] = $filaDatos;
                }
            } else {
                echo "Error, no se puede acceder al archivo " . $this->rutaMazo1 . "<br>";
                return false;
            }
            fclose($fp);
            return $arrayDatos;
        }
        if ($parametro == 2) {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo2, "r")) {
                while ($filaDatos = fgetcsv($fp, 0, ",")) {
                    $arrayDatos[] = $filaDatos;
                }
            } else {
                echo "Error, no se puede acceder al archivo " . $this->rutaMazo2 . "<br>";
                return false;
            }
            fclose($fp);
            return $arrayDatos;
        }
        if ($parametro == 3) {
            $arrayDatos = array();
            if ($fp = fopen($this->rutaMazo3, "r")) {
                while ($filaDatos = fgetcsv($fp, 0, ",")) {
                    $arrayDatos[] = $filaDatos;
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
