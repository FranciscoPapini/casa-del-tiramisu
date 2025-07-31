    <div class="container" id="non-printable">
      <div class="page-header" id="non-printable">
        <h1>Productos <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=producto&accion=editar'">Agregar</button></h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="width:30%">Nombre</th>
            <th style="width:30%">Descripci&oacute;n</th>
            <th>Precio</th>
            <th style="width:1%">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once('negocio/precioNegocio.php');
          $precioNegocio = new PrecioNegocio();

          $arrayProductos = $productoNegocio->listar();
          if( count($arrayProductos) > 0 ){
            foreach( $arrayProductos as $producto ){
          ?>
              <tr>
                <td><?php echo ucwords($producto->getNombre());?></td>
                <td><?php echo ucfirst($producto->getDescripcion());?></td>
                <td>$ <?php 
                      $precio = $precioNegocio->recuperar($producto->getId(), date('d/m/Y'));
                      echo $precio->getValor();?></td>
                <td style="width:1%" align="center">
                  <a href="?modulo=producto&accion=editar&id=<?php echo $producto->getId();?>" data-toggle="tooltip" title="Editar Producto"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=producto&accion=eliminar&id=<?php echo $producto->getId();?>" data-toggle="tooltip" title="Eliminar Producto"><span class="glyphicon glyphicon-remove"></span></a>
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