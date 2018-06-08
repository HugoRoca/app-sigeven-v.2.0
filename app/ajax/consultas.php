<?php

require_once '../models/Consultas.php';

$consulta = new Consultas();

switch ($_GET["op"]) {
    case 'comprasfecha':
        try {
            $fecha_inicio = $_REQUEST['fecha_inicio'];
            $fecha_fin = $_REQUEST['fecha_fin'];

            $rspta = $consulta->comprasFecha($fecha_inicio, $fecha_fin);

            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
                    "2"=>$reg->proveedor,
                    "3"=>$reg->tipo_comprobante,
                    "4"=>$reg->serie_comprobante . ' - ' . $reg->num_comprobante,
                    "5"=>$reg->total_compra,
                    "6"=>$reg->impuesto,
                    "7"=>($reg->estado) ? '<span class="label bg-green">Activado</<span>' : '<span class="label bg-red">Desactivado</<span>'
                );
            }

            $results = array(
                "sEcho"=>1, //información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total de registro a visualizar
                "aaData"=>$data
            );

            echo json_encode($results);
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }        

        break;
    case 'ventasFechaCliente':
        try {
            $fecha_inicio = $_REQUEST['fecha_inicio'];
            $fecha_fin = $_REQUEST['fecha_fin'];
            $idcliente = $_REQUEST['idcliente'];

            $rspta = $consulta->ventasFechaCliente($fecha_inicio, $fecha_fin, $idcliente);

            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
                    "2"=>$reg->cliente,
                    "3"=>$reg->tipo_comprobante,
                    "4"=>$reg->serie_comprobante . ' - ' . $reg->num_comprobante,
                    "5"=>$reg->total_venta,
                    "6"=>$reg->impuesto,
                    "7"=>($reg->estado) ? '<span class="label bg-green">Activado</<span>' : '<span class="label bg-red">Desactivado</<span>'
                );
            }

            $results = array(
                "sEcho"=>1, //información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total de registro a visualizar
                "aaData"=>$data
            );

            echo json_encode($results);
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }        

        break;
}

?>