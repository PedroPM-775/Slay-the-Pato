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
    <title>Partida</title>
</head>

<body>

    <?php
    $DAO = new DAO();

    function repartirmano($baraja)
    {
        $manoJugador = array();
        for ($i = 0; $i < 5; $i++) {
            $valor = rand(1, count($baraja) - 1);
            $manoJugador[] = $baraja[$valor];
        }
        return $manoJugador;
    }

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



    if ($_SESSION['ronda'] == 0) {
        $heroe = new Personaje($_SESSION['personaje']);
        $villano = new Personaje($_SESSION['enemigo']);
        $baraja = $DAO->leerMazo($heroe->getNombre());
        $manoJugador = repartirmano($baraja);
        $manoTurnoAnterior = $manoJugador;
        $actuacion = 1;
    } else {
        $heroe = unserialize($_SESSION['heroe']);
        $villano = unserialize($_SESSION['villano']);
        $baraja = $DAO->leerMazo($heroe->getNombre());
        $manoJugador = repartirmano($baraja);
        $manoTurnoAnterior = unserialize($_SESSION['mano']);
        $actuacion = $_SESSION['actuacion'];
    }

    if (isset($_POST['ronda'])) {

        if (isset($_POST['cartac1'])) {
            switch ($manoTurnoAnterior[0]->getTipo()) {
                default:
                    efectocarta($heroe, $manoTurnoAnterior[0]);
                    break;
                case 'ataque':
                    $dano = intval($manoTurnoAnterior[0]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }
        if (isset($_POST['cartac2'])) {
            switch ($manoTurnoAnterior[1]->getTipo()) {
                default:
                    efectocarta($heroe, $manoTurnoAnterior[1]);
                    break;
                case 'ataque':
                    $dano = intval($manoTurnoAnterior[1]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }
        if (isset($_POST['cartac3'])) {
            switch ($manoTurnoAnterior[2]->getTipo()) {
                default:
                    efectocarta($heroe, $manoTurnoAnterior[2]);
                    break;
                case 'ataque':
                    $dano = intval($manoTurnoAnterior[2]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }
        if (isset($_POST['cartac4'])) {
            switch ($manoTurnoAnterior[3]->getTipo()) {
                default:
                    efectocarta($heroe, $manoTurnoAnterior[3]);
                    break;
                case 'ataque':
                    $dano = intval($manoTurnoAnterior[3]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }
        if (isset($_POST['cartac5'])) {
            switch ($manoTurnoAnterior[4]->getTipo()) {
                default:
                    efectocarta($heroe, $manoTurnoAnterior[4]);
                    break;
                case 'ataque':
                    $dano = intval($manoTurnoAnterior[4]->getValor()) + intval($heroe->getAtaque());
                    $villano->hacerdanho(intval($dano));
                    break;
            }
        }

        if ($villano->getVida() <= 0) {
            $_SESSION['resultado'] = "victoria";
            header("Location: resultados.php");
        }

        $villano->setVidaGris(0);
        $accion = $villano->accionvillano($actuacion);

        if ($accion != false) {
            $heroe->hacerdanho($accion);
        }
        if ($heroe->getVida() <= 0) {
            $_SESSION['resultado'] = "derrota";
            header("Location: resultados.php");
        }
        $_SESSION['heroe'] = serialize($heroe);
        $_SESSION['mano'] = serialize($manoJugador);
        $_SESSION['villano'] = serialize($villano);
        $_SESSION['ronda'] = 1;
        $_SESSION['actuacion'] = rand(1, 3);
    }

    ?>
    <div id="superiordiv">
        <img id="fotoheroe" src="MULTIMEDIA/<?php echo $heroe->getNombre();  ?>.png">
        <img id="fotomalo" src="MULTIMEDIA/<?php echo $villano->getNombre();  ?>.png">
        <div id="accionesenemigo">
            <?php
            if ($_SESSION['ronda'] == 0) {
                echo "<p> El enemigo se prepara...</p>";
            } else {
                $aj = intval($actuacion);
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
            }
            ?>
        </div>
    </div>
    <div id="interfaz">
        <form action="partida.php" method="post">
            <div id="manojugador">

                <div class="container">
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[0]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoJugador[0]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[0]->getTipo(); ?></span>
                            <div class="name"><?php echo $manoJugador[0]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac1" value="cartac1" id="cartac1">jugar
                        </div>

                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[1]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoJugador[1]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[1]->getTipo(); ?></span>
                            <div class="name"><?php echo $manoJugador[1]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac2" value="cartac2" id="cartac2">jugar
                        </div>

                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[2]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoJugador[2]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[2]->getTipo(); ?></span>
                            <div class="name"><?php echo $manoJugador[2]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac3" value="cartac3" id="cartac3">jugar
                        </div>

                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[3]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoJugador[3]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[3]->getTipo(); ?></span>
                            <div class="name"><?php echo $manoJugador[3]->getNombre(); ?></div>
                            <input type="checkbox" name="cartac4" value="cartac4" id="cartac4">jugar
                        </div>

                    </div>
                    <div class="card">
                        <img class="imgcarta" src="MULTIMEDIA/<?php echo $manoJugador[4]->getTipo() ?>.png">
                        <div class="card__details">
                            <span class="tag"><?php echo $manoJugador[4]->getValor(); ?></span>
                            <span class="tag"><?php echo $manoJugador[4]->getTipo(); ?></span>
                            <div class="name"><?php echo $manoJugador[4]->getNombre(); ?></div>
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