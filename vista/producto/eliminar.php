<?php
if ($_GET['id']) {
    $producto = $productoNegocio->recuperar($_GET['id']);
          
      require_once('negocio/precioNegocio.php');
      $precioNegocio = new PrecioNegocio();
      $precio = $precioNegocio->recuperar($producto->getId(), date('d/m/Y'));

Util::setMsj('Est&aacute; a punto de eliminar el siguiente producto:','warning',false);
?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Eliminar Producto</h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $producto->getId();?>">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" readonly placeholder="Nombre" value="<?php echo $producto->getNombre();?>" >
            </div>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" readonly placeholder="Descripci&oacute;n" value="<?php echo $producto->getDescripcion();?>" >
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <div class="input-group">
                <input type="text" class="form-control" id="precio" name="precio" readonly placeholder="Precio" value="<?php echo $precio->getValor();?>" >
                <div class="input-group-addon">$</div>
                </div>                        
              </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
    <?php 
    }
    else {
    Util::setMsj('Debe seleccionar un producto','warning');
    header('Location: ?modulo=producto&accion=listar');
    die();    
    }
    ?>    
  </div>