<?php //liquidacion
if ($_GET['mes']) {

      switch ($_GET['mes']) {
        case '1':
        $fecha1 = date('Y-m-d',(time() - 60*60*24) - 60*60*24);
        $fecha2 = date('Y-m-d',(time() - 60*60*24) - 60*60*24);
        $arrayPedidos = $pedidoNegocio->mostrar($fecha1, $fecha2);
          break;
        case '2':
        $fecha1 = date('Y-m-d',time() - 60*60*24);
        $fecha2 = date('Y-m-d',time() - 60*60*24);
        $arrayPedidos = $pedidoNegocio->mostrar($fecha1, $fecha2);
          break;
        case '3':
        $fecha1 = date('Y-m-d');
        $fecha2 = date('Y-m-d');
        $arrayPedidos = $pedidoNegocio->mostrar($fecha1, $fecha2);
          break;
        case '4':
        $fecha1 = date('m');
        $arrayPedidos = $pedidoNegocio->mostrarMes($fecha1);

        $month = date('m');
        $year = date('Y');
        $fecha1 = date('Y-m-d', mktime(0,0,0, $month-1, 1, $year)); //primer dia del mes anterior

        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, date("m"), 0, date("Y")));
        $fecha2 = date("Y-m-d", mktime(0,0,0, $month-1, $day, $year)); // ultimo dia del mes anterior

        $arrayPedidos = $pedidoNegocio->mostrar($fecha1, $fecha2);
          break;
        case '5':

        $month = date('m');
        $year = date('Y');
        $fecha1 = date('Y-m-d', mktime(0,0,0, $month, 1, $year)); //primer dia del mes actual
  
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));
        $fecha2 = date('Y-m-d', mktime(0,0,0, $month, $day, $year)); //ultimo dia del mes actual


        $arrayPedidos = $pedidoNegocio->mostrar($fecha1, $fecha2);
          break;
        default:
          break;
    }


?>
    <div class="container">
            <div class="page-header">
                  <h1>Reporte de ganancias</h1>
            </div>
    <div id="reporte">
            <div class="row">
                <div class="col-md-6">
                  <p><strong>Per&iacute;odo:</strong> 
                    <?php 
if($_GET['mes'] == 1 || $_GET['mes'] == 2 || $_GET['mes'] == 3) {
  if($_GET['mes'] == 1) { $dia = '(Antes de ayer)'; } elseif ($_GET['mes'] == 2) { $dia = '(Ayer)'; } else { $dia = '(Hoy)'; } 
  echo Util::dbToDate($fecha1) . ' - ' .$dia;
} else {
  echo Util::dbToDate($fecha1) . ' a ' . Util::dbToDate($fecha2);
}        

  ?></p>
                </div>
                  <div class="col-md-6">
                    <p><strong>Cantidad de pedidos y ventas:</strong> <?php echo count($arrayPedidos); ?></p>
                    <p><strong>Total:</strong> $ <?php  $suma = 0;
                                                      if( count($arrayPedidos) > 0 ){
                                                        foreach( $arrayPedidos as $pedido ){
                                                        $suma += $pedido->getPrecio();
                                                      }
                                                    }
                                                      echo number_format($suma, 2);
                    ?></p>
                  </div>
                  </div>
<?php 
}else{
    Util::setMsj('Debe seleccionar valor','warning');
    header('Location:?modulo=cliente&accion=listar');
    die();
}
?>

                  </div>
                  </div>