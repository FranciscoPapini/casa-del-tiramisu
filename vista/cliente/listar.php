    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Clientes <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=cliente&accion=editar'">Agregar</button></h1>
      </div>

      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="width:25%">Nombre</th>
            <th style="width:20%">Tel&eacute;fono</th>
            <th style="width:30%">Direcci&oacute;n</th>
            <th style="width:1%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayClientes = $clienteNegocio->listar();
          if( count($arrayClientes) > 0 ){
            foreach( $arrayClientes as $cliente ){
            if($cliente->getId() == 1) {} else {
          ?>
              <tr>
                <td><?php echo ucwords($cliente->getNombre());?></td>
                <td><?php echo $cliente->getTelefono();?></td>
                <td><?php echo ucwords($cliente->getDireccion());?></td>
                <td style="width:1%" align="center">
                  <a href="?modulo=cliente&accion=editar&id=<?php echo $cliente->getId();?>" data-toggle="tooltip" title="Editar Cliente"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=cliente&accion=eliminar&id=<?php echo $cliente->getId();?>" data-toggle="tooltip" title="Eliminar Cliente"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;
                  <a href="?modulo=pedido&accion=listar&id_cliente=<?php echo $cliente->getId();?>" data-toggle="tooltip" title="Listar Pedidos"><span class="glyphicon glyphicon-list"></span></a>
                </td>
              </tr>
          <?php
            }
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