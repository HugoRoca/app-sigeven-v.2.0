<?php
session_start();

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

        //Hash SHA256 en la contraseña
        $claveHash = hash("SHA256", $clave);

        if (empty($idusuario)) {
            $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $claveHash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario.";
        }else{
            $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $claveHash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "No se pudieron actualizar todos los datos del usuario.";
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
    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once '../models/Permiso.php';
        $permiso = new Permiso();
        $rpta = $permiso->listar();

        //Obtener los permisos asignados del usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarMarcados($id);

        //Declaramos el array para almacenar todos los pemrisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rpta->fetch_object()) {
            $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
            echo '<li><input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'"> '.$reg->nombre.'</li>';
        }
        break;
    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        $claveHash = hash("SHA256", $clavea);

        $rspta = $usuario->verificar($logina, $claveHash);

        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            ///Declaración de variables de session
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;

            //obtenemos los permuisios del usuario
            $marcados = $usuario->listarMarcados($fetch->idusuario);

            //declaramos un array para alamcenar todos los permisos marcados
            $valores = array();

            //almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }

            //Determinamos los acceso del usuarios
            in_array(1, $valores) ? $_SESSION["escritorio"] = 1: $_SESSION["escritorio"] = 0;
            in_array(2, $valores) ? $_SESSION["almacen"] = 1: $_SESSION["almacen"] = 0;
            in_array(3, $valores) ? $_SESSION["compras"] = 1: $_SESSION["compras"] = 0;
            in_array(4, $valores) ? $_SESSION["ventas"] = 1: $_SESSION["ventas"] = 0;
            in_array(5, $valores) ? $_SESSION["acceso"] = 1: $_SESSION["acceso"] = 0;
            in_array(6, $valores) ? $_SESSION["consultac"] = 1: $_SESSION["consultac"] = 0;
            in_array(7, $valores) ? $_SESSION["consultav"] = 1: $_SESSION["consultav"] = 0;
        }

        echo json_encode($fetch);

        break;

    case 'salir':
        //Limpiamos las variables de sesion
        session_start();
        //Destruimos la session
        session_destroy();
        //Redireccionamos al login
        header('Location: ../index.php');
        break;
}

?>