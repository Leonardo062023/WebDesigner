function txtValidas(event, restrictionType) {


    switch (restrictionType) {
        case 'num':
            var key = event.keyCode;
            // Permitir solo números (0-9) y la tecla de retroceso (backspace)
            if ((key >= 48 && key <= 57) || key == 8) {
                return true;
            } else {
                return false;
            }
            break
        case 'car':
            var key = event.keyCode || event.which;
            var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "abcdefghijklmnopqrstuvwxyz";

            if (letras.indexOf(tecla) === -1) {
                return false;
            }
            return true;
            break;
        default:
            return true; // Permitir cualquier otro carácter para otros campos
            break;
    }
}
function capitalizarPrimeraLetra(nombre) { // La primera letra Mayuscula-----------------------------------------------------------
    if (nombre.length === 0) {
        return nombre;
    }

    return nombre.charAt(0).toUpperCase() + nombre.slice(1).toLowerCase();
}

function capitalizarPrimeraLetraDeCadaPalabra(nombre) { // La inicia de cada palabra-----------------------------------------------------------
    // Dividir el nombre en palabras
    var palabras = nombre.split(" ");
    var resultado = [];

    // Capitalizar la primera letra de cada palabra y convertir el resto a minúscula
    for (var i = 0; i < palabras.length; i++) {
        var palabra = palabras[i].toLowerCase(); // Convertir a minúscula
        palabra = palabra.charAt(0).toUpperCase() + palabra.slice(1);
        resultado.push(palabra);
    }

    // Unir las palabras capitalizadas de nuevo en una cadena
    return resultado.join(" ");
}
