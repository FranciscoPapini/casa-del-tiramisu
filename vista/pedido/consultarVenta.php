<?php
if($_GET['id']) {
      $pedido = $pedidoNegocio->recuperar($_GET['id']);
      $itemsPedido = $pedido->getItemsPedido();
      require_once('negocio/encargadoNegocio.php');
      $encargadoNegocio = new EncargadoNegocio();
      $encargado = $encargadoNegocio->recuperar($pedido->getIdEncargado());
      require_once('negocio/productoNegocio.php');
      $productoNegocio = new ProductoNegocio();
      require_once('negocio/envioNegocio.php');
      $envioNegocio = new EnvioNegocio();
      $fecha = Util::dbToDate($pedido->getFecha());
      $envio = $envioNegocio->recuperar($fecha);

?>
    <div class="container" id="non-printable">
            <div class="page-header">
                  <h1>Reporte de venta</h1>
            </div>
    <div id="reporte" id="printable">
            <div class="row">
                <div class="col-md-6">
                  <p><strong>Fecha de Venta:</strong> <?php echo Util::dbToDate($pedido->getFecha()); ?></p>
                </div>
                  <div class="col-md-6">
                  <p><strong>Encargado:</strong> <?php echo ucwords($encargado->getApellido()).', '.ucwords($encargado->getNombre()); ?></p>
                  </div>
              </div>

<?php
    

      if( count($itemsPedido) > 0 ){
?>
        <div class="form-group">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th style="width:25%">Producto</th>
              <th style="width:1%">Cantidad</th>
              <th style="width:20%">Observaci&oacute;n</th>
              <th style="width:15%">Precio Sugerido</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            foreach ($itemsPedido as $item) {
          ?>
              <tr>
                <td>
                   <?php 
                       echo ucwords($productoNegocio->recuperar($item['id_producto'])->getNombre()) . ' ' . ucfirst($productoNegocio->recuperar($item['id_producto'])->getDescripcion()); 
                   ?>
                </td>
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
              <td colspan="3"><strong>Precio Total:</strong></td>
              <td><strong>$ <?php echo $pedido->getPrecio(); ?></strong></td>
            </tr>
          </tfoot>           
        </table>
                </div>
<?php
    }else{
?>
        <hr>
        <h5>No se agregaron productos</h5>
        <hr>
<?php
      }
    }else{
    Util::setMsj('Debe seleccionar un pedido','warning');
    header('Location: ?modulo=pedido&accion=listar');
    die();
    }
?>
    </div>
    </div>


