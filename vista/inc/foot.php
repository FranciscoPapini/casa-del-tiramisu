    <div id="loading">
    	<div id="loading-img"></div>
    	<p>Cargando</p>
    </div>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/locales/bootstrap-datepicker.es.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
    <?php if($accion == 'listar' || $accion == 'listarPendientes'){ ?>
        <script src="js/dataTables.bootstrap.js"></script>
    <?php } elseif ($accion == 'editar' || $accion == 'buscar' || $accion == 'generar') { ?>
        <script src="js/validator.js"></script>
    <?php }?>
    <script src="js/global.js"></script>
  </body>
</html>