<?php
include "Usuario.class.php";
include "Publicacion.class.php";
class DAO
{
    private $rutaPublicaciones = "./CSV/publicaciones.csv";
    private $rutaUsuarios = "./CSV/usuarios.csv";
    public function getruta()
    {
        return $this->rutafichero;
    }
    public function setRuta($ruta)
    {
        $this->rutafichero = $ruta;
    }

    public function __construct()
    {
    }

    function devolverArrayPublicaciones()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaPublicaciones, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                //   $publicacion = new Publicacion($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4], $filaDatos[5]);
                //  $arrayDatos[] = $publicacion;
            }
        } else {
            echo "Error, no se puede acceder al archivo " . $this->rutaPublicaciones . "<br>";
            return false;
        }
        fclose($fp);
        return $arrayDatos;
    }


    function devolverArrayUsuarios()
    {
        $arrayDatos = array();
        if ($fp = fopen($this->rutaUsuarios, "r")) {
            while ($filaDatos = fgetcsv($fp, 0, ",")) {
                //    $usuario = new Usuario($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4], $filaDatos[5], $filaDatos[6], $filaDatos[7], $filaDatos[8], $filaDatos[9], $filaDatos[10], $filaDatos[11]);
                //    $arrayDatos[] = $usuario;
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
            array_push($arrayIntermedio, $objeto->getTelefono());
            array_push($arrayIntermedio, $objeto->getValores());
            array_push($arrayIntermedio, $objeto->getCajas());
            array_push($arrayIntermedio, $objeto->getNacimiento());
            array_push($arrayIntermedio, $objeto->getDescripcion());
            array_push($arrayIntermedio, $objeto->getuserName());
            array_push($arrayIntermedio, $objeto->getGenero());
            array_push($arrayIntermedio, $objeto->getServidor());
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
}
