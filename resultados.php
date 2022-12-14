<?php
session_start();
if ((!isset($_SESSION['usuario'])) || (!isset($_SESSION['enemigo'])) || (!isset($_SESSION['personaje'])) || (!isset($_SESSION['ronda']))) {
    header("Location: index.php");
}
include "Personaje.class.php";
include "DAO.class.php";
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
    <title>Document</title>
</head>

<body>

    <?php
    include "menu.php";
    $resultado = $_SESSION['resultado'];
    if ($resultado == "victoria") {
        echo "ganaste";
    } else {
        echo "perdiste";
    }

    ?>
</body>

</html>