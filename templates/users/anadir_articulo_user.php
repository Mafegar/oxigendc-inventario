
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

    // Hacemos una consulta a la base de datos para obtener los articulos.
    $sql = "SELECT * FROM articulos";
    $result = mysqli_query($conn, $sql);

    // Barra de navegación para buscar un articulo.
    if(isset($_POST["boton-buscar"])){
        $busuqeda = $_POST["barra-buscar"];

        // Hacemos una consulta a la base de datos para obtener los articulos.
        $sqlBuscarArticulo = "SELECT * FROM articulos WHERE nombre LIKE '%$busuqeda%'";
        $result = mysqli_query($conn, $sqlBuscarArticulo);
        
    }

    // Hacemos una consulta a la base de datos para obtener los articulos y hacer entradas.
    $sqlHacerEntrada = "SELECT * FROM articulos";
    $resultHacerEntrada = mysqli_query($conn, $sqlHacerEntrada);

    // Hacemos una consulta a la base de datos para obtener los articulos y hacer Salidas.
    $sqlHacerSalida = "SELECT * FROM articulos";
    $resultHacerSalida = mysqli_query($conn, $sqlHacerSalida);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

        /* CUERPO */

        #cuerpo{
            width: 1000px;
            margin: auto;
        }

        /* TABLA CREAR ARTICULO */

        .formulario-crear{
            padding-left: 20px;
        }

        .form-crear label{
            margin-left: 20px;
        }

        .form-crear input,º{
            width: 200px;
        }

        #crear_articulo{
            width: 100px;
            margin-left: 20px;
        }

        /* MOSTRAR ARTICULOS */

        .ver-articulos{
            width: 1000px;
        }
        

        .ver-articulos table{
            width: 100%;
            border-collapse: collapse;
        }

        .ver-articulos table th, td{
            border: 1px solid black;
            padding: 8px;
        }

        /* FUNCIONES DE ARTICULOS */

        .funciones-articulos{
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


        /* HACER ENTRADA Y SALIDAS*/

        .titulo-entrada, .titulo-salida, .titulo-crear-articulo{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo-entrada button, .titulo-salida button, .titulo-crear-articulo button{
            height: 25px;
            background-color: red;
            color: white;
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
    
    
    <div id="cuerpo">   

        <div class="container">
        
            <h1>Articulos actuales en el Inventario</h1>

            <form class="funciones-articulos" action="" method="post">
                <div class="buscador">
                    <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Articulo">
                    <input type="submit" name="boton-buscar" id="boton-buscar" value="Buscar">
                </div>

                <div class="botones-acciones">
                    <input type="button" name="entrada" id="entrada" value="Entrada de Articulos">

                    <input type="button" name="salida" id="salida" value="Salida de Articulos">
                </div>
            </form>
            <br>

            <dialog id="entrada-articulo">
                <div class="titulo-entrada">
                    <h2>Entradas de Articulos</h2>
                    <button id="cerrar-entrada">X</button>
                </div>

                <form class="form-entrada" action="./user_articulos.php" method="post">
                    
                    <label for="nombre-entr">Nombre Articulo: </label>
                    <select name='nombre-entr' id='nombre-entr' required>;
                        <?php
                            while($row = mysqli_fetch_assoc($resultHacerEntrada)){
                                    echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                            }   
                        ?>
                    </select>
                    <br><br>
                    <label for="unidades-entr">Unidades: </label>
                    <input type="number" name="unidades-entr" id="unidades-entr" placeholder="Cantidadl Articulo" required>
                    <br><br>
                    <label for="fecha-oper-entr">Fecha Entrada: </label>
                    <input type="date" name="fecha-oper-entr" id="fecha-oper-entr" >
                    <br><br>
                    <input type="submit" name="hacer-entrada" id="hacer-entrada" value="Guardar Entrada" required>

                </form>

                
            </dialog>

            <dialog id="salida-articulo">
                <div class="titulo-salida">
                    <h2>Salidas de Articulos</h2>
                    <button id="cerrar-salida">X</button>
                </div>

                <form class="form-salida" action="./user_articulos.php" method="post">
                    
                    <label for="nombre-sali">Nombre Articulo: </label>
                    <select name='nombre-sali' id='nombre-sali' required>;
                        <?php
                            while($row = mysqli_fetch_assoc($resultHacerSalida)){
                                    echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                            }   
                        ?>
                    </select>
                    <br><br>
                    <label for="unidades-sali">Unidades: </label>
                    <input type="number" name="unidades-sali" id="unidades-sali" placeholder="Cantidadl Articulo" required>
                    <br><br>
                    <label for="fecha-oper-sali">Fecha Entrada: </label>
                    <input type="date" name="fecha-oper-sali" id="fecha-oper-sali" >
                    <br><br>
                    <input type="submit" name="hacer-salida" id="hacer-salida" value="Guardar Salida" required>

                </form>

            </dialog>

            <div class="ver-articulos">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Detalles</th>
                            <th>Tipo de Producto</th>
                            <th>Ubicación</th>
                            <th>Proveedor</th>
                            <th>Unidades</th>
                            <th>Tipo de Articulo</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                            // Verificamos si hay articulos en la base de datos.
                            if($result->num_rows > 0){
                                // Hacemos un bucle para obtener cada fila de la consulta.
                                while($row = mysqli_fetch_assoc($result)){
                                    if($row["unidades"] <= 0){    
                                        echo "<tr style='color: red;'>";
                                        echo "<td style='font-weight: 500;'>" . $row["nombre"] . "</td>";
                                        echo "<td>" . $row["marca"] . "</td>";
                                        echo "<td>" . $row["modelo"] . "</td>";
                                        echo "<td>" . $row["detalles"] . "</td>";
                                        echo "<td>" . $row["tipo_producto"] . "</td>";
                                        echo "<td>" . $row["ubicacion"] . "</td>";
                                        echo "<td>" . $row["proveedor"] . "</td>";
                                        echo "<td>" . $row["unidades"] . "</td>";
                                        echo "<td>" . $row["forma_producto"] . "</td>";
                                        echo "</tr>";
                                        
                                    } else {
                                        echo "<tr>";
                                        echo "<td>" . $row["nombre"] . "</td>";
                                        echo "<td>" . $row["marca"] . "</td>";
                                        echo "<td>" . $row["modelo"] . "</td>";
                                        echo "<td>" . $row["detalles"] . "</td>";
                                        echo "<td>" . $row["tipo_producto"] . "</td>";
                                        echo "<td>" . $row["ubicacion"] . "</td>";
                                        echo "<td>" . $row["proveedor"] . "</td>";
                                        echo "<td>" . $row["unidades"] . "</td>";
                                        echo "<td>" . $row["forma_producto"] . "</td>";
                                        echo "</tr>";
                                    }
                                    
                                } 
                            } else {
                                echo "<tr><td colspan='9'>No hay artículos</td></tr>";
                            }
                        ?>
                
                </table>
            </div>

        </div>

    </div>


    <script>

        // Botones para abrir los dialogos.
        const hacerEntrada = document.querySelector("#entrada");
        const hacerSalida = document.querySelector("#salida");

        // Botones para cerrar los dialogos.
        const btnCerrarEntrada = document.querySelector("#cerrar-entrada");
        const btnCerrarSalida = document.querySelector("#cerrar-salida");

        // Dialogos.
        const entradaArticulo = document.querySelector("#entrada-articulo");
        const salidaArticulo = document.querySelector("#salida-articulo");

        hacerEntrada.addEventListener("click", () => {
            entradaArticulo.showModal();
        });

        hacerSalida.addEventListener("click", () => {
            salidaArticulo.showModal();
        });

        btnCerrarEntrada.addEventListener("click", () => {
            entradaArticulo.close();
        });

        btnCerrarSalida.addEventListener("click", () => {
            salidaArticulo.close();
        });;

        // Obtener referencia al select y al div oculto
        var selectTipoProducto = document.getElementById('tipo_producto');
        var divFechaControl = document.querySelector('.fecha-control-inicio');
        var divFechaControlFinal = document.querySelector('.fecha-control-final');

        // Agregar un listener de eventos al select para mostrar u ocultar el div según la opción seleccionada
        selectTipoProducto.addEventListener('change', function() {
            if (selectTipoProducto.value === 'Equipo') {
                divFechaControl.style.display = 'block';
                divFechaControlFinal.style.display = 'block';
            } else {
                divFechaControl.style.display = 'none';
                divFechaControlFinal.style.display = 'none';
            }
        });

        

    </script>
    


</body>
</html>

