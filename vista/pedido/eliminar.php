    <?php
    if ($_GET['id']) {
        require_once('negocio/productoNegocio.php');
        $productoNegocio = new ProductoNegocio();
        $pedido = $pedidoNegocio->recuperar($_GET['id']);

        require_once('negocio/clienteNegocio.php');
        $clienteNegocio = new ClienteNegocio();
        $cliente = $clienteNegocio->recuperar($pedido->getIdCliente());

        require_once('negocio/envioNegocio.php');
        $envioNegocio = new EnvioNegocio();
        $fecha = Util::dbToDate($pedido->getFecha());
        $envio = $envioNegocio->recuperar($fecha);
      
    if($cliente->getId() == 1) { $accion = 'la siguiente venta'; } else { $accion = 'el siguiente pedido'; }

    Util::setMsj('Est&aacute; a punto de eliminar '.$accion,'warning',false);
    ?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Eliminar <?php if($cliente->getId() == 1) { echo 'Venta'; } else { echo 'Pedido'; } ?></h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $pedido->getId();?>" >
            <input type="hidden" name="id_cliente" value="<?php echo $_GET['id_cliente'];?>" >
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" class="form-control" id="fecha" name="fecha" readonly placeholder="Fecha" value="<?php echo  Util::dbToDate($pedido->getFecha());?>" >
            
            </div>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" readonly placeholder="Descripci&oacute;n" value="<?php if($pedido->getDescripcion() == '0') { echo '-'; } else { echo ucfirst($pedido->getDescripcion()); } ?>" >
            </div>            
            <div class="form-group">
                <table class="table table-striped table-bordered" id="tblProductos">
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
                </div>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>


        <?php 
        }else{
            Util::setMsj('Debe seleccionar un pedido','warning');
            header('Location: ?modulo=cliente&accion=listar');
            die();
             }    
        ?> 
    </div>