    <?php
    if ($_GET['id']) {
        if ($_GET['id'] != $_SESSION['encargado']['id']) {
            if ($_SESSION['encargado']['id'] == 1) {
        $encargado = $encargadoNegocio->recuperar($_GET['id']);

    Util::setMsj('Est&aacute; a punto de eliminar el siguiente encargado:','warning',false);
    ?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <?php echo Util::getMsj(); ?>
        <h1>Eliminar Encargado</h1>
      </div>
        <form role="form" method="post">
            <input type="hidden" name="id" value="<?php echo $encargado->getId();?>" >

            <div class="form-group">
                <label for="encargado">Encargado</label>
                <input type="text" class="form-control" id="encargado" name="encargado" readonly placeholder="Encargado" value="<?php echo ucwords($encargado->getNombre()).' '.ucwords($encargado->getApellido()).' ('.$encargado->getUsuario().')';?>" >
            </div>
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
        </form>
<?php
            }
            else{
    ?>
        <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>No tiene permisos eliminar administradores</b></div>
        </div>
        <?php 
        die();  
    }
        }
        else{
    ?>
        <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>No puede eliminarse con la sesi&oacute;n activa</b></div>
        </div>
        <?php 
        die();  
    }
    }
    else{
    ?>
        <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>Debe seleccionar un administrador</b></div>
        </div>
        <?php 
        die();  
    }
?>
</div>