<?php
    if ($_SESSION['encargado']['id'] != 1) {
        Util::setMsj('No tiene permisos para editar encargados','danger');
        header('Location:?modulo=cliente&accion=listar');
        die();  
    }
?>
    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Encargados <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=encargado&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="width:30%">Apellido</th>
            <th style="width:30%">Nombre</th>
            <th>Usuario</th>
            <th style="width:1%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayEncargados = $encargadoNegocio->listar();
          if( count($arrayEncargados) > 0 ){
            foreach( $arrayEncargados as $encargado ){
          ?>
              <tr>
                <td><?php echo ucwords($encargado->getApellido());?></td>
                <td><?php echo ucwords($encargado->getNombre());?></td>
                <td><?php echo $encargado->getUsuario();?></td>
                <td style="width:1%" align="center">
                  <?php if( ($encargado->getId() == $_SESSION['encargado']['id']) || $_SESSION['encargado']['id'] == 1 ){
                  ?> 
                  <a href="?modulo=encargado&accion=editar&id=<?php echo $encargado->getId();?>" data-toggle="tooltip" title="Editar Encargado"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <?php }
                  if( ($encargado->getId() != $_SESSION['encargado']['id']) && $_SESSION['encargado']['id'] == 1 ){
                  ?> 
                  <a href="?modulo=encargado&accion=eliminar&id=<?php echo $encargado->getId();?>" data-toggle="tooltip" title="Eliminar Encargado"><span class="glyphicon glyphicon-remove"></span></a>
                <?php } ?>
                </td>
              </tr>
          <?php
            }
          }else{
          ?>
          <tr>
            <td colspan="4">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>