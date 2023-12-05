<?php
require_once('Funciones/funcionesInv.php');
require_once('Conexion/Conexion.php');
session_start();
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
$sql = $con->Listar("SELECT em.*  FROM empleado empl LEFT JOIN empresa em ON empl.Empresa = em.Id 
 where empl.usuario = '$usuario'");

$imgEmpre = $sql[0][7];


if (empty($_SESSION['conexion']) || empty($_SESSION['BD'])) {
    header('Location:index.php');    ?>
    <script>
        window.location = 'index.php';
    </script>

<?php } else {

    $usuario = $_SESSION['usuario'];
    $anno   = 2023;
    $version    = '2023-01';


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta class="viewport" content="width=device-width, initial-scale=1.0, minimun-scalable=1.0">
        </meta>

        <link rel="icon" href="IMAGE/BD/<?php echo $imgEmpre?>" />
        <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="JS/funciones.js"></script>

        <style>
            /* Estilos para el menú */
            .menu {
                z-index: 1;
                list-style: none;
                margin: 0;
                padding: 0;
                background-color: #333;

            }

            .menu li {
                display: inline-block;
                position: relative;
            }

            .menu li a {
                display: block;
                color: #fff;
                padding: 10px 20px;
                text-decoration: none;
            }

            /* Estilos para el menú desplegable */
            .submenu .sub-menu {

                display: none;
                position: absolute;
                background-color: #333;
                top: 100%;
                left: 0;
            }

            .submenu:hover .sub-menu {
                z-index: 1;
                display: block;
            }

            .sub-menu li {

                display: block;
            }

            .sub-menu li a {
                margin-left: -35px;
                padding: 10px 20px;
            }
        </style>
    </head>
    <!-- <div class="col-md-14"> -->
    <ul class="menu" style=" width: 100%; position: fixed; top:1px ; width: 100%; height: 60px;">
        <li><a href="index2.php">Inicio</a></li>
        <?php
        $procesos = $con->Listar("SELECT id, nombre, predecesor FROM procesos where predecesor is NULL");

        for ($i = 0; $i < count($procesos); $i++) { ?>
            <li class="submenu">
                
                <a href="<?php echo $procesos[$i][1] ?>.php"><?php echo $procesos[$i][1] ?></a>

                <?php
                $procesos1 = $con->Listar("SELECT pr.id, pr.nombre, pr.predecesor, pro.Nombre as Nombre_Predecesor FROM procesos pr LEFT JOIN procesos pro ON pr.predecesor = pro.id where pr.predecesor = " . $procesos[$i][0]);
                for ($a = 0; $a < count($procesos1); $a++) {
                    if (!empty($procesos1[$a][3])) { ?>
                        <ul class="sub-menu">

                            <li><a href="<?php echo $procesos1[$a][1] ?>.php"><?php echo $procesos1[$a][1] ?></a></li>

                            <!-- <li><a href="#">Producto 1</a></li>
                    <li><a href="#">Producto 2</a></li>
                    <li><a href="#">Producto 3</a></li> -->
                        </ul>
                <?php  }
                } ?>


            </li>
        <?php        } ?>



        
        <li><a href="contacto.php">Contacto</a></li>
        <img id="Carrito" src="IMAGE/carrito.png" alt="Carrito" style="width: 40px;margin-right: -150px;" title="Carrito">
        <!-- <img id="Carrito" src="IMAGE/carrito.png" alt="Carrito" style="width: 40px; position: absolute; right: 190px; top: 13px;" title="Carrito"> -->
        <li style="position: fixed; left: 1250px;">
            <!-- <li style="margin-left:870px"> -->
            <div style=" width: 250px;margin-top: -5px;color: #fff;text-align:center ;">
                <?php echo $usuario ?> <img src="IMAGE/session/imagen.png" title="Login" alt="" style="width: 50px; ">
                <img id="imagenEnlace" src="IMAGE/session/salirG.png" alt="Salida Segura" style="width: 30px;margin-right: -150px;" title="Salida Segura">

            </div>
        </li>

    </ul>
    <script>
        // Agrega un evento de clic a la imagen
        document.getElementById("imagenEnlace").addEventListener("click", function() {
            // Redirecciona a la página de destino cuando se hace clic en la imagen
            event.preventDefault(); // Evita que el enlace se abra normalmente
            // Redirige al usuario a la página de salida segura
            window.location.replace("index.php");
        });
        document.getElementById("Carrito").addEventListener("click", function() {
            // Redirecciona a la página de destino cuando se hace clic en la imagen
            // event.preventDefault(); // Evita que el enlace se abra normalmente
            // Redirige al usuario a la página de salida segura
            window.location.replace("Carrito.php");
        });
    </script>

    <!-- </div> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        ul li {
            margin: 10px 0;
        }
    </style>
<?php }  ?>