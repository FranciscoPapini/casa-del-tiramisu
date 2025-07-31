<?php
      if ($_GET['id']) {
          $producto = $productoNegocio->recuperar($_GET['id']);
          
          require_once('negocio/precioNegocio.php');
          $precioNegocio = new PrecioNegocio();
          $precio = $precioNegocio->recuperar($producto->getId(), date('d/m/Y'));
          
          $txtAction = 'Editar';

      }else{
        $producto = new Producto();
        $txtAction = 'Agregar';
      }
?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1><?php echo $txtAction; ?> Producto</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $producto->getId();?>">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $producto->getNombre();?>" <?php if($_GET['id']) {} else { echo 'autofocus'; } ?> required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripci&oacute;n" value="<?php echo $producto->getDescripcion();?>">
            </div>
            <?php if ($_GET['id']) { ?>
            <div class="form-group">
                <label for="precioActual">Precio Actual</label>
                <div class="input-group">
                <input type="text" class="form-control" readonly id="precioActual" name="precioActual" value="<?php if ($_GET['id']) { echo $precio->getValor(); } ?>" >
                <div class="input-group-addon">$</div>
                </div>            
              </div>
            <?php } ?>        
            <div class="form-group">
                <label for="precioGavet"><?php if ($_GET['id']) { ?>Nuevo <?php } ?>Precio</label>
                <div class="input-group">
                <input type="number" step="0.01" class="form-control" id="precioGavet" name="precioGavet" placeholder="<?php if ($_GET['id']) { ?>Nuevo <?php } ?>Precio" <?php if ($_GET['id']) { } else { ?> required <?php } ?> >
                <?php if ($_GET['id']) { } else { ?> <div class="help-block with-errors"></div> <?php } ?>
                <div class="input-group-addon">$</div>
                </div>
            </div>

            
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>