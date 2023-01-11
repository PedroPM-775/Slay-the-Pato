<?php

//@ Proyecto por Pedro Pina Menéndez
//@ Esta es la pagina que se usa para iniciar sesión.

include "DAO.class.php";

//@ Borro la sesion ya existente si existe alguna.
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/hojalogin.css">
</head>

<body>

    <?php
    $DAO = new DAO();
    $datos = $DAO->devolverArrayUsuarios();
    $encontrado = false;

    //@ Compruebo si los datos del formulario de inicio de sesion estan en la base de datos
    if (isset($_POST['enviar'])) {

        $valido = true;

        if (isset($_POST['nome'])) {
            $nombre = $_POST['nome'];
            $nombretrim = trim($nombre);
            if (!preg_match("/^[a-zA-Z]+$/", $nombretrim)) {
                $valido = false;
            }
        }

        if (isset($_POST['contrasinal'])) {
            $contrasena = $_POST['contrasinal'];
            $nombretrim = trim($nombre);
            if (!preg_match('/[a-zA-Z0-9]+$/', $nombretrim)) {
                $valido = false;
            }
        }


        //@ Despues de comprobar que todos los caracteres son validos, el programa comprueba si 
        //@ los datos estan en la base de datos
        if ($valido) {
            $loop = false;
            $numfila;
            $nombre = trim($_POST['nome']);
            $password = trim($_POST['contrasinal']);
            $ps = crypt($password, '$5$rounds=5000$usesomesillystringforsalt');
            while (!$loop) {
                for ($i = 1; $i < count($datos); $i++) {
                    if (hash_equals($nombre, $datos[$i]->getuserName())) {
                        if (hash_equals($ps, $datos[$i]->getContrasena())) {
                            $encontrado = true;
                            $loop = true;
                            $numfila = $i;
                        }
                    }
                }
                $loop = true;
            }
        }
    }
    //@ Si los datos están en la base de datos, el programa inicia sesion y te conduce a una pagina u otra 
    //@ dependiendo de si eres usuario normal o administrador
    if ($encontrado) {
        $usuario = $datos[$numfila];

        session_start();
        $_SESSION['usuario'] = serialize($usuario);
        if ($usuario->Admin()) {
            header("Location: usuarios.php");
        } else {
            header("Location: index.php");
        }
    }
    //@ Si no esta en la base de datos devuelve este error y vuelve a pedir datos
    else if (isset($_POST['enviar'])) {
        echo "<div id='contenedorerror'> 

        <p>Error, los datos introducidos no corresponden con la base de datos, por favor intentelo de nuevo </p>

        </div>";
        echo "<br>";
    }


    ?>


    <div id="fondo">
        <div id="contenedor">
            <form action="login.php" method="post" id="formulario">
                <p> Nombre de usuario: </p>
                <input type="text" name="nome" id="nome">
                <br> <br>
                <p> Contraseña </p>
                <input type="password" name="contrasinal" id="contrasinal">
                <br> <br>
                <button id="enviar" name="enviar" type="submit">LogIn</button>
                <br>
                <!-- //@ Este enlace te lleva a la pagina de registro, para que te crees cuenta en caso de no tenerla -->
                <a href="registrar.php">¿No tienes cuenta? Registrate</a>
            </form>
        </div>
    </div>
</body>


</html>