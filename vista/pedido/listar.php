<?php
if($_GET['id_cliente']) { 
require_once('negocio/clienteNegocio.php');
$clienteNegocio = new ClienteNegocio();
$cliente = $clienteNegocio->recuperar($_GET['id_cliente']);
?>
    <div class="container" id="non-printable">
      <ol class="breadcrumb">

        <?php if($cliente->getId() == 1) { ?>
        <li class="active">Venta</li>
         <?php } else { ?>
        <li><a href="?modulo=cliente&accion=editar&id=<?php echo $cliente->getId(); ?>"><?php echo ucwords($cliente->getNombre()); ?></a></li>

         <?php } ?>

        <?php if($cliente->getId() == 1) { } else { ?>
        <li class="active">Pedidos</li>
      <?php } ?>
      </ol>
      <div class="page-header" id="non-printable">
        <h1>
        <?php if($cliente->getId() == 1) { 
          echo 'Ventas';
          ?>
                  <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=pedido&accion=generar'">Agregar</button>
       <?php } else { ?>
          Pedidos 
      
          <button type="button" class="btn btn-primary btn-sm" id="btn-agregar" name="btn-agregar" onclick="document.location='?modulo=pedido&accion=editar&id_cliente=<?php echo $_GET['id_cliente'] ?>'">Agregar</button>
        <?php } ?>          
        </h1>
      </div>
      <?php echo Util::getMsj(); ?>
      <div class="table-responsive text-nowrap">
      <table class="table table-striped table-bordered table-hover" id="tableListar">
        <thead>
          <tr>
            <th style="display: none;">Fecha a Ordenar</th>
            <th style="display: none;">Id</th>
            <th style="width:1%">Fecha</th>
            <?php if($cliente->getId() == 1) {} else { ?>
            <th>Descripci&oacute;n</th>
            <th style="width:1%">Env&iacute;o</th>
            <?php } ?>
            <th style="width:12%">Total</th>
            <th style="width:1%" align="center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $arrayPedidos = $pedidoNegocio->listar($_GET['id_cliente']);
          if( count($arrayPedidos) > 0 ){
            $hoy = date('Y-m-d');
            foreach( $arrayPedidos as $pedido ){
              $next = $pedido->getFecha() >= $hoy? 'next' : 'prev';
          ?>
              <tr class="<?php if($cliente->getId() == 1) { } else { echo $next; } ?>">
                <td style="display: none;"><?php echo $pedido->getFecha();?></td>
                <td style="display: none;"><?php echo $pedido->getId();?></td>
                <td><?php echo Util::DbToDate($pedido->getFecha());?></td>
            <?php if($cliente->getId() == 1) {} else { ?>
                <td><?php if($pedido->getDescripcion() == '0') { echo ''; } else { echo ucfirst($pedido->getDescripcion()); }?></td>
                <td><?php if($pedido->getEnvio() == 1) { echo 'Si'; } else { echo 'No'; }?></td>
            <?php } ?>
                <td>$ <?php echo $pedido->getPrecio(); ?></td>
                <td style="width:1%">
                  <a href="?modulo=pedido&accion=editar&id=<?php echo $pedido->getId();?>&id_cliente=<?php echo $_GET['id_cliente'] ?>" data-toggle="tooltip" <?php if($cliente->getId() == 1) { ?> title="Editar Venta" <? } else { ?> title="Editar Pedido" <?php } ?> ><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
                  <a href="?modulo=pedido&accion=eliminar&id=<?php echo $pedido->getId();?>&id_cliente=<?php echo $_GET['id_cliente'] ?>" data-toggle="tooltip" <?php if($cliente->getId() == 1) { ?> title="Eliminar Venta" <? } else { ?> title="Eliminar Pedido" <?php } ?>><span class="glyphicon glyphicon-remove"></span></a>&nbsp;

            <?php if($cliente->getId() == 1) { ?>


                  <a href="?modulo=pedido&accion=consultarVenta&id=<?php echo $pedido->getId();?>" class="btnConsultar" data-toggle="tooltip" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=pedido&accion=reporteVenta&id=<?php echo $pedido->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>               


            <?php } else { ?>

                  <a href="?modulo=pedido&accion=consultar&id=<?php echo $pedido->getId();?>" class="btnConsultar" data-toggle="tooltip" title="Ver Detalle"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;
                  <a href="?modulo=pedido&accion=reporte&id=<?php echo $pedido->getId();?>" data-toggle="tooltip" target="_blank" title="Imprimir"><span class="glyphicon glyphicon-print"></span></a>               

            <?php } ?>

                </td>
              </tr>
          <?php
            }
          }else{
          ?>
          <tr>
            <?php if($cliente->getId() == 1) { $col = 'colspan=4'; } else { $col = 'colspan=6'; } ?>
            <td <?php echo $col; ?>>No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
<?php
}
else{
    Util::setMsj('Debe seleccionar un cliente','warning');
    header('Location:?modulo=cliente&accion=listar');
    die();
    }
?>
    </div>
  </div>