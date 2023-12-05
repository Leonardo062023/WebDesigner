<?php
require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
session_start();
// Obtiene la ruta actual
$ruta_actual = $_SERVER['REQUEST_URI'];

// Guarda la ruta en una variable de sesión
$_SESSION['ruta_actual'] = $ruta_actual;
// $empresa = buscaempresa($usuario);
$thr = "where inv.cantidad > 0 ";
$inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id $thr");
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    if (empty($mensaje)) {
        $mensaje = "";
    }
    unset($_SESSION['mensaje']); // Limpiar el mensaje para que no se muestre nuevamente
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si el formulario ha sido enviado mediante POST

    // Recupera el valor del input con el nombre "txtfiltrar"
    $valorInput = $_POST["txtfiltrar"];
    $thr = "where  inv.nombre LIKE '%$valorInput%' and inv.cantidad > 0";
    $inventario = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id $thr");
}
?>
<script>
    // Define tu función que se ejecutará al cargar la página
    function miFuncionAlCargarPagina(msj) {

        if (msj !== "") {
            $("#modalRespuestas").modal('show');
            $("#mensaje").html(msj);

            $("#Aceptar").click(function() {
                $("#mensaje").modal("hide");

            });
        }

    }
</script>
<style>
    .table tbody td {
        text-align: center;
    }

    .table thead th {
        text-align: center;
    }
</style>

<title>Venta</title>

</head>

