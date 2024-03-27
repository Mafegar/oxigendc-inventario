
<?php

    session_start();
    require_once("../conexion_bd/conexion.php");

    // Verificamos si el usuario ha iniciado sesión.
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else {
        header("location: ../index.html");
        exit();
    }

    // Consulta para obtener los datos de la tabla de Entradas.
    $sqlMovimiento = "SELECT * FROM movimientos";
    $result = mysqli_query($conn, $sqlMovimiento);

    // Buscar por tipo de entrada y anticulo.
    if(isset($_POST["boton-buscar"])){
        $barra_buscar = $_POST["barra-buscar"];
        $tipo_mov = $_POST["buscar-tipo-mov"];

        // Consultamos la base de datos para obtener los movimientos.
        if($tipo_mov == "Entradas"){
            // Consulta para ver solo entradas.
            $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Entrada'";
            $result = mysqli_query($conn, $sqlBuscar);

        } else if($tipo_mov == "Salidas"){
            // Consulta para ver solo salidas.
            $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Salida'";
            $result = mysqli_query($conn, $sqlBuscar);
        
        } else {
            // Consulta para buscar algun articulo en concreto.
            $sqlBuscar = "SELECT * FROM movimientos WHERE nombre_articulo LIKE '%$barra_buscar%'";
            $result = mysqli_query($conn, $sqlBuscar);
        }

    }

    // if(isset($POST["boton-buscar-fechas"])){

    //     $fecha_inicio = $_POST["fecha_inicio"];
    //     $fecha_fin = $_POST["fecha_fin"];

    //     $sqlBuscar = "SELECT * FROM movimientos WHERE fecha_movimiento BETWEEN '$fecha_inicio' AND '$fecha_fin'";
    //     $result = mysqli_query($conn, $sqlFechas);

    // }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Ver Movimientos</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');

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
            width: 1100px;
            margin: auto;
            margin-top: 20px;
        }

        nav ul{
            display: flex;
            gap: 20px;
        }

        nav ul li{
            list-style: none;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
        }

        nav ul li a{
            text-decoration: none;
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding-left: 5px;
            padding-right: 5px;
        }

        nav ul li a:hover {
            font-weight: bold;
            color: #477296;

            /* border-bottom: 3px solid;
            border-image: var(--gradient_verdeAzul) 1;
            background: linear-gradient(167deg, rgba(162,192,55,1) 0%, rgba(134,179,152,1) 50%, rgba(104,168,222,1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block; */
        }

        nav ul li:hover .bi-box-seam, nav ul li:hover .bi-person, nav ul li:hover .bi-clipboard2, nav ul li:hover .bi-x-octagon, nav ul li:hover .bi-house{
            display: none;
        }

        nav ul li:hover .bi-box-seam-fill, nav ul li:hover .bi-person-fill, nav ul li:hover .bi-clipboard2-fill, nav ul li:hover .bi-x-octagon-fill, nav ul li:hover .bi-house-fill{
            display: block !important;
            background: linear-gradient(167deg, rgba(162,192,55,1) 0%, rgba(134,179,152,1) 50%, rgba(104,168,222,1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        nav ul li .bi-clipboard2-fill{
            display: block !important;
            background: linear-gradient(167deg, rgba(162,192,55,1) 0%, rgba(134,179,152,1) 50%, rgba(104,168,222,1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        nav ul li .bi-clipboard2{
            display: none;
        }

        nav ul li .movi_a{
            font-weight: bold !important;
            color: #477296;
        }

        .logo img{
            width: 200px;
        }

        /* CUERPO */

        #cuerpo{
            width: 1100px;
            margin: auto;
            margin-top: 20px;
        }

        /* FUNCIONES DE ARTICULOS */

        .funciones-movimientos{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .funciones-movimientos select{
            height: 20px;
        }

        .botones-acciones{
            display: flex;
            gap: 10px;
        }

        #barra-buscar{
            width: 250px;
            text-align: center;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: 400;
            height: 20px;
        }

        #buscar-tipo-mov{
            width: 150px;
            height: 23px;
            border-radius: 5px;
        }

        /* TABLAS DE MOVIMIENTOS */

        .tabla-movimientos{
            width: 1100px;
            margin-bottom: 20px;
        }

        .tabla-movimientos table{
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-movimientos table th, td{
            border: 1px solid black;
            padding: 8px;
        }

        /* EDITAR TAMAÑO CELDAS */
        .tipo_mov, .tipo_mov_salida{
            width: 100px;
            text-align: center;
        }

        .unid_mov, .fecha_mov, .nom_mov, .art_mov, .unid_mov_salida, .fecha_mov_salida, .nom_mov_salida, .art_mov_salida, .ubi_mov{
            text-align: center;
        }

    </style>


</head>
<body>
    
    <header>
        <div class="logo">
            <img src="../img/logo-oxigen.png" alt="">
        </div>
        <nav>
            <ul>
                <?php
                    if($_SESSION["tipo_usuario"] == 1){
                        echo "<li><i class='bi bi-house-fill' style='display: none;'></i><i class='bi bi-house'></i><a href='./admin/inventario_admin.php'>Inicio</a></li>";
                        echo "<li><i class='bi bi-box-seam-fill' style='display: none;'></i><i class='bi bi-box-seam'><a href='./admin/anadir_articulo.php'></i>Inventario</a></li>";
                        echo "<li><i class='bi bi-person-fill' style='display: none;'></i><i class='bi bi-person'></i><a href='./admin/crear_usuarios.php'>Usuarios</a></li>";

                    } else if($_SESSION["tipo_usuario"] == 0) {
                        echo "<li><i class='bi bi-house-fill' style='display: none;'></i><i class='bi bi-house'></i><a href='./users/inventario_user.php'>Inicio</a></li>";
                        echo "<li><i class='bi bi-box-seam-fill' style='display: none;'></i><i class='bi bi-box-seam'><a href='./users/anadir_articulo_user.php'></i>Inventario</a></li>";

                    }
                ?>
                <li><i class="bi bi-clipboard2-fill" style="display: none;"></i><i class="bi bi-clipboard2"></i><a href="./ver_movimientos.php" class="movi_a">Historial de Movimientos</a></li>                
                <li><i class="bi bi-x-octagon-fill" style="display: none;"></i><i class="bi bi-x-octagon"></i><a href="../conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>

    <div id="cuerpo">
        
    <div class="movimientos">

        <form action="" method="post">

            <div class="funciones-movimientos">
                <h1>Movimientos Realizados</h1>

                <div class="buscador">
                    <label for="fecha_inicio">Fecha Inicio: </label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio">
                    <label for="fecha_fin">Fecha Fin: </label>
                    <input type="date" name="fecha_fin" id="fecha_fin">
                    <input type="submit" name="boton-buscar-fechas" id="boton-buscar-fechas" value="Buscar">  
                    <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Articulo">
                    <select name="buscar-tipo-mov" id="buscar-tipo-mov">
                        <option value="">Tipo de Movimiento</option>
                        <option value="Entradas">Entradas</option>
                        <option value="Salidas">Salidas</option>
                    </select>
                    <input type="submit" name="boton-buscar" id="boton-buscar" value="Buscar">

                </div>
            </div>

            <div class="funciones-fechas">
                <form action="" method="post">
                    <label for="fecha_inicio">Fecha Inicio: </label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio">
                    <label for="fecha_fin">Fecha Fin: </label>
                    <input type="date" name="fecha_fin" id="fecha_fin">
                    <input type="submit" name="boton-buscar-fechas" id="boton-buscar-fechas" value="Buscar">  
                </form>

            </div>

            <div class="tabla-movimientos">
                
                <table>
                    <tr>
                        <th>Tipo de Movimiento</th>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>Fecha Movimiento</th>
                        <th>Unidades</th>
                        <th>Usuario</th>
                        
                    </tr>

                    <?php
                        while($row = mysqli_fetch_assoc($result)){
                            if($row["tipo_movimiento"] == "Entrada"){
                                echo "<tr style='background-color: rgba(0, 190, 0, 0.409);'>";
                                echo "<td class='tipo_mov'; style='font-weight: bold;'>" . $row["tipo_movimiento"] . "</td>";
                                echo "<td class='art_mov'>" . $row["nombre_articulo"] . "</td>";
                                echo "<td class='unid_mov';>" . $row["unidades"] . "</td>";
                                echo "<td class='fecha_mov';>" . $row["fecha_movimiento"] . "</td>";
                                echo "<td class='ubi_mov'>" . $row["ubicacion"] . "</td>";
                                echo "<td class='nom_mov';>" . $row["nombre_usuario"] . "</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr style='background-color: #ff00008a;'>";
                                echo "<td class='tipo_mov_salida'; style='font-weight: bold;'>" . $row["tipo_movimiento"] . "</td>";
                                echo "<td class='art_mov_salida'>" . $row["nombre_articulo"] . "</td>";
                                echo "<td class='unid_mov_salida'>" . $row["unidades"] . "</td>";
                                echo "<td class='fecha_mov_salida'>" . $row["fecha_movimiento"] . "</td>";
                                echo "<td class='ubi_mov'>" . $row["ubicacion"] . "</td>";
                                echo "<td class='nom_mov_salida'>" . $row["nombre_usuario"] . "</td>";
                                echo "</tr>";
                            }
                            
                        }
                    ?>
                </table>
                

        
            </div>
        
        </form>

    
    </div>


</body>
</html>