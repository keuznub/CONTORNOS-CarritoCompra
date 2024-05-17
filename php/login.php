<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Carrito Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <header>
     
    </header>
    <main>
        <div class="container py-4 ms-auto">
            <form class="row" action="" method="post">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <span class="h2">BreixoComponentes</span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12" style="max-width: 200px;">
                        <img src="../imagen/bcComponentes.png" alt="" width="100%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="usuario" name="usuario" placeholder="" required>
                            <label for="usuario">Usuario</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="contraseña" name="contraseña" placeholder="" required>
                            <label for="contraseña">Contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4 mt-3">
                        <input class="form-control btn btn-outline-primary" type="submit" value="Log In">
                    </div>
                </div>
            </form>
            <br>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>