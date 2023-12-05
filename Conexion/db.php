<?php
class conectar{
    public static function conexion(){
        $hostname_conexion = "localhost";

        $database_conexion = "empoduitama";
        $username_conexion = "root";
        $password_conexion = "";
        $mysqli = new mysqli($hostname_conexion,$username_conexion,$password_conexion,$database_conexion);
        mysqli_set_charset($mysqli,'utf8');
        return $mysqli;
    }
}