<body onload="miFuncionAlCargarPagina('<?php echo $mensaje ?>')" style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 30px;">
    <div class="container-fluid text-center">
        <div class="row content">
            <?php require_once './menu.php'; ?>

            <div class="col-sm-12 text-left" style="margin-top: 10px;">

                <h2 id="forma-titulo3" align="center" style=" margin-bottom: 0px; margin-right: 4px; margin-left: 4px;margin-top: 23px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Venta</h2>
                <div style="margin-left: 77.6%;margin-bottom: 15px;margin-top: -31px;">
                    <form action="venta.php" method="post">
                        <input type="text" id="txtfiltrar" style="width: 240px; display: inline-block;" class="form-control" name="txtfiltrar" title="Buscar Producto" placeholder="Buscar Producto">
                        <input class="btn btn-primary sombra" type="submit" value="Buscar" style="display: inline-block;margin-top: -6px;">
                    </form>
                </div>
                <div class="table-responsive" style=" margin-right: 5px;margin-top:15px;">
                    <div class="table-responsive">
                        <table id="tablaMovimiento" class="table table-striped table-condensed display" cellspacing="0" width="100%">
                            <thead>

                                <tr>



                                    <th><strong> N°</strong></th>
                                    <th width="9%" class="cabeza"><strong>Producto</strong></th>
                                    <th class="cabeza"><strong>Proveedor</strong></th>
                                    <th class="cabeza"><strong>Disponibles</strong></th>
                                    <th class="cabeza"><strong>Valor</strong></th>
                                    <th width="6%" class="cabeza"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $indice = 1;
                                foreach ($inventario as $sql) {
                                    $id = $sql[0];
                                    $Producto = $sql[1];
                                    $Cantidad = $sql[2];
                                    $FechaIng = $sql[3];
                                    if ($FechaExp == '00/00/0000' || empty($FechaExp)) {
                                        $FechaExp = "NA";
                                    }



                                    $ValorU = $sql[5];
                                    // implode('.', str_split($sql[5], 3));
                                    $Proveedor = $sql[7];
                                    $ValorTP = $Cantidad * $sql[5];
                                    $ValorT = $ValorT + $ValorTP;
                                    // $ValorTP = implode('.', str_split($ValorTP, 3));
                                    // $ValorT = implode('.', str_split($ValorT, 3));
                                ?>
                                    <tr class="registro" style="display: <?php echo ($indice <= 7) ? 'table-row' : 'none'; ?>">

                                        <td><?php echo $indice ?></td>

                                        <td class="campos"><?php echo $Producto ?></td>
                                        <td class="campos"><?php echo $Proveedor ?></td>
                                        <td class="campos"><?php echo $Cantidad ?></td>

                                        <td class="campos"><?php echo formatearNumeroConPuntos($ValorU) ?></td>
                                        <td style="text-align: left">
                                            <!-- <a style="margin-left: -30px;" href="json/carritoJson.php?action=4&id=<?php echo base64_encode($sql[0]); ?>">
                                                <img id="imagenEnlace" src="IMAGE/restar.png" alt="Eliminar" style="width: 40px;" title="Eliminar"><i title="Eliminar" class="glyphicon glyphicon-trash"></i>
                                            </a> -->
                                            <a href="json/carritoJson.php?action=1&id=<?php echo base64_encode($sql[0]); ?>">
                                                <img id="imagenEnlace"  src="IMAGE/Agregar.png" alt="Agregar" style="width: 40px;" title="Agregar"><i title="Agregar" class="glyphicon glyphicon-edit"></i>
                                               
                                            </a>
                                        </td>
                                    </tr>

                                <?php
                                    $indice = $indice + 1;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        $indice = $indice - 1;
                        if ($indice <= 7) {
                            $resulta = 1;
                            $btnsig = "display: none;";
                        } else {
                            $resulta = floor($indice / 7) + 1;
                            $btnsig = "style='display: block;'";
                        }
                        ?>
                        <div align="right" style="white-space: nowrap;">
                            <div style="display: inline-block">
                                <button id="anteriorPagina" style="display: none;background-color: white;border-radius: 9px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" onclick="var resultado = contadormen(<?php echo $resulta ?>);">Anterior</button>
                            </div>
                            <div id="inipag" style="display: inline-block"> Pág 1 de <?php echo $resulta; ?></div>
                            <div style="display: inline-block">
                                <button id="siguientePagina" style="<?php echo $btnsig ?>;background-color: white;border-radius: 9px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" onclick="var resultado = contador(<?php echo $resulta ?>);">Siguiente</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'footer.php'; ?>
</body>

<script>
    function filtrar() {
        //  Obtén el elemento input por su ID
        var inputElement = document.getElementById('txtfiltar');
        // Obtiene el valor del input
        var valorInput = inputElement.value;
        alert("" + valorInput);

    }
</script>

<script type="text/javascript">
    // Variable global para llevar el conteo
    var conteo = 1;

    function contador(resulta) {
        // Incrementar el conteo cada vez que se presione el botón

        if (conteo < resulta) {
            conteo++;
            $("#inipag").html('Pág ' + conteo + ' de ' + resulta);
        }
        if (conteo > 1) {
            document.getElementById("anteriorPagina").style.display = "block";
        }
        if (conteo == resulta) {
            document.getElementById("siguientePagina").style.display = "none";
        }
    }

    function contadormen(resulta) {
        // Incrementar el conteo cada vez que se presione el botón
        if (conteo > 1) {
            conteo--;
            $("#inipag").html('Pág ' + conteo + ' de ' + resulta);
            document.getElementById("siguientePagina").style.display = "block";
        }
        if (conteo <= 1) {
            document.getElementById("anteriorPagina").style.display = "none";

        }
    }
</script>

<script>
    const registrosPorPagina = 7;
    let paginaActual = 1;

    document.getElementById("siguientePagina").addEventListener("click", function() {
        const registros = document.querySelectorAll(".registro");
        const totalPaginas = Math.ceil(registros.length / registrosPorPagina);

        if (paginaActual < totalPaginas) {
            const inicio = (paginaActual * registrosPorPagina);
            const fin = inicio + registrosPorPagina;

            registros.forEach((registro, indice) => {
                if (indice >= inicio && indice < fin) {
                    registro.style.display = "table-row";
                } else {
                    registro.style.display = "none";
                }
            });
            paginaActual++;
        }
    });

    document.getElementById("anteriorPagina").addEventListener("click", function() {
        if (paginaActual > 1) {
            const registros = document.querySelectorAll(".registro");
            const inicio = ((paginaActual - 2) * registrosPorPagina);
            const fin = inicio + registrosPorPagina;

            registros.forEach((registro, indice) => {
                if (indice >= inicio && indice < fin) {
                    registro.style.display = "table-row";
                } else {
                    registro.style.display = "none";
                }
            });

            paginaActual--;
        }
    });
</script>



<?php

function formatearNumeroConPuntos($numero)
{
    $numero_str = strval($numero);
    $longitud = strlen($numero_str);

    if ($longitud > 3) {
        $posicion = $longitud % 3;
        $numero_formateado = substr($numero_str, 0, $posicion);

        for ($i = $posicion; $i < $longitud; $i += 3) {
            $numero_formateado .= ($i > 0 ? '.' : '') . substr($numero_str, $i, 3);
        }
    } else {
        $numero_formateado = $numero_str;
    }
    $numero_formateado = "$" . $numero_formateado;
    return $numero_formateado;
}
?>


<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
<div class="modal fade" id="modalRespuestas" role="dialog" align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="forma-modal" class="modal-header">
                <h4 class="modal-title" id="modal-title" style="font-size: 24; padding: 3px;"></h4>
            </div>
            <div class="modal-body" style="margin-top: 8px">
                <label id="mensaje" name="mensaje" style="font-weight: normal"></label>
            </div>
            <div id="forma-modal" class="modal-footer">
                <button type="button" id="Aceptar" class="btn" style="color: #000; margin-top: 2px" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
</html>