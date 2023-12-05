<?php
require_once 'menu.php';
$con = new conexionPDO();
$usuario = $_SESSION['usuario'];
$sql = $con->Listar("SELECT em.*  FROM empleado empl LEFT JOIN empresa em ON empl.Empresa = em.Id 
 where empl.usuario = '$usuario'");
$nit = $sql[0][1];
$razonsocial = $sql[0][2];
$mision = $sql[0][3];
$vision = $sql[0][4];
$direccion = $sql[0][5];
$telefono = $sql[0][6];
$maps = $sql[0][8];

?>
<title>Productos</title>
</head>

<body style="background-image: url(IMAGE/FONDOPAG.jpg); background-repeat: no-repeat; background-size: cover;margin-top: 38px;">
    <div class="container-fluid text-center">
        <div class="row content" style="margin-top: 1px;">
            <div class="col-sm-12 text-left">
                <h2 align="center" style=" margin-top: 30px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> CONTACTENOS MEDIANTE</h2>

            </div>

            <div class="col-sm-6 text-right">
                <h5 style=" margin-top: 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> WHATSAPP:</h5>
            </div>
            <div class="col-sm-6 text-left ">
                <img style=" margin-top: 10px; height: 30px; width: 12%;" src="IMAGE/icoWha.png" onclick="abrirNuevaVentana(2)">
            </div>
            <div class="col-sm-6 text-right">
                <h5 style=" margin-top: 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> FACEBOOK:</h5>
            </div>
            <div class="col-sm-6 text-left ">
                <img style=" margin-top: 10px; margin-left: 15px; height: 26px; width: 7%;" src="IMAGE/icoFac.png" onclick="abrirNuevaVentana(1)">
            </div>
            <div class="col-sm-6 text-right">
                <h5 style=" margin-top: 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> TELEFONO:</h5>
            </div>
            <div class="col-sm-6 text-left ">
                <h6 style=" margin-top: 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <?php echo $telefono ?></h6>
            </div>
            <div class="col-sm-6 text-right">
                <h5 style=" margin-top: 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> DIRECCION:</h5>
            </div>
            <div class="col-sm-6 text-left ">

                <h6 style=" margin-top: 10px;margin-bottom:10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> <?php echo $direccion ?></h6>
            </div>

            <div class="col-sm-12 text-center ">
                <iframe src="<?php echo $maps ?>" width="600" height="340" style="border-radius:25px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
<script>
    function abrirNuevaVentana($ir) {
        if ($ir == 1) { //facebook
            window.open('https://www.facebook.com/');
        } else if ($ir == 2) {
            window.open('https://web.whatsapp.com/');
        }

    }
</script>


<script src="JS/jquery-3.7.1.min.js"></script>
<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>

</html>