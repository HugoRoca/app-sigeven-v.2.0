<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/Conexion.php';

Class Usuario
{
    //Implementamoa nuestro constructor
    public function __construct(){

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen){
        $sql = "INSERT INTO usuario (nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen, condicion) 
                VALUES ('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$clave', '$imagen', '1')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen){
        $sql = "UPDATE usuario 
                SET nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento',
                    direccion='$direccion', telefono='$telefono', email='$email',
                    cargo='$cargo', login='$login', clave='$clave', imagen='$imagen' 
                 WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
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
}


?>