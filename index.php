<?php

// Proyecto por Pedro Pina Menéndez


include "DAO.class.php";
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
    $DAO = new DAO();
    //@ Si pulsamos en el boton de Comenzar, comprueba si esta iniciada la sesion, crea un objeto partida y nos lleva a partida.php
    if (isset($_POST['comenzar'])) {
        if (isset($_SESSION['usuario'])) {

            $heroe = new Personaje($_POST['personaje']);
            var_dump($heroe);
            $enemigo = new Personaje($_POST['enemigo']);
            $baraja = $DAO->leerMazo($heroe->getNombre());
            $partida = new Partida($heroe, $enemigo, $baraja);

            $_SESSION['partida'] = serialize($partida);

            header("Location: partida.php");
        } else {
            header("Location: login.php");
        }
    } else {
        //@ Formulario para seleccionar personajes
    ?>
        <div id="contenedorindex">
            <form action="index.php" method="post">
                <h1 id="labelbueno">Escoge a tu personaje</h1>
                <select name="personaje" id="personaje">
                    <option value="PatoEspada" selected>Palanceado</option>
                    <option value="PatoEscudo">Patescudo</option>
                    <option value="PatoRifle">Francotipato</option>

                </select>
                <h1 id="labelmalo">Escoge a tu enemigo</h1>
                <select name="enemigo" id="enemigo">
                    <option value="firulais">Facil</option>
                    <option value="akuma">Normal</option>
                    <option value="vader">Dificil</option>

                </select>
                <br>

                <!-- //$ Posible sugerencia, añadir imagenes de las criaturas y que con js cambien las imagenes -->
                <input type="submit" id="comenzar" value="comenzar" name="comenzar">
            </form>
        </div>
    <?php
    } ?>
</body>

</html>