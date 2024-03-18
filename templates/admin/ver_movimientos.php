
<?php

    session_start();
    require_once("../../conexion_bd/conexion.php");

    // Verificamos si el usuario ha iniciado sesión.
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else {
        header("location: ./index.html");
        exit();
    }

    // Consulta para obtener los datos de la tabla de Entradas.
    $sqlMovimiento = "SELECT * FROM movimientos";
    $resultEntradas = mysqli_query($conn, $sqlMovimiento);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Ver Movimientos</title>

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

        /* CUERPO */

        #cuerpo{
            width: 1000px;
            margin: auto;
        }

        /* FUNCIONES DE ARTICULOS */

        .funciones-movimientos{
            display: flex;
            justify-content: space-between;
        }

        .botones-acciones{
            display: flex;
            gap: 10px;
        }

        #barra-buscar{
            width: 205px;
        }

        /* TABLAS DE MOVIMIENTOS */

        .tabla-movimientos{
            width: 1000px;
            margin-top: ;
        }

        .tabla-movimientos table{
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-movimientos table th, td{
            border: 1px solid black;
            padding: 8px;
        }

    </style>


</head>
<body>
    
    <header>
        <div class="logo">
            <a href="./inventario_admin.html"><img src="./img/logo-oxigen.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <li><a href="./inventario_admin.php">Inicio</a></li>
                <li><a href="./crear_usuarios.php">Usuarios</a></li>
                <li><a href="./anadir_articulo.php">Inventario</a>
                    <!-- <ul>
                        <li><a href="">Entradas</a></li>
                        <li><a href="">Salidas</a></li>
                    </ul> -->
                </li>
                
                <li><a href="./ver_movimientos.php">Historial de Movimientos</a></li>
                <li><a href="./conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>


    <div id="cuerpo">
        <h1>Movimientos Realizados</h1>
    <div class="movimientos">

        <form action="" method="post">

            <div class="funciones-movimientos">
                <div class="buscador">
                    <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Usuario">
                    <select name="buscar-tipo-mov" id="buscar-tipo-mov">
                        <option value="">Tipo de Usuario</option>
                        <option value="1">Entradas</option>
                        <option value="0">Salidas</option>
                    </select>
                    <input type="submit" name="boton-buscar" id="boton-buscar" value="Buscar">

                </div>
            </div>

            <div class="tabla-movimientos">
                
                <table>
                    <tr>
                        <th>Tipo de Movimiento</th>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>Fecha Movimiento</th>
                        <th>Usuario</th>
                        
                    </tr>

                    <?php
                        while($row = mysqli_fetch_assoc($resultEntradas)){
                            echo "<tr>";
                            echo "<td>" . $row["tipo_movimiento"] . "</td>";
                            echo "<td>" . $row["nombre_articulo"] . "</td>";
                            echo "<td>" . $row["unidades"] . "</td>";
                            echo "<td>" . $row["fecha_movimiento"] . "</td>";
                            echo "<td>" . $row["nombre_usuario"] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
                

        
            </div>
        
        </form>

    
    </div>


</body>
</html>