<?php
//@ Proyecto por Pedro Pina Menéndez

//@ Esta clase fue creada para gestionar los usuarios que hay en la base de datos
class Usuario
{
    //@ Los atributos que tiene la clase son el nombre del usuario, su contraseña, su correo, su nombre de usuario y su rol
    private $nombre;
    private $contrasena;
    private $correo;
    private $username;
    private $rol;



    //@ Getters
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getContrasena()
    {
        return $this->contrasena;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getuserName()
    {
        return $this->username;
    }
    public function getRol()
    {
        return $this->rol;
    }


    //@ Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setuserName($username)
    {
        $this->username = $username;
    }
    public function setRol($rol)
    {
        $this->rol = $rol;
    }


    //@ Metodos de verdad
    public function __construct($nombre, $contrasena, $correo, $username, $rol)
    {
        $this->setNombre($nombre);
        $this->setContrasena($contrasena);
        $this->setCorreo($correo);
        $this->setuserName($username);
        $this->setRol($rol);
    }

    //@ Esta funcion comprueba si el atributo "rol" es de administrador, y devuelve true si es asi o false si es solo un usuario corriente
    public function Admin()
    {
        if ($this->rol == 'Administrador') {
            return true;
        } else {
            return false;
        }
    }
}
