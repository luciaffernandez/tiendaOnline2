<?php

error_reporting(0);

//Añadimos las clases
require_once "Smarty.class.php";
spl_autoload_register(function($clase) {
    include "$clase.php";
});

session_start();
//Creamos un objeto para gestionar plantillas
$smarty = new Smarty();

//Configuramos los directorios
$smarty->template_dir = "./template";
$smarty->compile_dir = "./template_c";

//cuando se pulse el boton enviar en el login
if (isset($_POST['enviar'])) {
    //recogemos los datos
    $nombre = $_POST['name'];
    $pass = $_POST['pass'];
    //establecemos conexion
    $conexion = new BD();
    //comprobamos los datos
    if ($conexion->comprueboUsuario($nombre, $pass)) {
        //si es true los guardamos en sesiones y pasamos al sitio.php
        $_SESSION['user'] = $nombre;
        $_SESSION['pass'] = $pass;
        header("Location:sitio.php");
        exit();
    } else {
        //si es false mostramos el mensaje de error y mostramos el login.tpl
        $error = "Datos incorrectos";
        $smarty->assign('error', $error);
        $smarty->display('login.tpl');
    }
} else {
    //cuando no se haya pulsado ningún boton
    $error = "";
    $smarty->assign('error', $error);

    //si se recibe un error por metodo GET (enviado desde el sitio)
    if (isset($_GET['error'])) {
        $error = "No has iniciado sesión";
    }
    $smarty->assign('error', $error);
    //Mostramos plantilla
    $smarty->display('login.tpl');
}
?>