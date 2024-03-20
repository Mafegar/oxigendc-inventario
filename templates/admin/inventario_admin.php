
<?php

    session_start();
    require_once("../../conexion_bd/conexion.php");

    if(isset($_SESSION['username']) && $_SESSION["tipo_usuario"] == 1){
        $username = $_SESSION['username'];
    } else {
        header("location ./index.html");
        exit();
    }

    // Consulta a la base de datos para obtener el nombre de la persona que inicio sesion.
    $sql = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="./styles/inventario_admin.css"> -->
    <title>Inventario</title>

    <style>
        
        body{
            margin: 0;
            padding: 0;
            font-family: "Raleway", sans-serif;
            background-image: url("../../img/medio_logo_abajo.png");
            background-repeat: no-repeat;
            background-position: center bottom;
            height: 97vh;
            background-size: 1000px;
            background-position-Y: 333px;

        }

        /* MENU */

        header{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 1000px;
            height: 44vh;
            margin: auto;
            margin-top: 20px;
            
        }

        .fondo_header{
            width: 750px;
            height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            
        }

        .fondo_header img{
            width: 650px;
        }

        .fondo{
            margin-top: 40px;
            opacity: 0.5;
        }

        .logo{
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            top: 15px;
            left: 0px;
        }

        .logo img{
            width: 500px;
        }

        nav{
            height: 44vh;
            margin: auto;
            width: 1300px;
        }

        nav ul{
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 44vh;

        }

        nav ul li{
            list-style: none;
        }

        nav ul li a{
            text-decoration: none;
            color: black;
        }

        .inventario, .usuarios, .movimiento, .cerrar, .info-persona{
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
            width: 200px;
            height: 50px;
        }

        .inventario,.movimiento{
            margin-bottom: 50px;
        }

        

    </style>

</head>
<body>

    <header>
        <div class="fondo_header">
            <div class="fondo">
                <img src="../../img/Element Visual Sense Fons.png" alt="">
            </div>
            <div class="logo">
                <img src="../../img/logo_principal.png" alt="">
            </div>
        </div>
    </header>

    <nav>
        <ul>
            <div class="sect-1">
                <div class="inventario">
                    <li><a href="./anadir_articulo.php">Inventario</a></li>
                </div>
                <div class="usuarios">
                    <li><a href="./crear_usuarios.php">Usuarios</a></li>
                </div>
            </div>
            <div class="sect-3">
                <div class="info-persona">
                    <li>
                        <?php 
                            while($row = mysqli_fetch_assoc($result)){
                                echo  $row['nombre'] . " " . $row['primer_apellido'] . " <br>";
                                if($row['tipo_usuario'] == 1){
                                    echo " Oficina";
                                } else {
                                    echo " Almacen";
                                }
                            }  
                        ?>
                    </li>
                </div>
            </div>
            <div class="sect-2">
                <div class="movimiento">
                    <li><a href="../ver_movimientos.php">Historial de Movimientos</a></li>
                </div>
                <div class="cerrar">
                    <li><a href="../../conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
                </div>
            </div>
            
           
            
        </ul>
    </nav>

    <div class="container">

    </div>


</body>
</html>