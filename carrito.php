<?php
require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
session_start();
// Obtiene la ruta actual
$ruta_actual = $_SERVER['REQUEST_URI'];

$concarrito = count($_SESSION['carrito']);
// Guarda la ruta en una variable de sesión
$_SESSION['ruta_actual'] = $ruta_actual;
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    if (empty($mensaje)) {
        $mensaje = "";
    }
    unset($_SESSION['mensaje']); // Limpiar el mensaje para que no se muestre nuevamente
}
?>
<style>

    #imagenEnlace:hover {
        transform: scale(1.1);
    }
</style>
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
        // Datoscomprador();

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

<title>Carrito</title>

</head>

<body onload="miFuncionAlCargarPagina('<?php echo $mensaje ?>')" style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 30px;">
    <div class="container-fluid text-center">
        <div class="row content">
            <?php require_once './menu.php'; ?>

            <div class="col-sm-12 text-left" style="margin-top: 10px;">

                <h2 id="forma-titulo3" align="center" style=" margin-bottom: 0px; margin-right: 4px; margin-left: 4px;margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Carrito de Compras</h2>

                <div class="table-responsive" style=" margin-right: 5px;margin-top:5px;">
                    <div class="table-responsive">
                        <?php
                        session_start();

                        if (isset($_SESSION['carrito']) && $concarrito > 0) {
                            $indice = 1;
                        ?>
                            <table id="tablaMovimiento" class="table table-striped table-condensed display" cellspacing="0" width="100%">
                                <thead>

                                    <tr>



                                        <th><strong> N°</strong></th>
                                        <th width="9%" class="cabeza"><strong>Producto</strong></th>
                                        <th class="cabeza"><strong>Proveedor</strong></th>
                                        <th class="cabeza"><strong>Cantidad</strong></th>
                                        <th class="cabeza"><strong>Valor U</strong></th>
                                        <th class="cabeza"><strong>Valor TP</strong></th>
                                        <th width="6%" class="cabeza"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($_SESSION['carrito'] as $producto) {
                                        $id = $producto['id'];
                                        $producto1 = $con->Listar("SELECT inv.*, pro.nombre FROM Inventario inv INNER JOIN proveedores pro ON inv.Proveedores = pro.Id where inv.id = $id");
                                        // $NomProducto = $producto1['nombre'];
                                        $NomProducto = $producto1[0][1];
                                        $Cantidad = $producto['cantidad'];
                                        // $ValorU = $producto1['precio'];
                                        $ValorU = $producto1[0][5];

                                        // implode('.', str_split($sql[5], 3));
                                        $Proveedor = $producto1[0][7];
                                        $ValorTP = $Cantidad * $ValorU;
                                        $ValorT = $ValorT + $ValorTP;
                                        // $ValorTP = implode('.', str_split($ValorTP, 3));
                                        // $ValorT = implode('.', str_split($ValorT, 3));
                                    ?>
                                        <tr class="registro" style="display: <?php echo ($indice <= 6) ? 'table-row' : 'none'; ?>">

                                            <td><?php echo $indice ?></td>

                                            <td class="campos"><?php echo $NomProducto ?></td>
                                            <td class="campos"><?php echo $Proveedor ?></td>
                                            <td class="campos"><?php echo $Cantidad ?></td>


                                            <td class="campos"><?php echo formatearNumeroConPuntos($ValorU) ?></td>
                                            <td class="campos"><?php echo formatearNumeroConPuntos($ValorTP) ?></td>
                                            <td style="text-align: left">
                                                <!-- Inicio Generar  Infrome  -->
                                                <a style="margin-left: -30px;" href="json/carritoJson.php?action=4&id=<?php echo base64_encode($id); ?>">
                                                    <img id="imagenEnlace" class="movimiento" src="IMAGE/restar.png" alt="Restar" style="width: 40px;" title="Restar"><i title="Restar" class="glyphicon glyphicon-trash"></i>
                                                </a>
                                                <!-- Fin Generar  Infrome  -->
                                                <!-- Inicio Vaciar  Carrito  -->
                                                <a href="json/carritoJson.php?action=1&id=<?php echo base64_encode($id); ?>">
                                                        
                                                </a>
                                                <!-- Fin Vaciar  Carrito  -->
                                            </td>
                                        </tr>


                                    <?php
                                        $indice = $indice + 1;
                                        if ($indice <= 7) {
                                            $resulta = 1;
                                            $btnsig = "display: none;";
                                        } else {
                                            $resulta = floor($indice / 6) + 1;
                                            $btnsig = "style='display: block;'";
                                        }
                                    }

                                    ?>
                                </tbody>
                                <tfoot style="text-align: center;">
                                    <tr>
                                        <td colspan="5">
                                        </td>
                                        <td>
                                            Total<b> <?php echo formatearNumeroConPuntos($ValorT) ?> </b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div align="right" style="white-space: nowrap;">
                                <div style="display: inline-block">
                                    <button id="anteriorPagina" style="display: none;background-color: white;border-radius: 9px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" onclick="var resultado = contadormen(<?php echo $resulta ?>);">Anterior</button>
                                </div>
                                <div id="inipag" style="display: inline-block"> Pág 1 de <?php echo $resulta; ?></div>
                                <div style="display: inline-block">
                                    <button id="siguientePagina" style="<?php echo $btnsig ?>;background-color: white;border-radius: 9px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" onclick="var resultado = contador(<?php echo $resulta ?>);">Siguiente</button>
                                </div>
                            </div>

                            <div style="margin-left: 50%;margin-bottom: 15px;margin-top: -60px;">
                                <a href="#" onclick="GenerarCompra();">
                                    <img id="imagenEnlace" src="IMAGE/comfirmarcompra.png" alt="Confirmar compra" style="margin-top: 0px;width: 70px;position: fixed; left: 45%;" title="Confirmar compra">
                                </a>
                                <form name="form" id="form" class="form-horizontal" action="javascript:EliminaTodo();">
                                    <button type="submit" class="btn btn-primary sombra" style=" margin-top: 18px; margin-bottom: 10px; margin-left: 0px;">Vaciar Carrito</button>
                                </form>

                            </div>
                        <?php

                        } else { ?>
                            <img id="imagenEnlace" class="movimiento" src="IMAGE/carrito.png" alt="Confirmar compra" style="margin-top: 6.2%; width: 200px; position: fixed; left: 44%; transition: transform 0.5s ease-in-out;" title="Confirmar compra" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                            
                            
                            <!-- <img id="imagenEnlace" src="IMAGE/carrito.png" alt="Confirmar compra" style="margin-top: 6.2%;width: 200px;position: fixed; left: 44%;" title="Confirmar compra"> -->
                            <h2 style=" color: red;margin-bottom: 0px; margin-right: 4px; margin-left: 50%;margin-top: 290px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><i> Vacio</i></h2>
                        <?php    } ?>

                    </div>
                </div>

            </div>
        </div>
        <?php require_once 'footer.php'; ?>
