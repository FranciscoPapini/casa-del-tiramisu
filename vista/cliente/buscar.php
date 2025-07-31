    <div class="container" id="non-printable" >

      <div class="page-header" id="non-printable" >
        <h1>Buscar Cliente
            
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <?php echo 'Ventas'; ?> <span class="caret"></span> 
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?modulo=pedido&accion=listar&id_cliente=1"><span class="glyphicon glyphicon-list"></span> Listar 
                Ventas</a></li>
                <li><a href="?modulo=pedido&accion=generar"><span class="glyphicon glyphicon-plus"></span> Agregar Venta</a></li>
              </ul>

            </div>



        </h1>
      </div>
      <?php echo Util::getMsj(); ?>
        <form role="form" method="post" id="principal">

 
<div class="row">
            <div class="col-md-12"> 
                <div class="form-group">
                <label for="buscador">Tel&eacute;fono</label>
                <input type="number" step="0.0" class="form-control" id="buscador" name="buscador" placeholder="Tel&eacute;fono" value="" autofocus required >
                <div class="help-block with-errors"></div>
            </div>

        </div>
</div>


            <button type="submit" class="btn btn-primary">Buscar</button>

        </form>


    </div>