var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();
}

//función limpiar
function limpiar() {
    $('#idcategoria').val('');
    $('#nombre').val('');
    $('#descripcion').val('');
}

//función mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
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
            url: '../ajax/categoria.php?op=listar',
            type: 'get',
            dataType: 'json',
            error: function e() {
                console.log(e.responseText);
            },
        'bDestroy': true,
        'iDesplayLength': 5, //paginación
        'order': [[0, 'desc']] //ordenar (columns, orden)
        }
    }).DataTable();
}

init();