$(function(){

    var removerProducto = function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    };

    var showLoading = function(){
        $('#loading').show();
    };

    var hideLoading = function(){
        $('#loading').hide();
    };

    var generarModal = function(titulo, contenido){
        if( !$('#miModal').length ){
            $('<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel">Modal title</h4></div><div class="modal-body"></div><div class="modal-footer" id="non-printable"><button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button></div></div></div></div>').appendTo('html');
            $('#miModal').on('show.bs.modal',hideLoading);
        }
        var modal = $('#miModal');
        $('h4.modal-title',modal).html(titulo);
        $('div.modal-body',modal).html(contenido);
        modal.modal('show');
    };

    var mostrarPedido = function(e){
        e.preventDefault();
        var $this = $(this);
        showLoading();
        $.get(
            $this.attr('href'),
            function(data){
                var response = $("#reporte", data);
                generarModal('Detalle de pedido', response);
            }
        );
    };

     var mostrarLiquidacion = function(e){
        e.preventDefault();
        var $this = $(this);
        showLoading();
        $.get(
            $this.attr('href'),
            function(data){
                var response = $("#reporte", data);
                generarModal('Detalle de ganancia', response);
            }
        );
    };

    var mostrarPedidos = function(e){
        e.preventDefault();
        var $this = $(this);
        showLoading();
        $.get(
            $this.attr('href'),
            function(data){
                var response = $("#reportePedidos", data);
                generarModal('Pr&oacute;ximos pedidos', response);
            }
        );
    };

    var validarPassword = function(e){
        e.preventDefault();
        
        var pass = $("#password").val();
        var confpass = $("#confpassword").val();

        if (pass && confpass){
            if (pass != confpass){
                $("#div-alert-pass").toggle(true);
            }
            else{
                $("#div-alert-pass").toggle(false);
            }
        }
        if (!pass && !confpass) {
            $("#div-alert-pass").toggle(false);
        }
    };

    /*Validar Password al editar Encargado*/
    $("#password").on('change',validarPassword);
    $("#confpassword").on('change',validarPassword);

    /*Tooltip*/
    $('a[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    /*Cancelar*/
    $('.cancelForm').on('click',function(e){
    	e.preventDefault();
    	$(this).prop('disabled',true);
    	history.go(-1);
    });

    /*Redireccionar submit*/
    $('#submit a').on('click',function(e){
        e.preventDefault();
        var form = $('form#principal'),
            $this = $(this);
        if(!$('input#redirect').length){
            $('<input type="hidden" name="redirect" id="redirect">').prependTo(form);
        }
        $('input#redirect').val($this.attr('href'));
        $('#submit-button').trigger('click');
    });

    /*Datepicker*/
    $(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });

    /*DataTable*/
    if(jQuery().DataTable) {
        $('#tableListar').DataTable({
            "order": [[0, 'desc'], [1, 'desc']],
            "language": {
                "lengthMenu"            : "Mostrar _MENU_ registros por página",
                "zeroRecords"           : "No se encontraron resultados",
                "info"                  : "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty"             : "No hay registros disponibles",
                "infoFiltered"          : "(filtrado de _MAX_ registros totales)",
                "sSearch"               : "",
                "sSearchPlaceholder"    : 'Buscar',
                "oPaginate"             : {
                    "sFirst"                : "Primero",
                    "sPrevious"             : "Anterior", 
                    "sNext"                 : "Siguiente",
                    "sLast"                 : "Último"
                }
            }
        })

        .column( 0 ).visible( true );
    }

    /*DataTable*/
    if(jQuery().validator) {
        $('form#principal').validator();
    }

    /*Agregar Producto*/
    $('#btnAgregarProducto').on('click',function(e){
        e.preventDefault();
        var idProducto      = $('#id_producto').val(),
            nomProducto     = $('#id_producto option:selected').text(),
            cantidad        = $('#cantidad').val(),
            precioSugerido  = $('#id_producto option:selected').data('precio')*$('#cantidad').val(),
            observacion     = $('#observacion').val();

        if(!idProducto){
            alert('Por favor, seleccione un producto');
        }else{
            if(!cantidad || cantidad<=0){
            alert('Por favor, seleccione una cantidad positiva');
            }else{
            var fila = $('<tr>');

            var inputId = $('<input>').prop({
                name    : 'productos[]',
                id      : 'productos[]',
                value   : idProducto,
                type    : 'hidden'
            });

            var inputCantidad = $('<input>').prop({
                name    : 'cantidades[]',
                value   : cantidad,
                type    : 'hidden'
            });

            var inputPrecio = $('<input>').prop({
                name    : 'preciosSugeridos[]',
                value   : precioSugerido,
                type    : 'hidden'
            });

            var inputObs = $('<input>').prop({
                name    : 'observaciones[]',
                value   : observacion,
                type    : 'hidden'
            });

            $('<td>').html(nomProducto).append(inputId).append(inputObs).append(inputCantidad).append(inputPrecio).appendTo(fila);

            //TODO pasar a multiline
            $('<td>').html(observacion).appendTo(fila);
            $('<td>').html(cantidad).appendTo(fila);
            $('<td>').html('$ ').append(parseFloat(precioSugerido).toFixed(2)).appendTo(fila);

            var cerrar = $('<a href="#" title="Eliminar Pedido"><span class="glyphicon glyphicon-remove"></span></a>');
            cerrar.addClass('removeItemProducto').on('click',removerProducto);

            $('<td>').append(cerrar).appendTo(fila);

            $('#tblProductos tbody').append(fila);

            $('#id_producto').val('');
            $('#observacion').val('');

        }
        }
    });

    $('.removeItemProducto').on('click',removerProducto);

    $('#btPedido').on('click',function(e){
        e.preventDefault();

        if(!$('#productos[]').val()){
            alert('Por favor, seleccione un producto');
        }else{
                    alert('¡e un producto');

        }

    });

    /*Consultar consulta*/
    $('.btnConsultar').on('click',mostrarPedido);
    
    /*Consultar liquidacion*/
    $('.btnLiquidacion').on('click',mostrarLiquidacion);

    /*Consultar proximos pedidos*/
    $('.btnListarPedidos').on('click',mostrarPedidos);

    $('#envio').on('click',function(e){
        $("#direcc").toggle(this.checked);
    });    

    $('#telefono').on('click',function(e){
    });    

});