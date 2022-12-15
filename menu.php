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
        <p><?php
            if (isset($_SESSION['usuario'])) {
                $a = unserialize($_SESSION['usuario']);
                echo $a->getuserName();
            } else {
                echo "Usuario no registrado";
            }

            ?></p>

    </div>
</body>

</html>