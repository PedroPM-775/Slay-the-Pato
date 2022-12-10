<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-In</title>
    <link rel="stylesheet" href="./CSS/hojalogin.css">
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


    if (isset($_POST['enviar'])) {

        if (!isset($_POST['nome'])) {
            array_push($errores, "nome");
        }

        if (isset($_POST['nome'])) {
            $nombre = $_POST['nome'];
            $nombretrim = ltrim($nombre);
            if (!preg_match("/^[a-zA-Z]+$/", $nombretrim)) {
                array_push($errores, "El nombre contiene caracteres no permitidos");
            }
        }

        if (!isset($_POST['contrasinal'])) {
            array_push($errores, "contrasinal");
        }

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

        if (!isset($_POST['email'])) {
            array_push($errores, "email");
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errores, "El formato de email no es correcto");
            }
        }

        if (!isset($_POST['username'])) {
            array_push($errores, "username");
        }

        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $nombretrim = ltrim($username);
            if (!preg_match("/^[a-zA-Z]+$/", $nombretrim)) {
                array_push($errores, "El nombre de usuario contiene caracteres no permitidos");
            }
        }

        for ($i = 0; $i < count($listanombres); $i++) {
            if ($_POST['username'] == $listanombres[$i]) {
                array_push($errores, "El nombre de usuario ya existe, elija otro");
            }
        }

        if (isset($_POST['enviar']) && count($errores) == 0) {

            $introducir = [];
            $string = $_POST['nome'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);

            $string = $_POST['contrasinal'];
            $stringtrim = ltrim($string);
            $ps = crypt($stringtrim, "DmGx5dZx");
            array_push($introducir, $ps);

            $string = $_POST['email'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);

            array_push($introducir, $areabuenatrim);
            $string = $_POST['username'];
            $stringtrim = ltrim($string);

            array_push($introducir, "Usuario");

            $objeto = new Usuario($introducir[0], $introducir[1], $introducir[2], $introducir[3], $introducir[4], $introducir[5]);
            array_push($datos, $objeto);

            $DAO->escribirArrayUsuarios($datos);
            header("Location: index.php");
        }
    }

    ?>

    <div id="contenedorform">
        <form name="usuarios" action='usuarios.php' method="post">
            <label> Nombre de Usuario </label> <input type="text" name="nome" value="<?php if (
                                                                                            isset($_POST['nome'])
                                                                                        ) echo $_POST['nome'] ?>" required /> </br></br>

            <label> Contraseña </label> <input type="password" name="contrasinal" value="<?php if (
                                                                                                isset($_POST['contrasinal'])
                                                                                            ) echo $_POST['contrasinal'] ?>" required /></br></br>

            <label> Confirme la Contraseña </label> <input type="password" name="contrasinalrep" value="<?php if (
                                                                                                            isset($_POST['contrasinalrep'])
                                                                                                        ) echo $_POST['contrasinalrep'] ?>" required /></br></br>

            <label> Correo Electronico </label> <input type="email" name="email" value="<?php if (
                                                                                            isset($_POST['email'])
                                                                                        ) echo $_POST['email'] ?>" required /></br></br>

            <label> Nombre de Usuario </label> <input type="text" name="username" value="<?php if (
                                                                                                isset($_POST['username'])
                                                                                            ) echo $_POST['username'] ?>" required /></br></br>
            <input type="submit" value="enviar" name="enviar">

        </form>
    </div>
</body>

</html>