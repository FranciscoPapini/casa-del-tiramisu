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
    
    Util::setMsj('Est&aacute; a punto de eliminar el siguiente cliente:','warning',false);
    ?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Eliminar Cliente</h1>
      </div>
        <?php echo Util::getMsj(); ?>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $cliente->getId();?>" >
            <div class="form-group">
                <label for="nombre">Cliente</label>
                <input type="text" class="form-control" id="nombre" name="nombre" readonly placeholder="Cliente" value="<?php echo ucwords($cliente->getNombre());?>" >
            </div>
            <div class="form-group">
                <label for="telefono">Tel&eacute;fono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" readonly placeholder="Tel&eacute;fono" value="<?php echo $cliente->getTelefono();?>" >
            </div> 
            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control" id="direccion" name="direccion" readonly placeholder="Direcci&oacute;n" value="<?php echo ucwords($cliente->getDireccion());?>" >
            </div>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
<?php
      }
      else{
      Util::setMsj('Debe seleccionar un cliente','warning');
      header('Location: ?modulo=cliente&accion=listar');
      die();
      }
?>
    </div>
<?php 
}
?>