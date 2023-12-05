

<?php 


$version = 'WEB DESIGNER V.01.2023';
if (!empty($_SESSION['usuario']) ) { ?>
    <div style="background-color: #333; margin-top: 30px; margin-bottom: 0px  ; padding: 20px;position: fixed; bottom: -10px; width: 100%; height: 60px;">
        <a align="center" style="margin-left:84.1% ;color: #fff;" >
        <img class="imagenes" src="IMAGE/LOGO.png" style="width: 55px; height: 50px;margin-top: -14px;"><?php echo $version ?>
        </a>
    </div>
<?php } ?>

<script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    function jsRemoveWindowLoad() {
        // eliminamos el div que bloquea pantalla
        $("#WindowLoad").remove();
    }

    function jsShowWindowLoad(mensaje) {
        //eliminamos si existe un div ya bloqueando
        jsRemoveWindowLoad();
        //si no enviamos mensaje se pondra este por defecto
        if (mensaje === undefined)
            mensaje = "Procesando la información<br>Espere por favor";
        //centrar imagen gif
        height = 20; //El div del titulo, para que se vea mas arriba (H)
        var ancho = 0;
        var alto = 0;
        //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
        if (window.innerWidth == undefined)
            ancho = window.screen.width;
        else
            ancho = window.innerWidth;
        if (window.innerHeight == undefined)
            alto = window.screen.height;
        else
            alto = window.innerHeight;
        //operación necesaria para centrar el div que muestra el mensaje
        var heightdivsito = alto / 2 - parseInt(height) / 2; //Se utiliza en el margen superior, para centrar 
        //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
        imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div  style='color:#FFFFFF;margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold;color:#1075C1'>" + mensaje + "</div><img src='IMAGE/loading.gif'/></div>";
        //creamos el div que bloquea grande------------------------------------------
        div = document.createElement("div");
        div.id = "WindowLoad";
        div.style.width = ancho + "px";
        div.style.height = alto + "px";
        $("body").append(div);
        //creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
        input = document.createElement("input");
        input.id = "focusInput";
        input.type = "text";
        //asignamos el div que bloquea
        $("#WindowLoad").append(input);
        //asignamos el foco y ocultamos el input text
        $("#focusInput").focus();
        $("#focusInput").hide();
        //centramos el div del texto
        $("#WindowLoad").html(imgCentro);

    }
</script>

<style>
    #WindowLoad {
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 3200;
        filter: alpha(opacity=80);
        -moz-opacity: 80;
        opacity: 0.80;
        background: #FFF;
    }
</style>