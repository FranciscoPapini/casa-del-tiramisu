<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once('util/util.php');

if($_POST['user'] && $_POST['pass']){
    /*Login*/
    require_once('negocio/encargadoNegocio.php');
    $encargadoNegocio = new EncargadoNegocio();
    $enc = $encargadoNegocio->login($_POST['user'], $_POST['pass']);
    if($enc){
        $_SESSION['encargado']['id'] = $enc->getId();
        $_SESSION['encargado']['nombre'] = $enc->getNombre();
        $_SESSION['encargado']['usuario'] = $enc->getUsuario();
        $_SESSION['encargado']['email'] = $enc->getEmail();
        header('Location: ?modulo=cliente&accion=buscar');
        die();
    }else{
        Util::setMsj('Usuario o contraseña incorrectos','danger', false);
        header('Location: login.php');
        die();
    }
}elseif($_GET['action'] == 'logout'){
    unset($_SESSION['encargado']);
    Util::setMsj('Has cerrado sesión','info', false);
    header('Location: login.php');
    die();
}

if($_SESSION['encargado']){
    $modulo = $_GET['modulo']? $_GET['modulo'] : 'cliente';
    $accion = $_GET['accion']? $_GET['accion'] : 'buscar';
    
    /*Clase Negocio*/
    require_once('negocio/'.$modulo.'Negocio.php');

    $nombreNegocio = $modulo."Negocio";
    $$nombreNegocio = new $nombreNegocio();

    /*Proceso de formularios*/
    if($_POST){
        switch ($accion) {
            case 'editar':
                $$nombreNegocio->guardar();
                break;
            case 'eliminar':
                $$nombreNegocio->eliminar();
                break;
            case 'buscar':
                $$nombreNegocio->buscar();
                break;               
            case 'generar':
                $$nombreNegocio->guardarVenta();
                break;
            case 'consultar':
                break;
            case 'liquidar':
                break;
            case 'mostrar':
                break;            
            default:
                $accion = 'buscar';
                break;
        }
    }


    if ($accion == 'reporte' || $accion == 'reporteVenta')
    {
    require_once('vista/'.$modulo.'/'.$accion.'.php');
    } else {
    require_once('vista/inc/head.php');
    require_once('vista/'.$modulo.'/'.$accion.'.php');
    require_once('vista/inc/foot.php'); 
    }


}else{
    header('Location: login.php');
    die();
}
?>