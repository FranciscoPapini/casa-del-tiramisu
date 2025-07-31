    <?php
    if (($_GET['id'] == $_SESSION['encargado']['id']) || ($_GET['id'] && $_SESSION['encargado']['id'] == 1)) {
        $encargado = $encargadoNegocio->recuperar($_GET['id']);
        $txtAction = 'Editar';
    }else if ($_SESSION['encargado']['id'] == 1){
        $encargado = new Encargado();
        $txtAction = 'Agregar';
    }else {
    ?>
        <div class="container" id="non-printable">
        <div class="alert alert-danger" role="alert"><b>No tiene permisos para agregar o editar administradores</b></div>
        </div>
        <?php 
        die();  
    }
    ?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <?php echo Util::getMsj(); ?>
        <h1><?php echo $txtAction; ?> Encargado</h1>
      </div>
        <form role="form" method="post" id="principal">
            <input type="hidden" name="id" value="<?php echo $encargado->getId();?>" >
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo $encargado->getUsuario();?>" 
                <?php if($_GET['id']) { ?> disabled <?php }else{?> data-remote="checkUser.php" required autofocus <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo ucwords($encargado->getNombre());?>" <?php if($_GET['id']) { echo 'autofocus'; } else {} ?> required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo ucwords($encargado->getApellido());?>" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $encargado->getEmail();?>" required>
                <div class="help-block with-errors"></div>
            </div>
            
            <?php if($_GET['id']){ ?>
            <div class="alert alert-info" role="alert">Para cambiar su contraseña, complete los siguientes campos.<br>Para <strong>No</strong> cambiar su contraseña, <strong>No</strong> complete los siguientes campos.</div>
            <?php } ?>

            <div class="form-group">
                <label for="password">Contrase&ntilde;a</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a" value="" <?php if(!$_GET['id']) { ?> required <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="confpassword">Confirmar Contrase&ntilde;a</label>
                <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Confirmar Contrase&ntilde;a" value="" <?php if(!$_GET['id']) { ?> data-match="#password" <?php } ?> >
                <div class="help-block with-errors"></div>
            </div>

            <button type="button" class="btn btn-default cancelForm">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?php echo $txtAction; ?></button>

        </form>
    </div>