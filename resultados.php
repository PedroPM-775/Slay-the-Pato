<?php

//@ Proyecto por Pedro Pina Menéndez


session_start();
if ((!isset($_SESSION['usuario'])) || (!isset($_SESSION['partida'])) || (!isset($_SESSION['resultado']))) {
    header("Location: index.php");
}
include "Partida.class.php";
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
    <div id="fondo">
        <?php
        include "menu.php";
        $partida = unserialize($_SESSION['partida']);
        $heroe = $partida->getheroe();
        $villano = $partida->getvillano();
        $resultado = $_SESSION['resultado'];
        if ($resultado == "victoria") {
            echo "<div id='resultadodiv'>"; ?>
            <img id="fotoheroe" src="MULTIMEDIA/<?php echo $heroe->getNombre();  ?>.png">
        <?php echo "<h1> Enhorabuena por tu Pato-Victoria</h1>";
            echo "<a href='index.php'>para volver a la pantalla de inicio pulsa aqui o en el menu superior </a></div>";
        } else {
            echo  "<div id='resultadodiv'>"; ?>
            <img id="fotomalo" src="MULTIMEDIA/<?php echo $villano->getNombre();  ?>.png">
        <?php echo "<h1>Tus pato-habilidades no han bastado</h1>";
            echo "<h3> intentalo de nuevo, ¡no te rindas!</h3>";
            echo "<a href='index.php'>para volver a la pantalla de inicio pulsa aqui o en el menu superior </a></div>";
        }

        ?>
    </div>
</body>

</html>