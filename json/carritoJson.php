<?php
require_once('../Conexion/Conexion.php');
require_once('../Funciones/funcionescompra.php');
$con = new conexionPDO();
session_start();
$url = $_SESSION['ruta_actual'];
$action = $_REQUEST['action'];
$carrito = $_SESSION['carrito'];
switch ($action) {
    case 1: #Incrementa 1 producto
        if (isset($_REQUEST['id'])) {
            $productoId = base64_decode($_REQUEST['id']);

            // Simula una base de datos de productos
            $inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id = $productoId");
            $id = $inventario[0][0];
            $idcarrito = $carrito[''];
            $nombre = $inventario[0][1];
            $valor = $inventario[0][5];
            $cantidad = $inventario[0][2];

            $productos = [
                // $id => ['id' => $id,'nombre' => $nombre, 'precio' => $valor],
                $id => ['id' => $id],
                // Agrega más productos según sea necesario
            ];

            // Verifica si el producto existe
            if (isset($productos[$productoId])) {
                $producto = $productos[$productoId];

                // Agrega el producto al carrito
                if (isset($_SESSION['carrito'][$productoId])) {
                    if ($cantidad > 0) {
                        $_SESSION['carrito'][$productoId]['cantidad']++;
                        restatemporal($cantidad, $id);
                    } else {
                        $_SESSION['mensaje'] = 'El Producto se Agotado';
                    }
                } else {
                    $_SESSION['carrito'][$productoId] = [
                        'id' => $producto['id'],
                        // 'nombre' => $producto['nombre'],
                        // 'precio' => $producto['precio'],
                        'cantidad' => 1
                    ];
                    restatemporal($cantidad, $id);
                }

                header("Location: $url");

                exit();
            }
        }

        header("Location: $url");
        exit();
        break;

    case 2: #Elimina producto completo
        session_start();

        if (isset($_REQUEST['id'])) {
            $productoId = $_REQUEST['id'];

            // Verifica si el producto existe en el carrito
            if (isset($_SESSION['carrito'][$productoId])) {
                // Elimina el producto del carrito
                unset($_SESSION['carrito'][$productoId]);

                header("Location: $url");
                exit();
            }
        }

        header("Location: $url");
        exit();
        break;
    case 3: #Elimina todo
        session_start();
        sumatemporal($id, 2);        // Elimina todos los productos del carrito
        unset($_SESSION['carrito']);

        header("Location: ../carrito.php");
        exit();
        break;
    case 4:  #Reduce 1 producto
        session_start();

        if (isset($_REQUEST['id'])) {
            $productoId = base64_decode($_REQUEST['id']);

            // Verifica si el producto existe en el carrito
            if (isset($_SESSION['carrito'][$productoId])) {
                // Reduce la cantidad del producto en el carrito
                $_SESSION['carrito'][$productoId]['cantidad']--;
                sumatemporal($productoId, 1);
                // Elimina el producto del carrito si la cantidad es cero
                if ($_SESSION['carrito'][$productoId]['cantidad'] == 0) {
                    unset($_SESSION['carrito'][$productoId]);
                }

                header("Location: $url");
                exit();
            }
        }

        header("Location: $url");
        exit();
        break;
}

?>



<?php
function restatemporal($cantidad, $id)
{
    global $con;
    // if ($cantidad > 1) {
        $cantidadN = $cantidad - 1;
        $sql_cons = "UPDATE inventario SET Cantidad=:Cantidad WHERE id=:id";
        $sql_dato = array(
            array(":Cantidad", $cantidadN),
            array(":id", $id),
        );
        $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
        // if (empty($obj_resp)) {
        //     $rta = 1;
        // } else {
        //     $rta = 2;
        // }
    // } else if ($cantidad == 1) {
    //     $sql_cons = "DELETE FROM inventario WHERE id = :id";
    //     $sql_dato = array(
    //         array(":id", $id)
    //     );
    //     $resp = $con->InAcEl($sql_cons, $sql_dato);
    //     // if (empty($obj_resp)) {
    //     //     $rta = 1;
    //     // } else {
    //     //     $rta = 2;
    //     // }
    // }
}
function sumatemporal($id, $action)
{
    global $con;
    global $carrito;
    if ($action == 1) {
        $inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id = $id");
        $cantidad = $inventario[0][2];
        $cantidadN = $cantidad + 1;
        $sql_cons = "UPDATE inventario SET Cantidad=:Cantidad WHERE id=:id";
        $sql_dato = array(
            array(":Cantidad", $cantidadN),
            array(":id", $id),
        );
        $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
        // if (empty($obj_resp)) {
        //     $rta = 1;
        // } else {
        //     $rta = 2;
        // }
    } else if ($action == 2) {
        foreach ($carrito as $producto) {
            $idp = $producto['id'];
            $cantidadcarrioto = $producto['cantidad'];

            $inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id = $idp");
            $cantidad = $inventario[0][2];
            $cantidadN = $cantidad + $cantidadcarrioto;
            $sql_cons = "UPDATE inventario SET Cantidad=:Cantidad WHERE id=:id";
            $sql_dato = array(
                array(":Cantidad", $cantidadN),
                array(":id", $idp),
            );
            $obj_resp = $con->InAcEl($sql_cons, $sql_dato);
        }
    }
}
?>
