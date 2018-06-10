var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
		$("#idcliente").html(r);
		$('#idcliente').selectpicker('refresh');
		$("#idclienteMostrar").html(r);
		$('#idclienteMostrar').selectpicker('refresh');
	});	
}

//Función limpiar
function limpiar(){
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag)
	{
		$('#serie_comprobante').val('BOL001');
		$('#serie_comprobante').prop('disabled', true);
		$("#num_comprobante").focus();
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$('#formularioMostrar').hide();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles = 0;
	}
	else
	{
		$("#listadoregistros").show();
		$('#formularioMostrar').hide();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar(){
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función ListarArticulos
function listarArticulos(){
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarArticulosVenta',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

function mostrar(idventa){
	$('#formularioMostrar').show();
    $('#listadoregistros').hide();
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);		

		$("#idclienteMostrar").val(data.idcliente);
		$("#idclienteMostrar").selectpicker('refresh');
		$("#tipo_comprobanteMostrar").val(data.tipo_comprobante);
		$("#tipo_comprobanteMostrar").selectpicker('refresh');
		$("#serie_comprobanteMostrar").val(data.serie_comprobante);
		$("#num_comprobanteMostrar").val(data.num_comprobante);
		$("#fecha_horaMostrar").val(data.fecha);
		$("#impuestoMostrar").val(data.impuesto);
		$("#idventaMostrar").val(data.idventa);
		
		$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
			$("#detallesMostrar").html(r);
	   });	
 	});
}

//Función para anular registros
function anular(idventa){
	bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
	  
  	if (tipo_comprobante=='Factura'){
        $("#impuesto").val(impuesto); 
    }
    else{
        $("#impuesto").val("0"); 
	}

	if (tipo_comprobante == 'Factura') { $('#serie_comprobante').val('FAC001');}
	if (tipo_comprobante == 'Boleta') { $('#serie_comprobante').val('BOL001');}
	if (tipo_comprobante == 'Ticket') { $('#serie_comprobante').val('TCK001');}

	$('#num_comprobante').focus();
  }

function agregarDetalle(idarticulo, articulo, precio_venta, _cantidad){
	var cantidad=1;
	var descuento=0;

	if (idarticulo != ''){
		var subtotal = cantidad * precio_venta;
		var fila = '<tr class="filas" id="fila'+cont+'">'+
					'<td><button type="button" class="btn btn-danger btn-block" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash"></i></button></td>'+
					'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
					'<td><input type="text" class="form-control text-center" name="cantidad[]" id="cantidad[]" value="'+cantidad+'" onkeyUp="return ValStockNumero(	this, '+_cantidad+')"></td>'+
					'<td><input type="text" class="form-control text-right" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'" onkeypress="return SoloDecimalesInputs(event,this);"></td>'+
					'<td><input type="text" class="form-control text-right" name="descuento[]" value="'+descuento+'" onkeypress="return SoloDecimalesInputs(event,this);"></td>'+
					'<td class="text-right"><h4 name="subtotal" id="subtotal' + cont + '">' + subtotal + '</h4></td>'+
					'<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
				'</tr>';
		cont++;
		detalles = detalles + 1;
		$('#detalles').append(fila);
		modificarSubtotales();
	}else{
		alert("Error al ingresar el detalle, revisar los datos del artículo");
	}
}

function modificarSubtotales(){
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_venta[]");
	var desc = document.getElementsByName("descuento[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i <cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpD=desc[i];
		var inpS=sub[i];

		inpS.value=(inpC.value * inpP.value)-inpD.value;
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotales();
}

function calcularTotales(){
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}

	$("#total").html("S/. " + total);
	$("#total_venta").val(total);
	evaluar();
}

function evaluar(){
	if (detalles>0){
		$("#btnGuardar").show();
	}else{
		$("#btnGuardar").hide(); 
		cont=0;
	}
}

function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	calcularTotales();
	detalles=detalles-1;
	evaluar()
}

init();