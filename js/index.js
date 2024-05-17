//DELETE LINKS TO SUBMIT
document.addEventListener('DOMContentLoaded', function () {
    var deleteForm = document.querySelectorAll(".deleteForm");
    var deleteFormArray = Array.from(deleteForm);
    var alerta = document.getElementById("alerta");
    var alertAdminSuccess = document.getElementById("alertAdminSuccess");
    var alertAdminFail = document.getElementById("alertAdminFail");
    var logoutForm = document.querySelector(".logoutForm");
    console.log(logoutForm);
    var logoutLink = document.querySelector(".logoutLink");
    if (logoutLink != null) {
        logoutLink.addEventListener('click', function (event) {
            event.preventDefault();
            logoutForm.submit();
        });
    }

    deleteFormArray.forEach(element => {
        var deleteID = element.querySelector(".deleteID").value;
        console.log("Elemento de " + deleteID);
        var deleteLink = element.querySelector(".deleteLink");
        deleteLink.addEventListener('click', function (event) {
            event.preventDefault();
            element.submit();
        });
    });

    if (alertAdminSuccess != null) {
        console.log(alertAdminSuccess);
        mensajeError("Se ha añadido correctamente",alertAdminSuccess);
    }
    if (alertAdminFail != null) {
        console.log(alertAdminFail);
        mensajeError("Error al insertar",alertAdminFail);
    }
    if (alerta != null) {
        console.log(alerta);
        mensajeError("Usuario y/o contraseña erroneo(s)",null);
    }
});


function validate(){
    var imagenSplitted = document.getElementById("imagen").value.split(".");
    var imagen = strtolower(imagenSplitted[imagenSplitted.length-1]);

    if(imagen != "png" && imagen != "jpg"){
        mensajeError("Formato de imagen inadecuado");
        return false;
    }
    console.log("Todo bien");
    return true;

}

function mensajeError(mensaje,alerta) {
    var alerta = alerta || document.getElementById("alerta");
    console.log(alerta.textContent);
    alerta.textContent = mensaje;
    alerta.style.opacity = "100%";
    history.replaceState({}, "", "login.php");
    setTimeout(function (e) {
        alerta.style.opacity = "0%";
    }, 3500);

}

