<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require_once('util/util.php');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiramis&uacute; - Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="login">


    <div class="container">


      <form class="form-signin" action="index.php" method="post" role="form">
        <h2 class="form-signin-heading">Tiramis&uacute;</h2>
        <input type="text" class="form-control" placeholder="Usuario" name="user" required autofocus>
        <input type="password" class="form-control" placeholder="Contrase&ntilde;a" name="pass" required>
        <!--
        <p><a href="#"> Olvid&eacute; mi contrase&ntilde;a</a></p>
        -->
        <p><?php echo Util::getMsj(); ?></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>

    </div><!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>