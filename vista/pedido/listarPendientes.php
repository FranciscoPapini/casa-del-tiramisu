<?php // muestra los pedidos pendientes desde el dia de hoy
      $hoy = date('Y-m-d');
      $pedidoNegocio = new PedidoNegocio();
      $arrayPedidos = $pedidoNegocio->pendientes($hoy);
      require_once('negocio/clienteNegocio.php');
      $clienteNegocio = new ClienteNegocio();

      require_once('negocio/envioNegocio.php');
      $envioNegocio = new EnvioNegocio();
?>
    <div class="container" id="non-printable">
      <div class="page-header">
        <h1>Pedidos Pendientes</h1>
      </div>
    <div id="reportePedidos" id="printable">      
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="display: none;">Fecha a Ordenar</th>
            <th style="display: none;">Id</th>
            <th style="width:15%">Fecha</th>
            <th style="width:35%">Cliente</th>
            <th>Descripci&oacute;n</th>
            <th style="width:1%">Env&iacute;o</th>
            <th style="width:10%">Total</th>
            <th style="width:1%" align="center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if( count($arrayPedidos) > 0 ){
            foreach( $arrayPedidos as $pedido ){
          
                if($pedido->getIdCliente() == 1) {} else {

          ?>

              <tr>
                <td style="display: none;"><?php echo $pedido->getFecha();?></td>
                <td style="display: none;"><?php echo $pedido->getId();?></td>
                <td style="width:15%">
                  <?php
                    $d1= round(abs(strtotime($pedido->getFecha())-strtotime($hoy))/86400);
                    switch ($d1) {
                      case '0':
                        echo Util::DbToDate($pedido->getFecha()) . ' (hoy)';                      
                        break;
                      case '1':
                        echo Util::DbToDate($pedido->getFecha()) . ' (ma&ntilde;ana)';
                        break;                      
                      default:
                        echo Util::DbToDate($pedido->getFecha()) . ' (' . $d1 . ' d&iacute;as)';
                        break;
                    }
                  ?>
                </td>
                  <td style="width:35%">
                    <?php
                      $cliente = $clienteNegocio->recuperar($pedido->getIdCliente());
                      $nombre = ucwords($cliente->getNombre());
                      if($pedido->getEnvio() == 1) { echo $nombre . ' - ' . ucwords($pedido->getDireccion()); } else { echo $nombre; }
                      ?>
                  </td>
                <td><?php if($pedido->getDescripcion() == '0') { echo ''; } else { echo ucfirst($pedido->getDescripcion()); }?></td>
                <td style="width:1%"><?php if($pedido->getEnvio() == 1) { echo 'Si'; } else { echo 'No'; }?></td>
                <td style="width:10%">$ <?php echo $pedido->getPrecio(); ?></td>
                <td style="width:1%">
                  <a href="?modulo=pedido&accion=editar&id=<?php echo $pedido->getId();?>&id_cliente=<?php echo $cliente->getId(); ?>" data-toggle="tooltip" title="Editar Pedido"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  
                  <a href="?modulo=pedido&accion=eliminar&id=<?php echo $pedido->getId();?>&id_cliente=<?php echo $cliente->getId(); ?>" data-toggle="tooltip" title="Eliminar Pedido"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;
                  
                  <a href="?modulo=pedido&accion=consultar&id=<?php echo $pedido->getId();?>" class="btnConsultar" data-toggle="tooltip" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  
                  <a href="?modulo=pedido&accion=reporte&id=<?php echo $pedido->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>               
                </td>
              </tr>
          <?php
            }
          }
          }else{
          ?>
          <tr>
            <td colspan="8">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    </div>    