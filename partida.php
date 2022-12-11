<?php
session_start();
if ((!isset($_SESSION['usuario'])) || (!isset($_SESSION['enemigo'])) || (!isset($_SESSION['personaje']))) {
    header("Position: login.php");
}
include "Personaje.class.php";
include "Enemigo.class.php";
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
    <title>Partida</title>
</head>

<body>

    <?php
    $DAO = new DAO();

    $baraja = $DAO->leerMazo(1);

    function repartirmano($baraja)
    {
        $manoJugador = array();
        for ($i = 0; $i < 5; $i++) {
            $valor = rand(1, count($baraja) - 1);
            $manoJugador[] = $baraja[$valor];
        }
        return $manoJugador;
    }




    if (isset($_SESSION['heroe'])) {
        $heroe = unserialize($_SESSION['heroe']);
    } else {
        $heroe = new Personaje($_SESSION['personaje'], 10, 2, 0, 0);
    }
    if (isset($_SESSION['villano'])) {
        $villano = unserialize($_SESSION['villano']);
    } else {
        $villano = new Personaje($_SESSION['enemigo'], 5, 2, 2, 2);
    }
    $manoJugador = repartirmano($baraja);

    if (isset($_POST['']))




    ?>


    <div id="superiordiv">
        <h1><?php echo $_SESSION['personaje'] ?></h1>
        <h1><?php echo $_SESSION['enemigo'] ?></h1>
    </div>
    <div id="interfaz">
        <form action="partida.php" method="post">
            <div id="manojugador">


                <div class="container">


                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[0]->getTipo() ?>.png">

                        <!-- A div with card__details class to hold the details in the card  -->
                        <div class="card__details">

                            <!-- Span with tag class for the tag -->
                            <span class="tag"><?php echo $manoJugador[0]->getValor(); ?></span>

                            <span class="tag"><?php echo $manoJugador[0]->getTipo(); ?></span>

                            <!-- A div with name class for the name of the card -->
                            <div class="name"><?php echo $manoJugador[0]->getNombre(); ?></div>



                            <input type="checkbox" name="cartac1" id="cartac1">
                        </div>


                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[1]->getTipo() ?>.png">

                        <!-- A div with card__details class to hold the details in the card  -->
                        <div class="card__details">

                            <!-- Span with tag class for the tag -->
                            <span class="tag"><?php echo $manoJugador[1]->getValor(); ?></span>

                            <span class="tag"><?php echo $manoJugador[1]->getTipo(); ?></span>

                            <!-- A div with name class for the name of the card -->
                            <div class="name"><?php echo $manoJugador[1]->getNombre(); ?></div>



                            <input type="checkbox" name="cartac1" id="cartac1">jugar
                        </div>


                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[2]->getTipo() ?>.png">

                        <!-- A div with card__details class to hold the details in the card  -->
                        <div class="card__details">

                            <!-- Span with tag class for the tag -->
                            <span class="tag"><?php echo $manoJugador[2]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[2]->getTipo(); ?></span>

                            <!-- A div with name class for the name of the card -->
                            <div class="name"><?php echo $manoJugador[2]->getNombre(); ?></div>



                            <input type="checkbox" name="cartac1" id="cartac1">
                        </div>


                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[3]->getTipo() ?>.png">

                        <!-- A div with card__details class to hold the details in the card  -->
                        <div class="card__details">

                            <!-- Span with tag class for the tag -->
                            <span class="tag"><?php echo $manoJugador[3]->getValor(); ?></span>

                            <span class="tag"><?php echo $manoJugador[3]->getTipo(); ?></span>

                            <!-- A div with name class for the name of the card -->
                            <div class="name"><?php echo $manoJugador[3]->getNombre(); ?></div>



                            <input type="checkbox" name="cartac1" id="cartac1">
                        </div>


                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[4]->getTipo() ?>.png">

                        <!-- A div with card__details class to hold the details in the card  -->
                        <div class="card__details">

                            <!-- Span with tag class for the tag -->
                            <span class="tag"><?php echo $manoJugador[4]->getValor(); ?></span>

                            <span class="tag"><?php echo $manoJugador[4]->getTipo(); ?></span>

                            <!-- A div with name class for the name of the card -->
                            <div class="name"><?php echo $manoJugador[4]->getNombre(); ?></div>



                            <input type="checkbox" name="cartac1" id="cartac1">
                        </div>


                    </div>
                </div>


            </div>
            <div id="descripcioncarta">
                <p> Vida : <?php echo $heroe->getVida(); ?> puntos</p>
                <p> Vida Gris : <?php echo $heroe->getVidaGris(); ?> puntos</p>
                <p> Ataque : <?php echo $heroe->getAtaque(); ?> puntos</p>
                <p> Defensa : <?php echo $heroe->getDefensa(); ?> puntos</p>

                <p> Vida Enemigo: <?php echo $villano->getVida(); ?> puntos</p>
                <p> Vida Gris Enemigo: <?php echo $villano->getVidaGris(); ?> puntos</p>
                <input type="submit" value="ronda" id="ronda" name="ronda">
            </div>
        </form>
    </div>


</body>

</html>