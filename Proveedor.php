<?php
require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
// $empresa = buscaempresa($usuario);
$inventario = $con->Listar("SELECT * FROM proveedores");

?>
<style>
    /* .table tbody td {
        text-align: center;
    } */

    .table thead th {
        text-align: center;
        border: 100px;
        border-right: #000;
    }
</style>

<title>Inventario</title>

</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 30px;">
    <div class="container-fluid text-center">
        <div class="row content">
            <?php require_once './menu.php'; ?>

            <div class="col-sm-12 text-left">
                <h2 id="forma-titulo3" align="center" style="margin-top: 0px; margin-bottom: 20px; margin-right: 4px; margin-left: 4px;margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Proveedores</h2>
                <div align="center" class="table-responsive" style="margin-right: 5px;margin-top:-10px;">
                    <div align="center" class="table-responsive" style="border-radius: 10px;width: 50%;">
                        <table id="tablaMovimiento" class="table table-striped table-condensed display" cellspacing="0" width="50%">
                            <thead>

                                <tr>
                                    <th width="7%" class="cabeza"></th>
                                    <th width="1%"><strong> N°</strong></th>
                                    <th width="20%" class="cabeza"><strong>Proveedor</strong></th>
                                    <th width="20%" class="cabeza"><strong>Nit</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $indice = 1;
                                foreach ($inventario as $sql) {
                                    $id = $sql[0];
                                    $Proveedor = $sql[1];
                                    $Nit = $sql[2];

                                ?>
                                    <tr class="registro" style="text-align: center;display: <?php echo ($indice <= 8) ? 'table-row' : 'none'; ?>">
                                        <td>
                                            <a href="#" onclick="javascript:eliminar(<?php echo $sql[0]; ?>);">
                                                <img id="imagenEnlace" src="IMAGE/Eliminar.png" alt="Eliminar" style="width: 30px;" title="Eliminar"><i title="Eliminar" class="glyphicon glyphicon-trash"></i>
                                            </a>
                                            <a href="ModificarProveedor.php?action=2&id=<?php echo base64_encode($sql[0]); ?>">
                                                <img id="imagenEnlace" src="IMAGE/Modifica.png" alt="Modificar" style="width: 30px;" title="Modificar"><i title="Modificar" class="glyphicon glyphicon-edit"></i>
                                            </a>
                                        </td>
                                        <td><?php echo $indice ?></td>

                                        <td class="campos"><?php echo $Proveedor ?></td>
                                        <td class="campos"><?php echo $Nit ?></td>
                                    </tr>

                                <?php
                                    $indice = $indice + 1;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        $indice = $indice - 1;
                        if ($indice <= 8) {
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
                                <button id="siguientePagina" style="<?php echo $btnsig ?>;background-color: white;border-radius: 9px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"   onclick="var resultado = contador(<?php echo $resulta ?>);">Siguiente</button>
                            </div>
                        </div>

                        <div>

                            <a href="ModificarProveedor.php?action=1">
                                <img id="imagenEnlace" src="IMAGE/Nuevo.png" alt="Agregar" style="margin-top: -25px;width: 70px;position: fixed; left: 50%;" title="Agregar">
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'footer.php'; ?>
</body>
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
    const registrosPorPagina = 8;
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





<script type="text/javascript">
    function eliminar(id) {
        $("#modalRespuestas").modal('show');
        $("#mensaje").html('¿Desea eliminar el producto del inventario? ');

        $("#Aceptar").click(function() {

            var form_data = {
                action: 3,
                id: id
            };
            $.ajax({
                type: "POST",
                url: "json/ProveedorJson.php?action=3",
                data: form_data,
                success: function(response) {

                    if (response == 1) {
                        // $("#modal-title").html('');
                        $("#mensaje").html('Información Eliminada Correctamente');
                        $("#modalRespuestas").modal("show");
                        $("#Aceptar").click(function() {
                            $("#modalRespuestas").modal("hide");
                            document.location = 'Proveedor.php';
                        })
                    } else {
                        // $("#modal-title").html('');
                        $("#mensaje").html('No Se Ha Podido Eliminar Información');
                        $("#modalRespuestas").modal("show");
                        $("#Aceptar").click(function() {
                            $("#mensaje").modal("hide");
                        })

                    }
                }
            });
        });
    }
</script>


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

<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>