</body>
<script>
    document.getElementsByClassName("movimiento").addEventListener("mouseout", function() {
        this.style.transform = "scale(1)";
        
    }); 
</script>
<script>
    function EliminaTodo() {
        $("#modalRespuestas").modal('show');
        $("#mensaje").html('¿Desea vaciar el carrito? ');

        $("#Aceptar").click(function() {
            var formData = new FormData($("#form")[0]);

            $.ajax({
                type: 'POST',
                url: " json/carritoJson.php?action=3",
                data: formData,
                contentType: false,
                processData: false,
            });

            window.history.back();
        });
    }


    function restaBD(nombreComprador, numeroDocumento, MedioPago) {

        var formData = new FormData($("#form")[0]);
        $.ajax({
            type: 'POST',
            url: " json/comprasJson.php?action=1&nom=" + nombreComprador + "&num=" + numeroDocumento + "&Med=" + MedioPago,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                // console.log(response);

                if (response == 1) {
                    alert("Compra Exitosa");

                } else {
                    alert("Lamentamos pero no se puede realizar compra");

                }
            }
        });
        location.reload();
        // EliminaCompra();
    }

    function GenerarCompra() {
        $("#modalRespuestas").modal('show');
        $("#mensaje").html('¿Desea realizar la compra? ');

        $("#Aceptar").click(function() {
            $("#modalFormulario").modal('show');
            $("#AceptarForm").click(function() {

                var nombreComprador = $("#txtComprador").val();
                var numeroDocumento = $("#txtDocumento").val();
                var MedioPago = $("#MedioPago").val();

                if (nombreComprador == "" || numeroDocumento == "") {
                    alert("Todos los campos son obligatorios");
                } else {

                    window.open('Informes/FacturaVenta.php?Com=' + btoa(nombreComprador) + '&Doc=' + btoa(numeroDocumento) + '&MeP=' + btoa(MedioPago), '_blank');
                    restaBD(nombreComprador, numeroDocumento, MedioPago);

                    // EliminaCompra();

                }


            });
        });
    }
</script>
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
    const registrosPorPagina = 6;
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

<div class="modal fade" id="modalFormulario" role="dialog" align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Contenido del formulario -->
            <form id="Datoscomprador">
                <div id="forma-modal" class="modal-header">
                    <h2 id="forma-titulo3" style=" margin-bottom: 0px; margin-right: 4px; margin-left: 70px;margin-top: 24px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">DATOS DEL COMPRADOR</h2>
                </div>
                <div class="modal-body" style="margin-top: 8px">
                    <h2 id="comprador" align="center" style="margin-left: 79px;display: inline-block;font-size: 20px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Comprador:</h2>
                    <input type="text" name="txtComprador" id="txtComprador" style="margin-left: 20px;display: inline-block;width: 250px;" class="form-control" maxlength="100" value="" title="Comprador" placeholder="Nombre del Comprador" required>
                    <br>
                    <h2 id="comprador" align="center" style="margin-left: 47px;display: inline-block;font-size: 20px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">N° Documento:</h2>
                    <input type="text" name="txtDocumento" id="txtDocumento" onkeypress="return txtValidas(event,'num')" style="margin-left: 20px;display: inline-block;width: 250px;" class="form-control" maxlength="100" value="" title="Comprador" placeholder="Documento del Comprador" required>
                    <br>
                    <h2 id="comprador" align="center" style="margin-left: -90px;display: inline-block;font-size: 20px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Medio de Pago:</h2>

                    <select name="MedioPago" id="MedioPago" style="margin-left: 20px;border: 0px;" title="MedioPago">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>
                <div id="forma-modal" class="modal-footer">
                    <button type="button" id="AceptarForm" class="btn" style="color: #000; margin-top: 2px" data-dismiss="modal">Comprar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>