<?php

//@ Proyecto por Pedro Pina Menéndez
//@ Esta es la pantalla principal de la aplicacion. Aqui se eligen el personaje del jugador y el enemigo

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
    //$ Con esta pantalla incorporamos el menú a nuestra pagina
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
        //@ Este es el formulario que se usa para seleccionar personajes
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

                <!-- //@ En este select se selecciona el enemigo. Algunos enemigos solo están disponibles
                     //@ si el usuario los ha desbloqueado -->
                <select name="enemigo" id="enemigo">
                    <option value="firulais">Facil</option>
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        $usuario = unserialize(($_SESSION['usuario']));
                        $arrayprogreso = $DAO->devolverArrayProgresos();
                        $arrayconcretoprogreso = array();

                        for ($i = 0; $i < count($arrayprogreso); $i++) {
                            $objeto = $arrayprogreso[$i];
                            if ($objeto->getid() == $usuario->getuserName()) {
                                array_push($arrayconcretoprogreso, $objeto);
                            }
                        }
                        $progreso = $arrayconcretoprogreso[0];
                        var_dump($progreso);

                        if ($progreso->desbloqueado(2)) {
                            echo "<option value='akuma'> Normal</option>";
                        }
                        if ($progreso->desbloqueado(3)) {

                            echo " <option value='vader'>Dificil</option>";
                        }
                    } ?>



                </select>
                <br>

                <input type="submit" id="comenzar" value="comenzar" name="comenzar">
            </form>
        </div>
    <?php
    } ?>
</body>

</html>