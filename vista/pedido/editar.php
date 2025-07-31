    <?php
    if ($_GET['id']) {
        $pedido = $pedidoNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
        $fecha = Util::dbToDate($pedido->getFecha());
    }else{
        $pedido = new Pedido();
        $txtAction = 'Agregar';
        $fecha = date('d/m/Y');
    }

    require_once('negocio/productoNegocio.php');
    $productoNegocio = new ProductoNegocio();
    $arrayProductos = $productoNegocio->listar();

    require_once('negocio/precioNegocio.php');
    $precioNegocio = new PrecioNegocio();

    require_once('negocio/clienteNegocio.php');
    $clienteNegocio = new ClienteNegocio();
    $cliente = $clienteNegocio->recuperar($_GET['id_cliente']);

    require_once('negocio/envioNegocio.php');
    $envioNegocio = new EnvioNegocio();
    $envio = $envioNegocio->recuperar($fecha);

    ?>
    <div class="container" id="non-printable">
    <ol class="breadcrumb">
        <li class="active"><?php echo ucwords($cliente->getNombre()); ?></li>
      </ol>
      <div class="page-header" id="non-printable">
        <h1><?php echo $txtAction; if($cliente->getId() == 1) { echo ' Venta'; } else { echo ' Pedido'; } ?> </h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $pedido->getId();?>" >
            <input type="hidden" name="id_cliente" value="<?php echo $_GET['id_cliente'];?>" >
            <input type="hidden" name="precio" value="" >
            <input type="hidden" name="venta" value="">
            <div class="form-group">
                <label for="fecha">Fecha de <?php if($cliente->getId() == 1) { echo 'venta'; } else { echo 'pedido'; } ?></label>
                <p class="help-block">Formato dd/mm/yyyy.</p>
                <input type="text" class="form-control datepicker" id="fecha" name="fecha" placeholder="dd/mm/yyyy" value="<?php echo $fecha;?>" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" required>
                <div class="help-block with-errors"></div>
            </div>



            <h2>Productos
                            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModal">
                              Nuevo Producto
                            </button>
            </h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_producto">Producto</label>
                        <select class="form-control" id="id_producto" name="id_producto">
                            <option value="">Seleccione un producto</option>
                            <?php
                            foreach ($arrayProductos as $producto) {
                                echo '<option value="'. $producto->getId() .'" ';
                                $precio = $precioNegocio->recuperar($producto->getId(), $fecha);
                                echo 'data-precio="'. $precio->getValor() . '" ';
                                echo '>' . ucwords($producto->getNombre()) . ' ' . ucfirst($producto->getDescripcion()) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" step="0.1" class="form-control" name="cantidad" id="cantidad" value="1" required> </input>
                    <div class="help-block with-errors"></div>
                    </div>                    
                    <div class="form-group">
                        <label for="observacion">Observaci&oacute;n</label>
                        <input type="text" class="form-control" name="observacion" id="observacion" value="" placeholder="Observaci&oacute;n"></input>
                    <div class="help-block with-errors"></div>
                    </div> 
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-block" id="btnAgregarProducto">Añadir Producto</button>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-bordered" id="tblProductos">
                        <thead>
                          <tr>
                            <th style="width:25%">Producto</th>
                            <th style="width:20%">Observaci&oacute;n</th>
                            <th style="width:1%">Cantidad</th>
                            <th style="width:15%">Precio Sugerido</th>
                            <th style="width:1%">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if($_GET['id'])
                            {
                            $itemsPedido = $pedido->getItemsPedido();
                            foreach( $itemsPedido as $item ){
                          ?>
                              <tr>
                                <td>
                                    <?php 
                                        echo ucwords($productoNegocio->recuperar($item['id_producto'])->getNombre()) . ' ' . ucfirst($productoNegocio->recuperar($item['id_producto'])->getDescripcion()); 
                                        echo '<input name="productos[]" type="hidden" value="'.$item['id_producto'].'">';
                                        echo '<textarea name="observaciones[]" class="hidden">'.ucfirst($item['observacion']).'</textarea>';
                                        echo '<input name="cantidades[]" type="hidden" value="'.$item['cantidad'].'">';
                                        echo '<input name="preciosSugeridos[]" type="hidden" value="'.$item['precioSugerido'].'">';
                                    ?>
                                </td>
                                <td><?php echo ucfirst($item['observacion']);?></td>
                                <td><?php echo $item['cantidad'];?></td>
                                <td>$ <?php echo $item['precioSugerido'];?></td>
                                <td>
                                  <a href="#" title="Eliminar Pedido" class="removeItemProducto"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
                              </tr>
                          <?php
                            }
                        }
                          ?>
                        </tbody>
                    </table>
                </div>
            </div>
<hr>
<?php if($cliente->getId() == 1) { } else { ?>
            <div class="form-group">
          <div class="col-auto">
            <label for="envio">
              <input type="checkbox" id="envio" name="envio" <?php if($pedido->getEnvio() == 1) { echo 'checked'; } ?>> Envio
            </label>
              <p class="help-block">(Seleccione esta opci&oacute;n si debe enviar el pedido)</p>
          </div>
          </div>

              <input type="hidden" id="precioenvio" name="precioenvio" value="<?php echo $envio->getPrecio(); ?>">

            <div class="form-group" id="direcc" name="direcc" <?php if($_GET['id']) { if ($pedido->getEnvio() == 1) {} else { ?>style="display: none;" <?php } } else { ?> style="display:none;" <?php } ?>>

                <label for="direccion">Direcci&oacute;n de Envio</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="<?php if($_GET['id']) { echo ucwords($pedido->getDireccion()); } else { echo ucwords($cliente->getDireccion()); }?>" required>
                <div class="help-block with-errors"></div>
            </div>

<?php } ?>

            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripci&oacute;n" value="<?php if($pedido->getDescripcion() == '0') { echo ''; } else { echo ucfirst($pedido->getDescripcion()); } ?>" >
            </div>
<hr>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="btnPedido"><?php echo $txtAction; ?></button>

        </form>
    

    </div>




<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
      </div>
      <div class="modal-body">


        <form role="form" method="post" id="principal">
<?php 
        if($_GET['id']) { ?>
            <input type="hidden" name="id_pedido" value="<?php echo $pedido->getId(); ?>">
        <?php } else {

        }
?>
            <input type="hidden" name="id_cliente" value="<?php echo $cliente->getId(); ?>">
            <input type="hidden" name="nuevo_producto" value="1">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripci&oacute;n" value="">
            </div>     
            <div class="form-group">
                <label for="precioGavet">Precio</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="precioGavet" name="precioGavet" placeholder="Precio" required >
                <div class="help-block with-errors"></div>
                <div class="input-group-addon">$</div>
                </div>
            </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Agregar</button>
      </div>
        </form>
    </div>
  </div>
</div>


