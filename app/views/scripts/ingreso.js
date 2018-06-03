var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e){
		guardarEditar(e);	
    });
}

//función limpiar
function limpiar() {
    $('#idproveedor').val();
    $('#proveedor').val();
    $('#serie_comprobante').val();
    $('#num_comprobante').val();
    $('#fecha_hora').val();
    $('#impuesto').val();
}

//función mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
        $('#btnAgregar').show();
    }
}

//functión cancelarForm
function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

//function listar
function listar() {
    tabla = $('#tblListado').dataTable({
        'aProcessing': true, //activamos el procesamiento del datatable
        'aServerSide': true, //paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        'ajax': {
            url: '../ajax/ingreso.php?op=listar',
            type: 'get',
            dataType: 'json',
            error: function e() {
                console.log(e.responseText);
            }},
        'bDestroy': true,
        'iDisplayLength': 5, //paginación
        'order': [[0, 'desc']] //ordenar (columns, orden)
    }).DataTable();
}

function guardarEditar(e) {
    e.preventDefault(); //No se activará la acción predeterminado del evento
    $('#btnGuardar').prop('disabled', true);
    var formData = new FormData($('#formulario')[0]);

    $.ajax({
        url: '../ajax/ingreso.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}

function mostrar(idingreso) {
    $.post('../ajax/ingreso.php?op=mostrar', {idingreso: idingreso}, function(data){
        data= JSON.parse(data);
        mostrarForm(true);

        $('#idcategoria').val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $('#codigo').val(data.codigo);
        $('#nombre').val(data.nombre);
        $('#stock').val(data.stock);
        $('#descripcion').val(data.descripcion);
        $('#imagenmuestra').show();
        $('#imagenmuestra').attr('src', '../Files/Articulos/' + data.imagen);
        $('#imagenactual').val(data.imagen);
        $('#idingreso').val(data.idingreso);

        generarBarCode();

    });
}

//Funcion para anular registros
function anular(idingreso) {
    bootbox.confirm('¿Está seguro de anular el ingreso?', function(result){
        if(result){
            $.post('../ajax/ingreso.php?op=anular', {idingreso: idingreso}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init();