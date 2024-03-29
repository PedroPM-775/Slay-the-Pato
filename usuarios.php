<?php

//@ Proyecto por Pedro Pina Menéndez
//@ Esta es la pagina usada por los usuarios Adminstradores para gestionar partidas, usuarios, y crear usuarios

//@ En esta pagina está la unica manera de crear un usuario con el rol de administrador

include "DAO.class.php";
session_start();
unset($_SESSION['personaje']);
unset($_SESSION['enemigo']);
unset($_SESSION['ronda']);
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}
$usuario = unserialize($_SESSION['usuario']);
if (!$usuario->Admin()) {
    header("Location: perfil.php");
}

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
    include "menu.php";
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
            $ps = crypt($stringtrim, '$5$rounds=5000$usesomesillystringforsalt');
            array_push($introducir, $ps);

            $string = $_POST['email'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);

            $string = $_POST['username'];
            $stringtrim = ltrim($string);
            array_push($introducir, $stringtrim);

            $rol = $_POST['rol'];
            array_push($introducir, $rol);

            $objeto = new Usuario($introducir[0], $introducir[1], $introducir[2], $introducir[3], $introducir[4]);
            array_push($datos, $objeto);

            $DAO->escribirArrayUsuarios($datos);

            $progreso = new Progreso($_POST['username'], 1, 0, 0, 1, 0, 0, 0, 0);
            if ($rol == "Administrador") {
                $progreso->cuentaadmin();
            }
            var_dump($progreso);
            $arrayprogresos = $DAO->devolverArrayProgresos();
            array_push($arrayprogresos, $progreso);
            $DAO->escribirArrayProgresos($arrayprogresos);
        }

    ?>
        <table aria-describedby="Tabla rellena con datos de tablas.csv">
            <caption>Tabla de datos</caption>
            <tr>
                <th>Nombre</th>
                <th>Contraseña</th>
                <th>Correo</th>
                <th>UserName</th>
                <th>Rol</th>

            </tr>
            <?php


            //@ Usando un bucle for dentro de otro, imprimo todos los elementos del archivo en distintas filas de la tabla
            for ($i = 1; $i < count($datos); $i++) {
                $usuario = $datos[$i];
            ?>
                <tr>
                    <td><?php echo $usuario->getNombre(); ?></td>
                    <td><?php echo $usuario->getContrasena(); ?></td>
                    <td><?php echo $usuario->getCorreo(); ?></td>
                    <td><?php echo $usuario->getuserName(); ?></td>
                    <td><?php echo $usuario->getRol(); ?></td>
                    <?php echo "<td> <a href = 'borrarUsuario.php?fila=$i'>Eliminar</a> </td>"; ?>
                </tr>

            <?php
            }
            ?>

        </table>
        </br>
        <a href="usuarios.php"> Volver al formulario de registro</a>
    <?php


    }

    //@ Si hay errores o no se ha enviado, se imprime una lista de errores y el formulario

    else {

    ?>
        <h2>Listado de usuarios </h2>
        <br>
        <div id="contenedortabla">
            <table aria-describedby="Tabla rellena con datos de tablas.csv">
                <tr>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Correo</th>
                    <th>UserName</th>
                    <th>Rol</th>
                    <th>Eliminar</th>
                </tr>
                <?php


                //@ Usando un bucle for dentro de otro, imprimo todos los elementos del archivo en distintas filas de la tabla
                for ($i = 1; $i < count($datos); $i++) {
                    $usuario = $datos[$i];
                ?>
                    <tr>
                        <td><?php echo $usuario->getNombre(); ?></td>
                        <td><?php echo $usuario->getContrasena(); ?></td>
                        <td><?php echo $usuario->getCorreo(); ?></td>
                        <td><?php echo $usuario->getuserName(); ?></td>
                        <td><?php echo $usuario->getRol(); ?></td>
                        <?php echo "<td> <a href = 'borrarUsuario.php?fila=$i'>Eliminar</a> </td>"; ?>
                    </tr>

                <?php
                }

                $arraypartidas = $DAO->devolverArrayGuardados();

                ?>

            </table>



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

        <br>
        <h2>Crear nuevo Usuario</h2><br>
        <div id="contenedorform">
            <form name="usuarios" action='usuarios.php' method="post">
                <label> Nombre de Usuario </label> <input type="text" name="nome" value="<?php if (
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

                <label for="lang">Rol</label>
                <select name="rol" id="lang">
                    <option value="Usuario" <?php if (isset($_POST['rol']) && strcasecmp("Usuario", $_POST['rol'])) echo "selected"; ?>>Usuario</option>
                    <option value="Administrador" <?php if (isset($_POST['rol']) && strcasecmp("Administrador", $_POST['rol'])) echo "selected"; ?>>Administrador</option>
                </select> </br></br>

                <input type="submit" name='enviar' value="enviar" /></br></br>
                <input type="reset" name='reset' value="resetear" /></br></br>

            </form>
        </div>





        <h2>Historial de todas las partidas:</h2>
        <table id="tablapartidas" aria-describedby="Tabla rellena con datos de tablas.csv">
            <tr>
                <th>Personaje</th>
                <th>Enemigo</th>
                <th>Resultado</th>
                <th>Usuario</th>
                <th>ID de la partida</th>
                <th>Eliminar</th>
            </tr>
            <?php
            for ($i = 1; $i < count($arraypartidas); $i++) {
                $partida = $arraypartidas[$i];
            ?>
                <tr>
                    <td><?php echo $partida->getpersonaje(); ?></td>
                    <td><?php echo $partida->getenemigo(); ?></td>
                    <td><?php echo $partida->getresultado(); ?></td>
                    <td><?php echo $partida->getusuario(); ?></td>
                    <td><?php echo $partida->getid(); ?></td>
                    <?php echo "<td> <a href = 'borrarPartida.php?fila=$i'>Eliminar</a> </td>"; ?>
                </tr>
            <?php
            }


            ?>

        </table>
        <h2>Contenido desbloqueado por cada jugador: </h2>
        <table id="tablapartidas" aria-describedby="Tabla rellena con datos de tablas.csv">
            <tr>
                <th>Nombre</th>
                <th>Modo Facil</th>
                <th>Modo Normal</th>
                <th>Modo Dificil</th>
                <th>Foto de perfil 1</th>
                <th>Foto de perfil 2</th>
                <th>Foto de perfil 3</th>
                <th>Foto de perfil 4</th>
                <th>Foto de perfil 5</th>
            </tr>
            <?php

            $arrayprogreso = $DAO->devolverArrayProgresos();
            for ($i = 0; $i < count($arrayprogreso); $i++) {
                $progreso = $arrayprogreso[$i];
            ?>
                <tr>
                    <td><?php echo $progreso->getid(); ?></td>
                    <td>
                        <?php if ($progreso->desbloqueado(1)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(2)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(3)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(4)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(5)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(6)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(7)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                    <td>
                        <?php if ($progreso->desbloqueado(8)) {
                            echo "Desbloqueado";
                        } else {
                            echo "No Desbloqueado";
                        } ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }
    ?>
</body>

</html>