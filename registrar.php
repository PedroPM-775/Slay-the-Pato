<?php
// Recupérase a información da sesión
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
}


// Comprobase que o usuario se autenticou
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
</head>

<body>
    <?php
    include "DAO.class.php";
    $DAO = new DAO();
    $datos = $DAO->devolverArrayUsuarios();
    $errores = array();
    $listanombres = array();
    for ($i = 1; $i < count($datos); $i++) {
        array_push($listanombres, $datos[$i]->getuserName());
    }
    //! Funcion para validar el formulario

    if (isset($_POST['enviar'])) {
        //@ Codigo para comprobar si el formulario tiene errores y si ha sido enviado o si se ha accedido a la pagina
        if (!isset($_POST['nome'])) {
            array_push($errores, "nome");
        }
        echo "a";
        echo "<br>";
        if (isset($_POST['nome'])) {
            $nombre = $_POST['nome'];
            $nombretrim = trim($nombre);
            if (!preg_match("/^[a-zA-Z]+$/", $nombretrim)) {
                array_push($errores, "El nombre contiene caracteres no permitidos");
            }
        }
        echo "b";
        echo "<br>";
        if (!isset($_POST['contrasinal'])) {
            array_push($errores, "contrasinal");
        }
        echo "c";
        echo "<br>";
        if (isset($_POST['contrasinal'])) {
            $contrasena = $_POST['contrasinal'];
            if (strlen($contrasena) > 8) {
                if (!preg_match('/[a-zA-Z0-9]+$/', $contrasena)) {
                    array_push($errores, "El formato de la contraseña no es correcto, no debe contener simbolos extraños");
                }
            } else {
                array_push($errores, "La contraseña es del tamaño incorrecto, debe de ser de al menos 8 cifras");
            }
        }
        echo "d";
        echo "<br>";
        if (!isset($_POST['email'])) {
            array_push($errores, "email");
        }
        echo "e";
        echo "<br>";
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errores, "El formato de email no es correcto");
            }
        }
        echo "f";
        echo "<br>";
        if (!isset($_POST['username'])) {
            array_push($errores, "username");
        }
        echo "g";
        echo "<br>";
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $nombretrim = ltrim($username);
            if (!preg_match("/^[a-zA-Z]+$/", $nombretrim)) {
                array_push($errores, "El nombre de usuario contiene caracteres no permitidos");
            }
        }
        echo "h";
        echo "<br>";
        for ($i = 0; $i < count($listanombres); $i++) {
            if ($_POST['username'] == $listanombres[$i]) {
                array_push($errores, "El nombre de usuario ya existe, elija otro");
            }
        }
        echo "i";
        echo "<br>";
        var_dump($errores);
        if (isset($_POST['enviar']) && count($errores) == 0) {
            echo "j";
            echo "<br>";
            $introducir = [];
            $string = $_POST['nome'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);
            echo "k";
            echo "<br>";
            $string = $_POST['contrasinal'];
            $stringtrim = ltrim($string);
            $ps = crypt($stringtrim, '$5$rounds=5000$usesomesillystringforsalt');
            array_push($introducir, $ps);
            echo "l";
            echo "<br>";
            $string = $_POST['email'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);
            echo "m";
            echo "<br>";
            $string = $_POST['username'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);
            array_push($introducir, "Usuario");
            echo "n";
            echo "<br>";
            $objeto = new Usuario($introducir[0], $introducir[1], $introducir[2], $introducir[3], $introducir[4]);
            array_push($datos, $objeto);

            $DAO->escribirArrayUsuarios($datos);
            session_start();
            $_SESSION['usuario'] = serialize($objeto);
            echo "j";
            echo "<br>";
            header("Location: index.php");
        }
    }
    //@ Si hay errores o no se ha enviado, se imprime una lista de errores y el formulario

    else {

    ?>
        </div>
        <br>
        <?php
        if (count($errores) != 0) {
            echo "<div id='caja'>";
            echo "<h1>Faltan los siguientes datos.</h1>";
            for ($i = 0; $i < count($errores); $i++) {
                echo $errores[$i];
                echo "</br>";
            }
            echo "</div>";
        }
        ?>

        <br> <br>
        <div id="contenedorform">
            <h1>¡REGISTRATE!</h1>
            <form name="usuarios" action='registrar.php' method="post">
                <label> Nombre </label> <input type="text" name="nome" value="<?php if (
                                                                                    isset($_POST['nome'])
                                                                                ) echo $_POST['nome'] ?>" required /> </br></br>

                <label> Contraseña </label> <input type="password" name="contrasinal" value="<?php if (
                                                                                                    isset($_POST['contrasinal'])
                                                                                                ) echo $_POST['contrasinal'] ?>" required /></br></br>

                <label> Correo Electronico </label> <input type="email" name="email" value="<?php if (
                                                                                                isset($_POST['email'])
                                                                                            ) echo $_POST['email'] ?>" required /></br></br>

                <label> Nombre de Usuario </label> <input type="text" name="username" value="<?php if (
                                                                                                    isset($_POST['username'])
                                                                                                ) echo $_POST['username'] ?>" required /></br></br>

                <input type="submit" name='enviar' value="enviar" /></br></br>

            </form>
        </div>
    <?php
    }
    ?>
</body>

</html>