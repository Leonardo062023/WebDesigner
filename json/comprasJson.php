<?php
require_once('../Conexion/Conexion.php');
require_once('../Funciones/funcionescompra.php');
$con = new conexionPDO();
session_start();
$action = $_REQUEST['action'];
$carrito = $_SESSION['carrito'];
$nom = $_REQUEST['nom'];
$num = $_REQUEST['num'];
$Med = $_REQUEST['Med'];
switch ($action) {
    case 1: #Elimina productos comprados
        foreach ($carrito as $producto) {
            $id = $producto['id'];
            $cantidad = $producto['cantidad'];
            //Si no existe el registro como predecesor se elimina.
            $inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id= $id");
            guardaCompra($inventario,$nom,$num,$Med);
            if ($cantidad < $inventario[0][2]) {
                $cantidadN = $inventario[0][2] - $cantidad;
                $sql_cons = "UPDATE inventario SET Cantidad=:Cantidad WHERE id=:id";
                $sql_dato = array(  
                    array(":Cantidad", $cantidadN),
                    array(":id", $id),
                );
                $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
                if (empty($obj_resp)) {
                    $rta = 1;
                } else {
                    $rta = 2;
                }
            } else if ($inventario[0][2]<=0) {
                $sql_cons = "DELETE FROM inventario WHERE id = :id";
                $sql_dato = array(
                    array(":id", $id)
                );
                $resp = $con->InAcEl($sql_cons, $sql_dato);
                if (empty($obj_resp)) {
                    $rta = 1;
                } else {
                    $rta = 2;
                }
            }
        }
        
        if ($rta = 1) {
            echo 1;
        } else {
            echo 2;
        }
        break;

    case 2: #Elimina producto completo

        break;
    case 3: #Elimina todo

        break;
    case 4:  #Reduce 1 producto

        break;
}
