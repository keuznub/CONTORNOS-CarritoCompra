//DELETE LINKS TO SUBMIT
document.addEventListener('DOMContentLoaded', function () {
    var deleteForm = document.querySelectorAll(".deleteForm");
    var deleteFormArray = Array.from(deleteForm);
    var alerta = document.getElementById("alerta");
    var alertAdminSuccess = document.getElementById("alertAdminSuccess");
    var alertAdminFail = document.getElementById("alertAdminFail");
    var logoutForm = document.querySelector(".logoutForm");
    var insertForm = document.getElementById("insertForm");
    var carritoAlert = document.getElementById("carritoAlert");
    console.log(logoutForm);
    var logoutLink = document.querySelector(".logoutLink");
    if (logoutLink != null) {
        logoutLink.addEventListener('click', function (event) {
            event.preventDefault();
            logoutForm.submit();
        });
    }
    
    if(insertForm != null){
        
        insertForm.addEventListener("submit", function(event){
            var imagenSplitted = document.getElementById("imagen").value.split(".");
            var imagen = imagenSplitted[imagenSplitted.length-1].toLowerCase();
            if(imagen != "jpg" && imagen !="png"){
                alert("Formato de imagen no soportado, requerido jpg o png");
                event.preventDefault();
            }
        })
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
        mensajeError("Se ha añadido correctamente",alertAdminSuccess, "admin.php");
    }
    if (alertAdminFail != null) {
        console.log(alertAdminFail);
        mensajeError("Error al insertar",alertAdminFail, "admin.php");
    }
    if (alerta != null) {
        console.log(alerta);
        mensajeError("Usuario y/o contraseña erroneo(s)",null,"login.php");
    }
    if (carritoAlert != null) {  
        mensajeError("Logeate primero para acceder a tu carrito",carritoAlert,"login.php?toCarrito=true");
    }
});


function validate(){


}

function mensajeError(mensaje,alerta, url) {
    var alerta = alerta || document.getElementById("alerta");
    alerta.textContent = mensaje;
    alerta.style.opacity = "100%";
    history.replaceState({}, "", url);
    setTimeout(function (e) {
        alerta.style.opacity = "0%";
    }, 3500);

}

