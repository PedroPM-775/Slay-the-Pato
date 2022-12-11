<?php
session_start();
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
    <title>Pagina Principal</title>
</head>

<body>
    <?php
    include "menu.php";

    if (isset($_POST['comenzar'])) {
        $_SESSION['personaje'] = $_POST['personaje'];
        $_SESSION['enemigo'] = $_POST['enemigo'];
        header("Location: partida.php");
    } else {

    ?>
        <form action="index.php" method="post">
            <select name="personaje" id="personaje">
                <option value="pato1" selected>Palanceado</option>
                <option value="pato2">Patescudo</option>
                <option value="pato3">Francotipato</option>

            </select>
            <select name="enemigo" id="enemigo">
                <option value="vader" selected>Vader</option>
                <option value="akuma">Akuma</option>
                <option value="firulais">Firulais</option>
                <option value="Jamal">Jamal</option>

            </select>
            <br>
            <!-- //$ Posible sugerencia, añadir imagenes de las criaturas y que con js cambien las imagenes -->
            <input type="submit" value="comenzar" name="comenzar">
        </form>
    <?php
    } ?>
</body>

</html>