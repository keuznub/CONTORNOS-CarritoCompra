<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Carrito Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php
    if (isset($_POST["delete"])) {
        $self = $_SERVER['PHP_SELF'];
        $statement = $conexion->prepare("DELETE * FROM carrito WHERE userId = ? && productID = ?");
        $statement->bind_param("ii", $idUsuario, $_POST["deleteProductID"]);
        $statement->execute();
        header("Location: $self");
    }
    ?>
    <header>
        <nav class="navbar navbar-collapse fixed-top">
            <div class="container-fluid">
                <div>
                    <a class="navbar-brand" href="index.php">
                        <img src="../imagen/bcComponentes.png" alt="" style="width:40px;">
                        <span class="nombreLogo">BComponentes</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCatalogos" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>


                <form action="" method="post" class="input-group buscador" style="width: 20%">
                    <input type="text" class="form-control" placeholder="Buscar..." aria-describedby="basic-addon2">
                    <input type="submit" class="btnbuscar btn btn-secondary" value="Buscar">
                </form>


                <button class="btn btn-hover" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><img src="../imagen/carrito.png" width="20">
                    <div class="badge bg-danger rounded-circle position-relative" style="top: -10px; left: -10px;">
                        <?php echo count($arrayCarrito) ?>
                    </div>
                    <span class="micarrito">
                        Mi Carrito
                    </span>
                </button>


                <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header">
                        <?php if ($usuario->getCategoria() == "anonimo") : ?>
                            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><img src="../imagen/carrito.png" width="20">Carrito</h5>
                        <?php endif; ?>
                        <?php if ($usuario->getCategoria() != "anonimo") : ?>
                            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><img src="../imagen/carrito.png" width="20">Carrito de <?php echo $usuario->getUsuario() ?></h5>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group">
                            <!--PHP-->
                            <?php foreach ($arrayCarrito as $i) : ?>
                                <li class="list-group-item mb-3">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="h4">
                                                <?php
                                                echo $i->getNombre();
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-2 text-end">
                                            <div class="">x<span class="cantidad"><?php echo $i->getCantidad() ?></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            <span class="description">
                                                <?php echo $i->getDescripcion() ?>
                                            </span>
                                        </div>
                                        <div class="col-5 d-flex justify-content-end" style="color:red">
                                            <b> <?php echo $i->getValor()*$i->getCantidad() ?>€ </b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="btn-toolbar" role="toolbar">
                                                <form action="#" class="deleteForm" method="post">
                                                    <a class="deleteLink"><img src="../imagen/basura.png" width="20px" alt=""></a>
                                                    <input type="hidden" name="deleteProductID" class="deleteID" value="<?php echo $i->getId() ?>">
                                                    <input type="hidden" name="delete">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!--ENDPHP-->
                            <?php endforeach; ?>
                        </ul>
                        <div class="row">
                            <div class="col-12 text-center mt-4">
                                <form action="carrito.html">
                                    <input type="submit" class="btn btn-primary" name="" id="" value="Ver en Carrito" style="width: 90%;">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offcanvas offcanvas-start productosCanvas" data-bs-scroll="true" tabindex="-1" id="offcanvasCatalogos" aria-labelledby="offcanvasCatalogos">
                    <div class="offcanvas-header justify-content-center">
                        <span class="h5">Productos</span>
                        <button type="button" class="btn-close" id="cierreOffcanvasCatalogo" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    
                        <ul class="nav flex-column ">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php?categoria=procesador">
                                    <div class="row">
                                        <div class="col-10">
                                            <span>Procesadores</span>
                                        </div>
                                        <div class="col-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                            </svg>
                                        </div>

                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php?categoria=placa Base">
                                    <div class="row">
                                        <div class="col-10">
                                            <span>Placas Base</span>
                                        </div>
                                        <div class="col-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                            </svg>
                                        </div>

                                    </div>
                                </a>
                            </li>
                            <?php if ($usuario->getCategoria() == "admin") : ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="admin.php">
                                        <div class="row">
                                            <div class="col-10">
                                                <span>Admin Zone</span>
                                            </div>
                                            <div class="col-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                                </svg>
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <ul class="login logout nav flex-colum position-absolute w-100 bottom-0 mb-4">
                            <?php if ($usuario->getCategoria() == "anonimo") : ?>
                                <li class="nav-item w-100">
                                    <a class="btn btn-primary" aria-current="page" href="login.php" style="width: 90%;">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-10">
                                                <span>Log In</span>
                                            </div>
                                            <div class="col-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                                </svg>
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($usuario->getCategoria() != "anonimo") : ?>
                                <li class="nav-item w-100">
                                    <form action="<?php $_SERVER["PHP_SELF"] ?>" class="logoutForm" method="post">
                                        <a class="btn btn-primary logoutLink" aria-current="page" style="width: 90%;">
                                            <div class="row" style="width: 100%;">
                                                <div class="col-10">
                                                    <span>Log Out</span>
                                                </div>
                                                <div class="col-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                        <input type="hidden" name="logout">
                                    </form>
                                </li>
                            <?php endif; ?>
                        </ul>
                    
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="main-head text-start ms-5 py-5">
            <h5>Checkout</h5>
        </div>
        <div class="row me-4 ms-4">
            <div class="col-md-8 ms-auto productos list-group">
                <!--PHP ITEMS-->
                <div class="list-group-item mb-5">
                    <div class="row">
                        <div class="col-10">
                            <div class="h4">$Nombre producto</div>
                        </div>
                        <div class="col-2 text-end">
                            <div class="">x<span class="cantidad">$cantidad</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <span class="description">
                                $Descripcion del producto
                            </span>
                        </div>
                        <div class="col-6 d-flex justify-content-end"">
                            <div class=" btn-toolbar" role="toolbar">
                            <button type="button" class="btn me-2"><img src="../imagen/basura.png" width="20px" alt=""></button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary">+</button>
                                <button type="button" class="btn btn-secondary">-</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--ENDPHP-->
        </div>
        <div class="col-md-4 resumen list-group ms-auto me-auto">
            <div class="list-group-item">
                <span class="h6 text-body-secondary">Resumen</span>
                <br>
                <br>
                <span class="h6">Subtotal Articulos</span>
                <br>
                <span>Subtotal: <span class="subtotal">13€</span></span>
                <br>
                <hr>
                <span>Total: <span class="total">13€</span></span>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <form action="">
                            <input type="submit" class="btn btn-primary" name="" id="" value="Realizar Pedido" style="width: 100%;">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>