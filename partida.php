<?php

// Proyecto por Pedro Pina Menéndez

// Compruebo que los valores de la sesion esten correctos
session_start();
if ((!isset($_SESSION['usuario'])) || (!isset($_SESSION['partida']))) {
    header("Location: index.php");
}
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

    //@ Funcion para crear una mano a partir de la baraja
    function repartirmano($baraja)
    {
        $manoJugador = array();
        for ($i = 0; $i < 5; $i++) {
            $valor = rand(1, count($baraja) - 1);
            $manoJugador[] = $baraja[$valor];
        }
        return $manoJugador;
    }

    //@ Funcion para implementar el efecto de las cartas
    function efectocarta($personaje, $carta)
    {
        switch ($carta->getTipo()) {
            case 'defensa':
                $personaje->setVidaGris($carta->getValor() + $personaje->getDefensa());
                break;
            case 'cura':
                $personaje->curar($carta->getValor());
                break;
        }
    }

    //@ Des-serializo la partida y saco los componentes necesarios de ella(los personajes, la ronda, etc)
    $partida = unserialize($_SESSION['partida']);
    $heroe = $partida->getheroe();
    $villano = $partida->getvillano();
    $baraja = $DAO->leerMazo($heroe->getNombre());
    $manoactual = repartirmano($baraja);
    if ($partida->getronda() == 0) {
        $manopasada = $manoactual;
    } else {
        $manopasada = $partida->getmanoturnoanterior();
    }
    $partida->empezarpartida();
    $partida->setmanoturnoanterior($manoactual);
    $ia = $partida->getia();
    $partida->setia(rand(1, 3));

    //@ Si se ha pulsado el boton ronda, compruebo que cartas se habian elegido, las saco de la variable "manopasada"
    //@ y ejecuto sus efectos

    if (isset($_POST['ronda'])) {

        if (isset($_POST['cartac1'])) {
            switch ($manopasada[0]->getTipo()) {
                default:
                    efectocarta($heroe, $manopasada[0]);
                    break;
                case 'ataque':
                    $dano = intval($manopasada[0]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        if (isset($_POST['cartac2'])) {
            switch ($manopasada[1]->getTipo()) {
                default:
                    efectocarta($heroe, $manopasada[1]);
                    break;
                case 'ataque':
                    $dano = intval($manopasada[1]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        if (isset($_POST['cartac3'])) {
            switch ($manopasada[2]->getTipo()) {
                default:
                    efectocarta($heroe, $manopasada[2]);
                    break;
                case 'ataque':
                    $dano = intval($manopasada[2]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        if (isset($_POST['cartac4'])) {
            switch ($manopasada[3]->getTipo()) {
                default:
                    efectocarta($heroe, $manopasada[3]);
                    break;
                case 'ataque':
                    $dano = intval($manopasada[3]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        if (isset($_POST['cartac5'])) {
            switch ($manopasada[4]->getTipo()) {
                default:
                    efectocarta($heroe, $manopasada[4]);
                    break;
                case 'ataque':
                    $dano = intval($manopasada[4]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        //@ Si el villano ha muerto, se termina automaticamente y se va a la pantalla de resultados
        if ($villano->getVida() <= 0) {
            $_SESSION['resultado'] = "victoria";
            header("Location: resultados.php");
        }

        //@ El villano hace su turno, y se escoge aleatoriamente su siguiente movimiento
        $villano->setVidaGris(0);
        $accion = $villano->accionvillano($ia);
        $ia = rand(1, 3);
        $partida->setia($ia);
        if ($accion != false) {
            $heroe->hacerdanho($accion);
        }

        //@ Si el heroe ha muerto, se termina automaticamente y se va a la pantalla de resultados
        if ($heroe->getVida() <= 0) {
            $_SESSION['resultado'] = "derrota";
            header("Location: resultados.php");
        }

        //@ Introduzco todos los parametros actualizados en la variable partida, la serializo y la meto en la sesion
        $partida->setheroe($heroe);
        $partida->setmanojugador($manoactual);
        $partida->setvillano($villano);
        $_SESSION['partida'] = serialize($partida);
    }

    //@ El siguiente codigo es codigo html con algo de php insertado para que tenga una interfaz interactiva
    ?>
    <div id="superiordiv">
        <img id="fotoheroe" src="MULTIMEDIA/<?php echo $heroe->getNombre();  ?>.png">
        <img id="fotomalo" src="MULTIMEDIA/<?php echo $villano->getNombre();  ?>.png">
        <div id="accionesenemigo">
            <?php

            $aj = intval($ia);
            switch ($aj) {
                case '1':
                    echo "<p>¡El enemigo va a defenderse!</p>";
                    break;
                case '2':
                    echo "<p>¡El enemigo va a atacar!</p>";
                    break;
                case '3':
                    echo "<p>¡El enemigo va a defenderse y atacar a la vez!</p>";
                    break;
            }

            ?>
        </div>
    </div>
    <div id="interfaz">
        <form action="partida.php" method="post">
            <div id="manojugador">

                <div class="container">

                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoactual[0]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoactual[0]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoactual[0]->getTipo(); ?></span>
                            <div class="name" style="color: black;"><?php echo $manoactual[0]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac1" value="cartac1" id="cartac1">jugar
                        </div>
                    </div>

                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoactual[1]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoactual[1]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoactual[1]->getTipo(); ?></span>
                            <div class="name" style="color: black;"><?php echo $manoactual[1]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac2" value="cartac2" id="cartac2">jugar
                        </div>
                    </div>

                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoactual[2]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoactual[2]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoactual[2]->getTipo(); ?></span>
                            <div class="name" style="color: black;"><?php echo $manoactual[2]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac3" value="cartac3" id="cartac3">jugar
                        </div>
                    </div>

                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoactual[3]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoactual[3]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoactual[3]->getTipo(); ?></span>
                            <div class="name" style="color: black;"><?php echo $manoactual[3]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac4" value="cartac4" id="cartac4">jugar
                        </div>
                    </div>

                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoactual[4]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoactual[4]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoactual[4]->getTipo(); ?></span>
                            <div class="name" style="color: black;"><?php echo $manoactual[4]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac5" value="cartac5" id="cartac5">jugar
                        </div>
                    </div>

                </div>


            </div>
            <div id="descripcioncarta">
                <p> Vida : <?php echo $heroe->getVida(); ?> puntos</p>
                <p> Escudo : <?php echo $heroe->getVidaGris(); ?> puntos</p>
                <p> Ataque : <?php echo $heroe->getAtaque(); ?> puntos</p>
                <p> Defensa : <?php echo $heroe->getDefensa(); ?> puntos</p>
                <p> Vida Enemigo: <?php echo $villano->getVida(); ?> puntos</p>
                <p> Escudo Enemigo: <?php echo $villano->getVidaGris(); ?> puntos</p>
                <input type="submit" value="ronda" id="ronda" name="ronda">
            </div>
        </form>
    </div>


</body>

</html>