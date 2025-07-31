    <?php
    if ($_GET['id'] == 1) {
    ?>
        <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>Debe seleccionar un cliente</b></div>
        </div>
            <?php 
            die();
    } else {
    if ($_GET['id']) {
        $cliente = $clienteNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
        $telefono = '';
    }else{
        $cliente = new Cliente();
        $txtAction = 'Agregar';
        $telefono = $_SESSION['buscador'];
        unset($_SESSION['buscador']);
    }
    ?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1><?php if($_GET['ver']) {} else { echo $txtAction; } ?> Cliente</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $cliente->getId();?>" >
            <div class="form-group">
                <label for="telefono">Tel&eacute;fono</label>
                <input type="number" step="0.0" class="form-control" id="telefono" name="telefono" placeholder="Tel&eacute;fono" value="<?php if($_GET['id']) { echo $cliente->getTelefono(); } else { echo $telefono; } ?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo ucwords($cliente->getNombre());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n" value="<?php echo ucwords($cliente->getDireccion());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
            <?php if($_GET['ver']) { ?>
          <button type="button" class="btn btn-info" onclick="document.location='?modulo=pedido&accion=listar&id_cliente=<?php echo $cliente->getId(); ?>'">Ver Pedidos</button>
            <?php } ?>

        </form>
    </div>
<?php } ?>