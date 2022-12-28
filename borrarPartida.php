<?php

//@ Proyecto por Pedro Pina Menéndez


include "DAO.class.php";
include "Guardado.class.php";

//@ Recupérase a información da sesión
session_start();
unset($_SESSION['personaje']);
unset($_SESSION['enemigo']);
unset($_SESSION['ronda']);
//@ Comprobase que o usuario se autenticou
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}
$usuario = unserialize($_SESSION['usuario']);
if (!$usuario->Admin()) {
    header("Location: index.php");
}

$DAO = new DAO();
$datos = $DAO->devolverArrayGuardados();

//@ Se coge la fila del enlace, si no se ha enviado se da un error y un enlace para volver a la pagina de usuario
if (isset($_GET['fila'])) {

    $fila = $_GET['fila'];
    if ($fila > 0 && $fila < count($datos)) {
        unset($datos[$fila]);
        $datosfinal = array_values($datos);
        $DAO->escribirArrayGuardados($datosfinal);
        header("Location: usuarios.php");
    } else {
        echo "Ha habido un error, <a href='usuarios.php'>pulse en este enlace para volver al perfil de usuario </a>";
    }
} else {
    echo "Ha habido un error, <a href='usuarios.php'>pulse en este enlace para volver al perfil de usuario </a>";
}
