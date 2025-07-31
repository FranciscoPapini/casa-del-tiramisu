<?php // no esta en uso, muestra los pedidos pendientes segun hoy.
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

          <?php
          if( count($arrayPedidos) > 0 ){
            foreach( $arrayPedidos as $pedido ){
          ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
        <th style="width:35%">Fecha</th>
        <th>Cliente</th>
        <th>Env&iacute;o</th>
     </tr>
  </thead>
      <tbody>
          <tr>
              <td style="width:35%">
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
              <td>
                  <?php
                      $cliente = $clienteNegocio->recuperar($pedido->getIdCliente());
                      $nombre = ucwords($cliente->getNombre()).' ('.$cliente->getTelefono().')'; 
                      if($pedido->getEnvio() == 1) { echo $nombre . ' - ' . ucwords($pedido->getDireccion()); } else { echo $nombre; }
                  ?>
              </td>
              <td>
                  <?php
                      if($pedido->getEnvio() == 1){
                        echo 'Si';
                      }
                      else{
                        echo 'No';
                      }
                  ?>                
              </td>
          </tr>

<tr>
  

                <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th style="width:25%">Producto</th>
                            <th style="width:1%">Cantidad</th>
                            <th style="width:20%">Observaci&oacute;n</th>
                            <th style="width:8%">Precio Sugerido</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          $fecha = Util::dbToDate($pedido->getFecha());
                          $envio = $envioNegocio->recuperar($fecha);

                            $itemsPedido = $pedido->getItemsPedido();

                            foreach( $itemsPedido as $item ){
                          ?>
                              <tr>
                                <td><?php echo ucwords($productoNegocio->recuperar($item['id_producto'])->getNombre()) . ' ' . ucfirst($productoNegocio->recuperar($item['id_producto'])->getDescripcion());?></td>
                                <td><?php echo $item['cantidad'];?></td>
                                <td><?php echo ucfirst($item['observacion']);?></td>
                                <td>$ <?php echo $item['precioSugerido'];?></td>
                              </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                    <tfoot>
            <tr>
              <?php 
                  if($pedido->getEnvio() == 1) {
                    $precio_envio = $envio->getPrecio();
              ?>
                  <td colspan="3">Envio:</td> 
                  <td>$ <?php echo number_format($precio_envio, 2); ?></td>
            <?php 
              }
            ?>
            </tr>                    
                    <tr>
                      <td colspan="3"><strong>Precio Total:</strong></td>
                      <td><strong>$ <?php echo $pedido->getPrecio(); ?></strong></td>
                    </tr>
                    </tfoot>
                    </table>

</tr>
        </tbody>
      </table>
          <?php
            }
          }else{

          }

          ?>


<hr>
            <button type="button" onclick="window.close();" class="btn btn-default btn-block">Cerrar Ventana</button>
    </div>