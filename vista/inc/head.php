<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiramis&uacute; - <?php echo ucfirst($modulo); ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-default" role="navigation">
      <div class="container">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?modulo=cliente&accion=buscar" tabindex = "-1">LCT</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex = "-1">Clientes <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=cliente&accion=buscar"><span class="glyphicon glyphicon-search"></span> Buscar Cliente</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=cliente&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Clientes</a></li>
                <li><a href="?modulo=cliente&accion=editar"><span class="glyphicon glyphicon-plus"></span> Agregar Cliente</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex = "-1">Productos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=producto&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Productos</a></li>
                <li><a href="?modulo=producto&accion=editar"><span class="glyphicon glyphicon-plus"></span> Agregar Producto</a></li>
              </ul>
            </li>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex = "-1">Liquidaci&oacute;n <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=pedido&accion=liquidar&mes=1" class="btnLiquidacion" data-toggle="tooltip"><span class="glyphicon glyphicon-asterisk"></span> Antes de Ayer</a></li>
                <li><a href="?modulo=pedido&accion=liquidar&mes=2" class="btnLiquidacion" data-toggle="tooltip"><span class="glyphicon glyphicon-asterisk"></span> Ayer</a></li>
                <li><a href="?modulo=pedido&accion=liquidar&mes=3" class="btnLiquidacion" data-toggle="tooltip"><span class="glyphicon glyphicon-asterisk"></span> Hoy</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=pedido&accion=liquidar&mes=4" class="btnLiquidacion" data-toggle="tooltip"><span class="glyphicon glyphicon-asterisk"></span> Mes Anterior</a></li>
                <li><a href="?modulo=pedido&accion=liquidar&mes=5" class="btnLiquidacion" data-toggle="tooltip"><span class="glyphicon glyphicon-asterisk"></span> Mes Actual</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex = "-1">Ventas <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=pedido&accion=listar&id_cliente=1"><span class="glyphicon glyphicon-list"></span> Listar Ventas</a></li>
                <li><a href="?modulo=pedido&accion=generar"><span class="glyphicon glyphicon-plus"></span> Agregar Venta</a></li>
              </ul>
            </li>
            </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex = "-1">Opciones <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=pedido&accion=listarPendientes" tabindex="-1"><span class="glyphicon glyphicon-list"></span> Pedidos Pendientes</a></li>
                <li class="divider"></li>
          <?php
          if($_SESSION['encargado']['id'] == 1){
          ?>                
                <li><a href="?modulo=encargado&accion=listar"><span class="glyphicon glyphicon-list"></span> Listar Encargados</a></li>
                <li><a href="?modulo=encargado&accion=editar"><span class="glyphicon glyphicon-plus"></span> Agregar Encargado</a></li>
                <li class="divider"></li>
          <?php
          }
          ?>
                <li><a href="?modulo=encargado&accion=editar&id=<?php echo $_SESSION['encargado']['id']; ?>"><span class="glyphicon glyphicon-pencil"></span> Editar Datos</a></li>
                <li class="divider"></li>
                <li><a href="?modulo=envio&accion=editar"><span class="glyphicon glyphicon-pencil"></span> Actualizar Envio</a></li>

          </ul>
            </li>
            <li><a href="index.php?action=logout" tabindex = "-1">Salir</a></li>
          </ul>
          <p class="navbar-text navbar-right" tabindex = "-1">Hola <strong><?php echo ucwords($_SESSION['encargado']['nombre']); ?></strong>!</p>
        </div><!--/.nav-collapse -->
      </div>
    </div><!-- /navbar -->
