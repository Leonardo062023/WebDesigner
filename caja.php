<?php
require_once('Conexion/Conexion.php');
$con = new conexionPDO();
require_once 'menu.php';
$usuario = $_SESSION['usuario'];
$sql = $con->Listar("SELECT em.*  FROM empleado empl LEFT JOIN empresa em ON empl.Empresa = em.Id 
 where empl.usuario = '$usuario'");

$razonsocial = $sql[0][2];
$mision = $sql[0][3];
$vision = $sql[0][4];
$imgEmpre = $sql[0][7];

?>

<style>
    /* tabla */
    .table {
        margin-top: 20px;
        margin-left: 25%;
        width: 50%;
        text-align: center;

    }

    .table thead tr {
        background-color: grey;
    }

    .table thead td {
        text-align: center;
        width: 50%;
    }

    .table tbody td {
        text-align: center;
    }


    /* carrucel */
    h1 {
        text-align: center;
    }

    #carrusel-caja {
        -moz-animation: automatizacion 7s infinite linear;
        -o-animation: automatizacion 7s infinite linear;
        -webkit-animation: automatizacion 7s infinite linear;
        animation: automatizacion 7s infinite linear;

        -webkit-transition: all 0.75s ease;
        -moz-transition: all 0.75s ease;
        -ms-transition: all 0.75s ease;
        -o-transition: all 0.75s ease;
        transition: all 0.75s ease;

        height: 500px;
        width: 300%;
    }

    #carrusel-contenido {
        margin: 0 auto;
        overflow: hidden;
        text-align: left;
    }

    .imagenes {
        border-radius: 25px;
        height: 500px;
        width: 90%;
    }

    .carrusel-elemento {
        text-align: center;
        float: left;
        width: 33.333%;
    }

    @-moz-keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }

    @-webkit-keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }

    @keyframes automatizacion {
        0% {
            margin-left: 0;
        }

        30% {
            margin-left: 0;
        }

        35% {
            margin-left: -100%;
        }

        65% {
            margin-left: -100%;
        }

        70% {
            margin-left: -200%;
        }

        95% {
            margin-left: -200%;
        }

        100% {
            margin-left: 0;
        }
    }
</style>
<title>Caja</title>
</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 36px;">
    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-12 text-left">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> OPCIONES DE CAJA</h2>

            </div>
            <div class="col-sm-6 text-left">
                <H4 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> VENTAS DEL DIA</H4>
                <a href="Informes/informeVenta.php?action=1" target="_blank">
                    <img id="imagenEnlace" src="IMAGE/informe.png" alt="Informe" style="margin-top: 10px;width: 70px;position: fixed; left: 23%;" title="Informe">
                </a>
            </div>
            <div class="col-sm-6 text-left">
                <H4 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> VENTAS DEL MES</H4>
                <a href="Informes/informeVenta.php?action=2" target="_blank">
                    <img id="imagenEnlace" src="IMAGE/informe.png" alt="Informe" style="margin-top: 10px;width: 70px;position: fixed; left: 73%;" title="Informe">
                </a>
            </div>
            <div class="col-sm-6 text-left" style="margin-top: 110px;">
                <H4 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> VENTAS DEL AÑO</H4>
                <a href="Informes/informeVenta.php?action=3" target="_blank">
                    <img id="imagenEnlace" src="IMAGE/informe.png" alt="Informe" style="margin-top: 10px;width: 70px;position: fixed; left: 23%;" title="Informe">
                </a>
            </div>
            <div class="col-sm-6 text-left" style="margin-top: 110px;">
                <form name="form" id="form" class="form-horizontal" action="javascript:BuscarporFechas();">
                    <H4 align="center" style=" margin-top: 30px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">ENTRE FECHAS :</H4>

                    <div style="display: inline-block;">
                        <input type="date" name="txtFechaInicial" id="txtFechaInicial" style="margin-left: 200px;margin-top: 15px;width: 150px;" class="form-control" maxlength="100" value="" title="Fecha Inicial" placeholder="Fecha Inicial" required>
                    </div>
                    A
                    <div style="display: inline-block;">
                        <input type="date" name="txtFechaFinal" id="txtFechaFinal" style="width: 150px;" class="form-control" maxlength="100" value="" title="Fecha Final" placeholder="Fecha Final" required>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <label for="no" class="col-sm-5 control-label"></label>
                        <button type="submit" class="btn btn-primary sombra" style=" margin-top: 10px; margin-bottom: 10px; margin-left: 0px;">Buscar</button>
                    </div>
                </form>
            </div>



        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
<script>
    function BuscarporFechas() {
        var FechaInicial = $("#txtFechaInicial").val();
        var FechaFinal = $("#txtFechaFinal").val();

        if (FechaInicial == "" || FechaFinal == "") {
            alert("Todos los campos son obligatorios");
        } else {

            window.open('Informes/informeVenta.php?action=4 & Ini=' + btoa(FechaInicial) + '&Fin=' + btoa(FechaFinal), '_blank');

        }
    }
</script>
<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>