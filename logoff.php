<?php

//@ Proyecto por Pedro Pina Menéndez


//@ Destruyo la sesion y reenvio a la pagina login.php para que se vuelvan a identificar
session_start();
session_destroy();
header("Location: login.php");
