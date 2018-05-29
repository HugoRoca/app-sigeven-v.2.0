<?php

require_once '../models/Usuario.php';

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES["imagen"]["tmp_name"]) || !is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
            $imagen = $_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES["imagen"]["type"] == "image/jpg" || $_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../Files/Usuarios/" . $imagen);
            }
        }

        if (empty($idusuario)) {
            $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen);
            echo $rspta ? "Usuario registrado" : "Usuario no se pudo registrar";
        }else{
            $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;
    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;
    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
        break;
    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $usuario->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0"=>($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button> '.
                    '<button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>' : 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button> '.
                    '<button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>$reg->login,
                "7"=>'<img src="../Files/Usuarios/'.$reg->imagen.'" height="50px" width="50px">',
                "8"=>($reg->condicion) ? '<span class="label bg-green">Activado</<span>' : '<span class="label bg-red">Desactivado</<span>'
            );
        }

        $results = array(
            "sEcho"=>1, //información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total de registro a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);

        break;
}

?>