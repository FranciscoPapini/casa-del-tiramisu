      <?php
          $envio = $envioNegocio->recuperar(date('d/m/Y'));
          $txtAction = 'Actualizar';
      ?>
    <div class="container">
      <div class="page-header">
        <?php echo Util::getMsj(); ?>
        <h1>Envio </h1>
      </div>
        <form role="form" method="post" id="principal">
            <div class="form-group">
                <label for="valorActual">Valor Actual</label>
                <input type="text" class="form-control" disabled name="valorActual" value="<?php echo $envio->getPrecio();?>" >
            </div>
            <div class="form-group">
                <label for="precio">Nuevo Valor</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="Nuevo Valor" autofocus required>
                <div class="help-block with-errors"></div>
            </div>
            
            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>
        </form>
    </div>