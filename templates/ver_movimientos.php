
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

    // Obtenemos la fecha actual del dia en el que estamos y la fecha de 30 dias atras.
    $fecha_actual = date("Y-m-d");
    $fecha_30_dias_atras = date("Y-m-d", strtotime("-30 days"));

    // Hacemos la consulta para obtener los movimientos de los ultimos 30 dias.   
    $sqlMovimiento = "SELECT * FROM movimientos WHERE fecha_movimiento BETWEEN '$fecha_30_dias_atras' AND '$fecha_actual'";
    $result = mysqli_query($conn, $sqlMovimiento);



    // Buscar por tipo de entrada y anticulo.
    if(isset($_POST["boton-buscar"])){

        if(!empty($_POST["barra-buscar"]) || !empty($_POST["buscar-tipo-mov"]) || !empty($_POST["fecha_inicio"]) || !empty($_POST["fecha_fin"]) || !empty($_POST["buscar-categoria"])){

            // Buscar a traves de la barra de busqueda.
            if(!empty($_POST["barra-buscar"])){
                $barra_buscar = $_POST["barra-buscar"];
    
                // Consulta para buscar algun articulo en concreto.
                $sqlBuscar = "SELECT * FROM movimientos WHERE nombre_articulo LIKE '%$barra_buscar%'";
                $result = mysqli_query($conn, $sqlBuscar);
            }
    
            // Buscar a traves del tipo de movimientos.
            if(!empty($_POST["buscar-tipo-mov"])){
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
                
                }
            }

            // Buscar a traves de la categoria.
            if(!empty($_POST["buscar-categoria"])){

                $tipo_cat = $_POST["buscar-categoria"];

                if($tipo_cat == "cable"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE prinCategoria_ident LIKE 'CAB%'";
                    $result = mysqli_query($conn, $sqlBuscar);

                } else if($tipo_cat == "martillo"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE prinCategoria_ident LIKE 'MRT%'";
                    $result = mysqli_query($conn, $sqlBuscar);

                } else if($tipo_cat == "llave"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE prinCategoria_ident LIKE 'LLV%'";
                    $result = mysqli_query($conn, $sqlBuscar);
                }
                
            }

            if(!empty($_POST["buscar-tipo-mov"]) && !empty($_POST["buscar-categoria"])){

                $tipo_mov = $_POST["buscar-tipo-mov"];
                $tipo_cat = $_POST["buscar-categoria"];

                // Buscar a traves del Tipo Movimiento -> Entradas/Salidas y Categoria -> Cables.
                if($tipo_mov == "Entradas" && $tipo_cat == "cable"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Entrada' AND prinCategoria_ident LIKE 'CAB%' ";
                    $result = mysqli_query($conn, $sqlBuscar);

                } else if($tipo_mov == "Salidas" && $tipo_cat == "cable"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Salida' AND prinCategoria_ident LIKE 'CAB%' ";
                    $result = mysqli_query($conn, $sqlBuscar);
                }
                
                // Buscar a traves del Tipo Movimiento -> Entradas/salidas y Categoria -> Martillos.
                if($tipo_mov == "Entradas" && $tipo_cat == "martillo"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Entrada' AND prinCategoria_ident LIKE 'MRT%' ";
                    $result = mysqli_query($conn, $sqlBuscar);

                } else if($tipo_mov == "Salidas" && $tipo_cat == "martillo"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Salida' AND prinCategoria_ident LIKE 'MRT%' ";
                    $result = mysqli_query($conn, $sqlBuscar);
                }

                // Buscar a traves del Tipo Movimiento -> Entradas/salidas y Categoria -> Llaves.
                if($tipo_mov == "Entradas" && $tipo_cat == "llave"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Entrada' AND prinCategoria_ident LIKE 'LLV%' ";
                    $result = mysqli_query($conn, $sqlBuscar);

                } else if($tipo_mov == "Salidas" && $tipo_cat == "llave"){
                    $sqlBuscar = "SELECT * FROM movimientos WHERE tipo_movimiento = 'Salida' AND prinCategoria_ident LIKE 'LLV%' ";
                    $result = mysqli_query($conn, $sqlBuscar);
                }

            }

            // Buscar a traves de un rango de fechas.
            if(!empty($_POST["fecha_inicio"]) && !empty($_POST["fecha_fin"])){

                $fecha_inicio = $_POST["fecha_inicio"];
                $fecha_fin = $_POST["fecha_fin"];
        
                $sqlBuscar = "SELECT * FROM movimientos WHERE fecha_movimiento BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                $result = mysqli_query($conn, $sqlBuscar);
            }
        }

    }





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Ver Movimientos</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');

        :root{
            /* Paleta de colores empresa. */
            --azul-oscuro: #4d4792;
            --verde-azul: #86b398;
            --verde:  #a2c037;
            --azul: #68a8de;
            --negro: #000000;
            --blanco: #ffffff;
            --gradient_verdeAzul: linear-gradient(167deg, rgba(162,192,55,1) 0%, rgba(134,179,152,1) 50%, rgba(104,168,222,1) 100%);
        }

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

        #cuerpo h1{
            text-align: center;
            margin-bottom: 35px;
        }

        .titulo{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            width: 1100px;
        }

        .der, .izq{
            width: 300px;
            height: 4px;
            border-radius: 10px;
        }

        .der{
            background: linear-gradient(167deg, rgba(162,192,55,1) 0%, rgba(134,179,152,1) 50%, rgba(104,168,222,1) 100%);
        }

        .izq{
            background: linear-gradient(167deg, rgba(104,168,222,1) 0%, rgba(134,179,152,1) 50%, rgba(162,192,55,1) 100%);
        }

        /* FUNCIONES DE ARTICULOS */

        .funciones-movimientos{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 35px;
            gap: 12px;
            font-family: "Raleway", sans-serif;
        }

        .funciones-movimientos select{
            height: 20px;
            font-family: "Raleway", sans-serif;
        }

        .funciones-movimientos button{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            height: 21px;
            /* background: linear-gradient(167deg, rgba(104,168,222,1) 0%, rgba(134,179,152,1) 50%, rgba(162,192,55,1) 100%); */
            font-weight: 600;
            cursor: pointer;
            font-family: "Raleway", sans-serif;
        }

        .funciones-movimientos i{
            font-size: 15px;
            font-weight: 600;
        }

        .botones-acciones{
            display: flex;
            gap: 10px;
        }

        .funciones-fechas{
            display: flex;
            justify-content: end;
            align-items: center;
        }

        .funciones-fechas label{
            margin-right: 10px;
            margin-left: 10px;
            font-weight: bold;
        }

        .buscador{
            display: flex;
            gap: 20px;
        }

        .buscador-mov{
            display: flex;
            gap: 20px;
            /* flex-direction: column; */
        }

        .buscador-mov-total{
            display: flex;
            align-items: center;
            gap: 20px;
        }

        #barra-buscar{
            width: 200px;
            text-align: center;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: 400;
            height: 20px;
            font-family: "Raleway", sans-serif;
        }

        #buscar-tipo-mov, #buscar-categoria{
            width: 150px;
            height: 23px;
            border-radius: 5px;
        }

        #buscar-categoria{
            width: 154px;
            height: 23px;
            border-radius: 5px;
        }

        #fecha_inicio, #fecha_fin{
            height: 20px;
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

        .unid_mov, .fecha_mov, .nom_mov, .art_mov, .unid_mov_salida, .fecha_mov_salida, .nom_mov_salida, 
        .art_mov_salida, .ubi_mov, .categoria, .identificador{
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
            <div class="titulo">
                <div class="der"></div>
                <h1>Movimientos Realizados</h1>
                <div class="izq"></div>
            </div>
            
            
            <form action="" method="post">

                <div class="funciones-movimientos">

                    <div class="buscador-mov">

                        <div class="funciones-fechas">
                            <label for="fecha_inicio">Fecha Inicio: </label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio">

                            <label for="fecha_fin">Fecha Fin: </label>
                            <input type="date" name="fecha_fin" id="fecha_fin">
                        </div>

                        <div class="buscador">
                            <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Articulo">
                            <select name="buscar-tipo-mov" id="buscar-tipo-mov">
                                <option value="">Tipo de Movimiento</option>
                                <option value="Entradas">Entradas</option>
                                <option value="Salidas">Salidas</option>
                            </select>

                            <select name="buscar-categoria" id="buscar-categoria">
                                <option value="">Escoja una Categoria</option>
                                <option value="cable">Cables</option>
                                <option value="martillo">Martillos</option>
                                <option value="llave">Llaves</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" name="boton-buscar" id="boton-buscar"><i class='bx bx-search-alt-2'></i>Buscar</button>
                 
                </div>

                

                <div class="tabla-movimientos">
                    
                    <table>
                        <tr>
                            <th>Tipo de Movimiento</th>
                            <th>Categoria</th>
                            <th>Identificador</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Fecha Movimiento</th>
                            <th>Unidades</th>
                            <th>Usuario</th>
                            
                        </tr>

                        <?php

                            if($result->num_rows > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    if($row["tipo_movimiento"] == "Entrada"){
                                        echo "<tr style='background-color: rgba(0, 190, 0, 0.409);'>";
                                        echo "<td class='tipo_mov'; style='font-weight: bold;'>" . $row["tipo_movimiento"] . "</td>";
                                        echo "<td class='categoria';>". $row["prinCategoria_ident"] ."</td>";
                                        echo "<td class='identificador';>". $row["subCategoria_ident"] ."</td>";
                                        echo "<td class='art_mov'>" . $row["nombre_articulo"] . "</td>";
                                        echo "<td class='unid_mov';>" . $row["unidades"] . "</td>";
                                        echo "<td class='fecha_mov';>" . $row["fecha_movimiento"] . "</td>";
                                        echo "<td class='ubi_mov'>" . $row["ubicacion"] . "</td>";
                                        echo "<td class='nom_mov';>" . $row["nombre_usuario"] . "</td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr style='background-color: #ff00008a;'>";
                                        echo "<td class='tipo_mov_salida'; style='font-weight: bold;'>" . $row["tipo_movimiento"] . "</td>";
                                        echo "<td class='categoria';>". $row["prinCategoria_ident"] ."</td>";
                                        echo "<td class='identificador';>". $row["subCategoria_ident"] ."</td>";
                                        echo "<td class='art_mov_salida'>" . $row["nombre_articulo"] . "</td>";
                                        echo "<td class='unid_mov_salida'>" . $row["unidades"] . "</td>";
                                        echo "<td class='fecha_mov_salida'>" . $row["fecha_movimiento"] . "</td>";
                                        echo "<td class='ubi_mov'>" . $row["ubicacion"] . "</td>";
                                        echo "<td class='nom_mov_salida'>" . $row["nombre_usuario"] . "</td>";
                                        echo "</tr>";
                                    }
                                    
                                }

                            } else {
                                $mensaje_alert = "No se encontro ningun movimiento con esas especificaciones.";
                                $mensaje = "No hay movimientos en el historial con esas especificaciones.";
                                echo "<script>alert('$mensaje_alert');</script>";
                                echo "<td style='text-align: center' colspan='11'>". $mensaje ."</td>";
                            }

                        ?>
                    </table>
                    

            
                </div>
            
            </form>
        </div>
    
    </div>


</body>
</html>