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
    session_start();
    if (isset($_POST["destroy"])) {
        session_destroy();
        session_start();
    }

    $admin = null;
    $idUsuario = null;
    $usuario  = null;
    $conexion = null;
    $categoria = null;
    $arrayCarrito = array();
    $arrayProductos = array();
    $producto = null;
    $idProducto = null;
    $defaultCategoria = "procesador";



    try {
        $conexion = mysqli_connect("localhost", "root", "", "breixocomponentes");
    } catch (Exception $E) {
        header("Location: oops.html");
        die;
    }


    if (isset($_GET["id"])) {
        $idProducto = $_GET["id"];
    } else {
        if (isset($_POST["id"])) {
            $idProducto = $_POST["id"];
        } else {
            header("Location: oops.html");
            die;
        }
    }
    if (!isset($_SESSION["tipoUsuario"])) {
    } else {
        if ($_SESSION["tipoUsuario"] == "admin") {
            $admin = true;
        }
    }
    if (isset($_SESSION["idUsuario"])) {
        $idUsuario = $_SESSION["idUsuario"];
    }
    if (!isset($_SESSION["arrayCarrito"])) {
        $_SESSION["arrayCarrito"] = $arrayCarrito;
    } else {
        $arrayCarrito = $_SESSION["arrayCarrito"];
    }

    class Producto
    {
        private int $id;
        private string $nombre, $descripcion, $categoria, $imagen;
        private float $valor;

        function __construct($id, $nombre, $descripcion, $valor, $categoria, $imagen)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->valor = $valor;
            $this->categoria = $categoria;
            $this->imagen = $imagen;
        }

        function getId()
        {
            return $this->id;
        }
        function getNombre()
        {
            return $this->nombre;
        }
        function getDescripcion()
        {
            return $this->descripcion;
        }
        function getValor()
        {
            return $this->valor;
        }
        function getCategoria()
        {
            return $this->categoria;
        }
        function getImagen()
        {
            return $this->imagen;
        }
    }
    class Usuario
    {
        private int $id;
        private string $usuario, $contraseña, $categoria;


        function __construct($id, $usuario, $contraseña, $categoria)
        {
            $this->id = $id;
            $this->usuario = $usuario;
            $this->contraseña = $contraseña;
            $this->categoria = $categoria;
        }

        function getId()
        {
            return $this->id;
        }
        function getUsuario()
        {
            return $this->usuario;
        }
        function getContraseña()
        {
            return $this->contraseña;
        }
        function getCategoria()
        {
            return $this->categoria;
        }
    }
    class ProductoEnCarrito
    {
        private int $id;
        private string $nombre, $descripcion, $cantidad;
        private float $valor;

        function __construct($id, $nombre, $descripcion, $valor, $cantidad)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->valor = $valor;
            $this->cantidad = $cantidad;
        }

        function getId()
        {
            return $this->id;
        }
        function getNombre()
        {
            return $this->nombre;
        }
        function getDescripcion()
        {
            return $this->descripcion;
        }
        function getValor()
        {
            return $this->valor;
        }
        function getCantidad()
        {
            return $this->cantidad;
        }
        function setCantidad($cantidad)
        {
            $this->cantidad = $cantidad;
        }
    }

    $statement = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $statement->bind_param("i", $idProducto);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_row()) {
        $producto = new Producto($row[0], $row[1], $row[2], $row[3], $row[4], base64_encode($row[5]));
    }
    if ($idUsuario != null) {
        $statement = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
        $statement->bind_param("i", $idUsuario);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_row()) {
            $usuario = new Usuario($row[0], $row[1], $row[2], $row[3], $row[4]);
        }
    }

    if (isset($_POST["insert"])) {
        $existe = false;
        foreach($arrayCarrito as $i){
            if($i->getID()==$idProducto){
                $i->setCantidad($i->getCantidad()+1);
                $existe = true;
            }
        }
        if(!$existe){
            array_push($arrayCarrito, new ProductoEnCarrito($producto->getId(), $producto->getNombre(), $producto->getDescripcion(),$producto->getValor(), 1));
        }
        $_SESSION["arrayCarrito"]=$arrayCarrito;
    }

    $conexion->close();
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
                        <?php if ($idUsuario == null) : ?>
                            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><img src="../imagen/carrito.png" width="20">Carrito</h5>
                        <?php endif; ?>
                        <?php if ($idUsuario != null) : ?>
                            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><img src="../imagen/carrito.png" width="20">Carrito de <?php echo $usuario->getUsuario() ?></h5>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-group">
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
                                        <div class="col-5 d-flex justify-content-end">
                                            <div class="btn-toolbar" role="toolbar">
                                                <form action="#" method="post" id="deleteForm">
                                                    <a class="submitEnlace"> <img src="../imagen/basura.png" width="20px" alt=""> </a>
                                                    <input type="hidden" name="id" value="<?php echo $i->getId() ?>" class="btn me-2">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
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
                    <form class="offcanvas-body" name="productosCavasForm" action="index.html" method="post">
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
                            <?php if ($admin) : ?>
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
                            <?php if ($idUsuario == null) : ?>
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
                            <?php if ($idUsuario != null) : ?>
                                <li class="nav-item w-100">
                                    <a class="btn btn-primary" aria-current="page" href="index.php" style="width: 90%;">
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
                                </li>
                            <?php endif; ?>
                        </ul>
                    </form>
                </div>
            </div>
        </nav>
    </header>
                            
    <main class="py-5">

        <div class="row me-4 ms-4 producto">
            <div class="col-lg-8  col-12 ms-auto columna1">
                <div class="row row-cols-1 me-auto ms-auto">
                    <div class="col d-flex justify-content-center imagen">
                        <img class="image" src="data:image/png;base64,<?php echo $producto->getImagen(); ?>" alt="" width="70%">
                    </div>
                    <hr>
                    <div class="col mt-5 ms-auto especificaciones list-group">
                        <div class="list-group-item">
                            <span class="h4"><?php echo $producto->getNombre() ?></span>
                        </div>
                        <div class="list-group-item">
                            <span><?php echo $producto->getDescripcion() ?></span>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="col-lg-4 col-12 columna2 px-5">
                <strong>Precio:</strong>
                <br>
                <b class="subtotal"><?php echo $producto->getValor() ?></b>
                <div class="row precioArriba">
                    <div class="col-12 text-center mt-4">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="submit" class="btn btn-primary" name="insert" id="insert" value="Añadir a Carrito" style="width: 100%;">
                            <input type="hidden" name="id" value="<?php echo $idProducto ?>">
                        </form>
                    </div>
                </div>
            </div>

            <div class="resumen  col-12 precioAbajo sticky-bottom">
                <div class="row">
                    <div class="col-12 text-center">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="submit" class="btn btn-primary" name="insert" id="insert" value="Añadir a Carrito" style="width: 100%;">
                            <input type="hidden" name="id" value="<?php echo $idProducto ?>">
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