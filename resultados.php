<?php

//@ Proyecto por Pedro Pina Menéndez
//@ En esta pagina se muestra el resultado de la batalla, asi como se le puede indicar 
//@ al jugador que ha desbloqueado nuevo contenido

session_start();
if ((!isset($_SESSION['usuario'])) || (!isset($_SESSION['partida'])) || (!isset($_SESSION['resultado']))) {
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
    <title>Resultados de la batalla</title>
</head>

<body>


    <div id="fondo">
        <?php
        include "menu.php";
        $DAO = new DAO();
        $datos = $DAO->devolverArrayGuardados();
        $listaid = array();
        for ($i = 1; $i < count($datos); $i++) {
            array_push($listaid, $datos[$i]->getid());
        }

        $unico = false;
        while ($unico == false) {
            $codigo = rand(1, 800000);
            $encontrado = false;
            for ($i = 0; $i < count($listaid); $i++) {
                if ($codigo == $listaid[$i]) {
                    $encontrado = true;
                }
            }
            if ($encontrado != true) {
                $unico = true;
            }
        }

        $usuario = unserialize($_SESSION['usuario']);
        $nombreusuario = $usuario->getuserName();

        $partida = unserialize($_SESSION['partida']);
        $heroe = $partida->getheroe();
        $heroenombre = $heroe->getNombre();

        $villano = $partida->getvillano();
        $villanonombre = $villano->getNombre();
        unset($_SESSION['partida']);
        $resultado = $_SESSION['resultado'];


        $guardado = new Guardado($heroenombre, $villanonombre, $resultado, $codigo, $nombreusuario);
        array_push($datos, $guardado);

        $DAO->escribirArrayGuardados($datos);

        $arrayprogreso = $DAO->devolverArrayProgresos();
        $arrayconcretoprogreso = array();

        for ($i = 0; $i < count($arrayprogreso); $i++) {
            $objeto = $arrayprogreso[$i];
            if ($objeto->getid() == $usuario->getuserName()) {
                array_push($arrayconcretoprogreso, $objeto);
            }
        }


        if ($resultado == "victoria") {
            echo "<div id='resultadodiv'>"; ?>
            <img id="fotoheroe" src="MULTIMEDIA/<?php echo $heroe->getNombre();  ?>.png">
            <?php echo "<h1> Enhorabuena por tu Pato-Victoria</h1>";
            echo "<a id='enlaceresultados' href='index.php'>para volver a la pantalla de inicio pulsa aqui o en el menu superior </a>";

            $progreso = $arrayconcretoprogreso[0];
            if ($progreso->tododesbloqueado()) {
                echo "<p> Enhorabuena, ya has desbloqueado todos el contenido. ¡Bien hecho!</p></div>";
            } else {
                $indice = $progreso->desbloquearsiguiente();
                $progreso->desbloquear($indice);
                echo  "<p> Acabas de desbloquear algo nuevo por tu victoria, ¡Bien hecho!</p></div>";

                for ($i = 1; $i < count($arrayprogreso); $i++) {
                    $objeto = $arrayprogreso[$i];
                    if ($objeto->getid() == $usuario->getuserName()) {
                        unset($arrayprogreso[$i]);
                    }
                }
                $arrayfinal = array_values($arrayprogreso);
                array_push($arrayfinal, $progreso);
                $DAO->escribirArrayProgresos($arrayfinal);
            }
        } else {
            echo  "<div id='resultadodiv'>"; ?>
            <img id="fotomalo" src="MULTIMEDIA/<?php echo $villano->getNombre();  ?>.png">
        <?php echo "<h1>Tus pato-habilidades no han bastado</h1>";
            echo "<h3> intentalo de nuevo, ¡no te rindas!</h3>";
            echo "<a id='enlaceresultados' href='index.php'>para volver a la pantalla de inicio pulsa aqui o en el menu superior </a></div>";
        }

        ?>
    </div>
</body>

</html>