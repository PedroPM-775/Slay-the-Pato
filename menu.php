<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./CSS/hojamenu.css">
</head>

<body>
    <!--//@ Barra de menu que muestra determinados elementos si tienes rol de administrador-->

    <div class="topnav">
        <a href="logoff.php">Salir</a>
        <a href="usuarios.php" <?php
                                if (isset($_SESSION['usuario'])) {
                                    $a = unserialize($_SESSION['usuario']);
                                    if (!$a->Admin()) {
                                        echo "style ='display:none;'";
                                    }
                                } else {
                                    echo "style ='display:none;'";
                                }
                                ?>>Usuarios</a>
        <a href="perfil.php">Perfil</a>
        <a href="index.php">Pagina Principal</a>

        <div id="usuario">

            <img id="fotousuario" src="<?php

                                        if (isset($_SESSION['usuario'])) {
                                            $a = unserialize($_SESSION['usuario']);

                                            $nombrefoto = "fotos/foto_" . $a->getuserName() . ".jpg";
                                            if (file_exists($nombrefoto)) {

                                                echo $nombrefoto;
                                            } else {
                                                echo "FOTOS/default.png";
                                            }
                                        } else {
                                            echo "FOTOS/default.png";
                                        }
                                        ?>" />

            <p><?php
                if (isset($_SESSION['usuario'])) {
                    $a = unserialize($_SESSION['usuario']);
                    echo $a->getuserName();
                } else {
                    echo "Invitado";
                }

                ?></p>
        </div>
    </div>
</body>

</html>