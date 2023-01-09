<?php

//@ Proyecto por Pedro Pina Menéndez


include "DAO.class.php";
session_start();
//@ Comprobase que o usuario se autenticou
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}
unset($_SESSION['personaje']);
unset($_SESSION['enemigo']);
unset($_SESSION['ronda']);
$usuario = $_SESSION['usuario'];
$errores = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

    //  include "menu.php";

    $tamano = "14";
    //@ Codigo en caso de venir desde modificar
    if (isset($_POST['modificar'])) {

        //@ Codigo para cambiar las preferencias, primero las valida
        if (!empty($_POST['tamano'])) {
            if (isset($_POST['tamano'])) {
                $numero = trim($_POST['tamano']);
                if (!preg_match('/^[0-9]+$/', $numero)) {
                    array_push($errores, "El formato del tamaño de fuente no es correcto, solo debe tener numeros");
                }
            }
        }
        if (!isset($_POST['tema'])) {

            array_push($errores, "Falta el tema");
        }
        if (!isset($_POST['fuente'])) {

            array_push($errores, "Falta la fuente");
        }
        //@ Escribo los datos en la cookie si no hay errores
        if (count($errores) == 0) {
            unset($_COOKIE['tamano']);
            unset($_COOKIE['tema']);
            unset($_COOKIE['fuente']);
            if (empty($_POST['tamano'])) {
                setcookie('tamano', '14');
            } else {
                setcookie('tamano', $_POST['tamano']);
            }
            setCookie("tema", $_POST['tema']);
            setCookie("fuente", $_POST['fuente']);
        }
    }
    //@ Codigo para resetear las preferencias a por defecto
    else if (isset($_POST['defecto'])) {
        unset($_COOKIE['tamano']);
        unset($_COOKIE['tema']);
        unset($_COOKIE['fuente']);
        setcookie('tamano', '14');
        setCookie("tema", 'Clara');
        setCookie("fuente", 'calibri');
    }

    ?>
    <link rel="stylesheet" href="./CSS/hoja<?php
                                            if (isset($_POST['modificar'])) {
                                                echo $_POST['tema'];
                                            } else if (isset($_POST['defecto'])) {
                                                echo $_POST['tema'];
                                            } else if (isset($_COOKIE['tema'])) {
                                                echo $_COOKIE['tema'];
                                            } else {
                                                echo "Clara";
                                            } ?>.css">


    <style>
        body {
            font-size: <?php
                        if (isset($_POST['modificar'])) {
                            echo $_POST['tamano'];
                        } else if (isset($_POST['defecto'])) {
                            echo $_POST['tamano'];
                        } else if (isset($_COOKIE['tamano'])) {
                            echo $_COOKIE['tamano'];
                        } else {
                            echo "14";
                        } ?>px;
            font-family: <?php
                            if (isset($_POST['modificar'])) {
                                echo $_POST['fuente'];
                            } else if (isset($_POST['defecto'])) {
                                echo $_POST['fuente'];
                            } else if (isset($_COOKIE['fuente'])) {
                                echo $_COOKIE['fuente'];
                            } else {
                                echo "calibri";
                            } ?>;
        }
    </style>
    <title>Perfil</title>
</head>

<body>

    <div id="contenedorform">
        <form action="perfil.php" method="post" enctype="multipart/form-data">
            <?php
            $usuario = unserialize($_SESSION['usuario']);
            $DAO = new DAO();
            $arraypartidas = $DAO->devolverArrayGuardados();
            $arrayconcreto = array();

            for ($i = 0; $i < count($arraypartidas); $i++) {
                $objeto = $arraypartidas[$i];
                if ($objeto->getusuario() == $usuario->getuserName()) {
                    array_push($arrayconcreto, $objeto);
                }
            }
            echo "a <br>";

            $arrayprogreso = $DAO->devolverArrayProgresos();
            $arrayconcretoprogreso = array();

            for ($i = 0; $i < count($arrayprogreso); $i++) {
                $objeto = $arrayprogreso[$i];
                echo $objeto->getid();
                echo "a <br>";
                if ($objeto->getid() == $usuario->getuserName()) {
                    array_push($arrayconcretoprogreso, $objeto);
                }
            }
            echo "a <br>";
            var_dump($arrayconcretoprogreso);
            echo "a";
            ?>

            <h4>Elige tu foto de perfil </h4>
            <select name="cosa">
                <?php

                if ($perfil->getdesbloqueo(4) == 'y') { ?>
                    <option value='a'>1</option> <?php
                                                } else {
                                                    echo "a";
                                                }
                                                if ($perfil->getdesbloqueo(5) == 'y') {
                                                    echo "<option value='e' >2</option>";
                                                }
                                                if ($perfil->getdesbloqueo(6) == 'y') {
                                                    echo "<option value='i' >3</option>";
                                                }
                                                if ($perfil->getdesbloqueo(7) == 'y') {
                                                    echo "<option value='o' >4</option>";
                                                }
                                                if ($perfil->getdesbloqueo(8) == 'y') {
                                                    echo "<option value='u'  >5</option>";
                                                }


                                                    ?>
            </select>
            <br>
            <br>

            <h4>Aqui tienes tus opciones de personalizacion gráfica </h4>
            <label for="lang">Tema de la pagina:</label>
            <select name="tema" id="lang">
                <option value="Clara">Claro</option>
                <option value="Oscura">Oscuro</option>
            </select> </br></br>

            <label for="tamano">Tamaño de letra</label>
            <input type="number" id="tamano" name="tamano" /><br> <br>
            <label for="lang">Fuente</label>
            <select name="fuente" id="lang">
                <option value="calibri">Calibri</option>
                <option value="arial">Arial</option>
            </select>
            <input type="submit" name="modificar" value="modificar">
            <input type="submit" name="defecto" value="defecto">
            <br><br>

        </form>
    </div>


    <h3>Historial de todas las partidas:</h3>
    <table id="tablapartidas" aria-describedby="Tabla rellena con datos de tablas.csv">
        <tr>
            <th>Personaje</th>
            <th>Enemigo</th>
            <th>Resultado</th>
            <th>Usuario</th>
        </tr>
        <?php
        for ($i = 0; $i < count($arrayconcreto); $i++) {
            $partida = $arrayconcreto[$i];
        ?>
            <tr>
                <td><?php echo $partida->getpersonaje(); ?></td>
                <td><?php echo $partida->getenemigo(); ?></td>
                <td><?php echo $partida->getresultado(); ?></td>
                <td><?php echo $partida->getusuario(); ?></td>
            </tr>


        <?php
        }

        ?>

</body>

</html>