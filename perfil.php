<?php
include "DAO.class.php";
session_start();
//@ Comprobase que o usuario se autenticou
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}
unset($_SESSION['personaje']);
unset($_SESSION['enemigo']);
unset($_SESSION['ronda']);
$usuario = $_SESSION['usuario'];
$errores = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/hoja<?php

                                            if (isset($_COOKIE['tema'])) {
                                                echo $_COOKIE['tema'];
                                            } else {
                                                echo "Clara";
                                            } ?>.css">


    <style>
        body {
            font-size: <?php if (isset($_COOKIE['tamano'])) {
                            echo $_COOKIE['tamano'];
                        } else {
                            echo "14";
                        } ?>px;
            font-family: <?php if (isset($_COOKIE['fuente'])) {
                                echo $_COOKIE['fuente'];
                            } else {
                                echo "calibri";
                            } ?>;
        }
    </style>

    <title>Perfil</title>
</head>

<body>
    <?php

    include "menu.php";

    $tamano = "14";
    //@ Codigo en caso de venir desde modificar
    if (isset($_POST['modificar'])) {
        //@ Codigo para cambiar las preferencias, primero las valida
        if (!empty($_POST['tamano'])) {
            if (isset($_POST['tamano'])) {
                $numero = trim($_POST['tamano']);
                if (!preg_match('/^[0-9]+$/', $numero)) {
                    array_push($errores, "El formato del tamaño de fuente no es correcto, solo debe tener numeros");
                }
            }
        }
        if (!isset($_POST['tema'])) {

            array_push($errores, "Falta el tema");
        }
        if (!isset($_POST['fuente'])) {

            array_push($errores, "Falta la fuente");
        }
        //@ Escribo los datos en la cookie si no hay errores
        if (count($errores) == 0) {
            unset($_COOKIE['tamano']);
            unset($_COOKIE['tema']);
            unset($_COOKIE['fuente']);
            if (empty($_POST['tamano'])) {
                setcookie('tamano', '14');
            } else {
                setcookie('tamano', $_POST['tamano']);
            }
            setCookie("tema", $_POST['tema']);
            setCookie("fuente", $_POST['fuente']);
            header("Location: index.php");
        }
    }
    //@ Codigo para resetear las preferencias a por defecto
    else if (isset($_POST['defecto'])) {
        unset($_COOKIE['tamano']);
        unset($_COOKIE['tema']);
        unset($_COOKIE['fuente']);
        setcookie('tamano', '14');
        setCookie("tema", 'Clara');
        setCookie("fuente", 'calibri');
        header("Location: index.php");
    } else {

    ?>
        <div id="contenedorform">
            <form action="perfil.php" method="post">
                <legend> Elige tus opciones de personalización: </legend>
                <label for="lang">Tema</label>
                <select name="tema" id="lang">
                    <option value="Clara" <?php if (
                                                isset($_POST['tema']) && strcasecmp("clara", $_POST['tema'])
                                            ) echo "selected"; ?>>Claro</option>
                    <option value="Oscura" <?php if (
                                                isset($_POST['tema']) && strcasecmp("oscura", $_POST['tema'])
                                            ) echo "selected"; ?>>Oscuro</option>
                </select> </br></br>

                <label for="tamano">Tamaño de letra</label>
                <input type="number" id="tamano" name="tamano" /><br> <br>
                <label for="lang">Fuente</label>
                <select name="fuente" id="lang">
                    <option value="calibri" <?php if (
                                                isset($_POST['fuente']) && strcasecmp("calibri", $_POST['fuente'])
                                            ) echo "selected"; ?>>Calibri</option>
                    <option value="arial" <?php if (
                                                isset($_POST['fuente']) && strcasecmp("arial", $_POST['fuente'])
                                            ) echo "selected"; ?>>Arial</option>
                </select>
                <input type="submit" name="modificar" value="modificar">
                <input type="submit" name="defecto" value="defecto">
                <br><br>

            </form>
        </div>
    <?php }



    ?>





</body>

</html>