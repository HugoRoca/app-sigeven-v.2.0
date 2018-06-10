<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/Conexion.php';

Class Usuario
{
    //Implementamoa nuestro constructor
    public function __construct(){

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos){
        $sql = "INSERT INTO usuario (nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen, condicion) 
                VALUES ('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$clave', '$imagen', '1')";

        $idusuarioNew = ejecutarConsulta_retornarID($sql);                
        
        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO permisousuario(idusuario, idpermiso)
                            VALUES ('$idusuarioNew', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    //Implementamos un método para editar registros
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos){
        $sql = "UPDATE usuario 
                SET nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento',
                    direccion='$direccion', telefono='$telefono', email='$email',
                    cargo='$cargo', login='$login', clave='$clave', imagen='$imagen' 
                 WHERE idusuario='$idusuario'";
        ejecutarConsulta($sql);

        //Eliminar todos los permisos asignados
        $sqldel = "DELETE FROM permisousuario WHERE idusuario = '$idusuario'";
        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO permisousuario(idusuario, idpermiso)
                            VALUES ('$idusuario', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;

    }

    //Implementamos un método para desactivar categorías
    public function desactivar($idusuario){
        $sql = "UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar categorías
    public function activar($idusuario){
        $sql = "UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para listar un registro
    public function mostrar($idusuario){
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }

    //Implemenar un método para listos los permisos marcados
    public function listarMarcados($idusuario){
        $sql = "SELECT * FROM permisousuario WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Función para verificar el acceso al sistema
    public function verificar($login, $clave){
        $sql = "SELECT idusuario, nombre, tipo_documento, num_documento, telefono, email, cargo, imagen, login
                FROM usuario 
                WHERE login = '$login' 
                    AND clave = '$clave'
                    AND condicion = '1'";
        return ejecutarConsulta($sql);
    }
}


?>