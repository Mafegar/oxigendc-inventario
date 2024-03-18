

<?php

    session_start();
    require_once("../../conexion_bd/conexion.php");

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else {
        header("location ../../index.html");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="./styles/inventario_admin.css"> -->
    <title>Inventario</title>

    <style>
        html,body{
            margin: 0;
            padding: 0;
            font-family: "Raleway", sans-serif;
        }

        /* MENU */

        header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 1000px;
            margin: auto;
            margin-top: 20px;
        }

        nav ul{
            display: flex;
            gap: 20px;
        }

        nav ul li{
            list-style: none;
        }

        nav ul li a{
            text-decoration: none;
            color: black;
        }

        .logo img{
            width: 200px;
        }

    </style>

</head>
<body>

    <header>
        <div class="logo">
            <a href="./inventario_user.php"><img src="../../img/logo-oxigen.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <li><a href="./inventario_user.php">Inicio</a></li>
                <li><a href="./anadir_articulo_user.php">Inventario</a></li>
                <li><a href="../ver_movimientos.php">Historial de Movimientos</a></li>
                <li><a href="../../conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">

        <div class="formulario">

        </div>
    </div>


</body>
</html>