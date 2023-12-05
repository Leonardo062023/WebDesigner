<?php
require_once('../Conexion/Conexion.php');
$con = new conexionPDO();
session_start();
$carrito = $_SESSION['carrito'];

function guardaCompra($inventario, $nomcomprador, $doccomprador, $mediopago)
{
    global $con;
    global $carrito;
    foreach ($carrito as $productos) {

        $ProCom = $inventario[0][1];
        $CanCom = $productos['cantidad'];
        $PreCom = $inventario[0][5];
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");
        $Hora = date("H:i:s");
        $fechahora = date('Y-m-d H:i:s');
        $sql_cons  = "INSERT INTO historialventa (ProCom,CanCom,PreCom,fecha,Hora,nomcomprador,doccomprador,mediopago) 
        VALUES (:ProCom,:CanCom,:PreCom,:fecha,:Hora,:nomcomprador,:doccomprador,:mediopago)";
        $sql_dato = array(
            array(":ProCom", $ProCom),
            array(":CanCom", $CanCom),
            array(":PreCom", $PreCom),
            array(":fecha", $fecha),
            array(":Hora", $Hora),
            array(":nomcomprador", $nomcomprador),
            array(":doccomprador", $doccomprador),
            array(":mediopago", $mediopago),
        );
        $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
    }
    unset($_SESSION['carrito']);
};
