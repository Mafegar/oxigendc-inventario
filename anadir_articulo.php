
<?php

    session_start();
    require_once "./conexion_bd/conexion.php";

    // Hacemos una consulta a la base de datos para obtener los articulos.
    $sql = "SELECT * FROM articulos";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Gestionar Inventario</title>

    <style>
        
        html,body{
            margin: 0;
            padding: 0;
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

        /* CREAR ARTICULO */

        .columnas-crear{
            /* display: flex;
            align-items: center;
            gap: 20px; */
        }

        /* CUERPO */

        #cuerpo{
            width: 1000px;
            margin: auto;
        }

        /* TABLA CREAR ARTICULO */
        .form-crear label{
            margin-left: 20px;
        }

        .form-crear input,º{
            width: 200px;
        }

        /* MOSTRAR ARTICULOS */

        .ver-articulos{
            /* border: 1px solid black; */
            width: 1000px;
            /* margin: auto; */
        }
        

        .ver-articulos table{
            width: 100%;
            border-collapse: collapse;
        }

        .ver-articulos table th, td{
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
                <li><a href="./inventario_admin.html">Inicio</a></li>
                <li><a href="">Crear Usuarios</a></li>
                <li><a href="./anadir_articulo.php">Gestionar Inventario</a></li>
                <li><a href="">Entradas y Salidas</a></li>
                <li><a href="">Historial de Movimientos</a></li>
            </ul>
        </nav>
    </header>
    
    
    <div id="cuerpo">   

        <div class="container">

            <h1>Crear Articulo</h1>

            <div class="formulario-crear">

                <form class="form-crear" action="crear_articulos.php" method="post">

                    <div class="columnas-crear">
                        <div class="colum1">
                            <label for="nombre">Nombre: </label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Articulo" required>

                            <label for="marca">Marca: </label>
                            <input type="text" name="marca" id="marca" placeholder="Marca">

                            <label for="modelo">Modelo: </label>
                            <input type="text" name="modelo" id="modelo" placeholder="Modelo">
                            <br><br>
                            <label for="detalles">Detalles: </label>
                            <input type="text" name="detalles" id="detalles" placeholder="Detalles">
                            
                            <label for="tipo_producto">Tipo de Producto: </label>
                            <select name="tipo_producto" id="tipo_producto" required>
                                <option value="">Escoja una opcion</option>
                                <option value="Equipo">Equipo</option>
                                <option value="Kit Maleta">Kit Maleta</option>
                                <option value="Herramienta">Herramienta</option>
                            </select>
                            <br><br>
                            <div class="fecha-control-inicio" style="display: none;">
                                <label for="fecha_control_inicio">Fecha Control: </label>
                                <input type="date" name="fecha_control_inicio" id="fecha_control_inicio">
                                <br><br>
                            </div>
                        </div>  

                        <!-- <div class="colum2">
                            <label for="detalles">Detalles: </label>
                            <input type="text" name="detalles" id="detalles" placeholder="Detalles">
                            <br><br>
                            <label for="tipo_producto">Tipo de Producto: </label>
                            <select name="tipo_producto" id="tipo_producto" required>
                                <option value="">Escoja una opcion</option>
                                <option value="Equipo">Equipo</option>
                                <option value="Kit Maleta">Kit Maleta</option>
                                <option value="Herramienta">Herramienta</option>
                            </select>
                            <br><br>

                            <div class="fecha-control">
                                <label for="fecha_control">Fecha Control: </label>
                                <input type="date" name="fecha_control" id="fecha_control">
                                <br><br>
                            </div>

                            <label for="ubi">Ubicación: </label>
                            <select name="ubi" id="ubi" required>
                                <option value="">Seleccione la Ubicación</option>
                                <option value="Oxigen">Oxigen</option>
                                <option value="Entregado en Obra">Entregado en Obra</option>
                            </select>
                            <br><br>
                        </div> -->

                        <div class="colum3">

                            <div class="fecha-control-final"style="display: none;">
                                <label for="fecha_control_final">Fecha Sigiente Control: </label>
                                <input type="date" name="fecha_control_final" id="fecha_control_final">
                                <br><br>
                            </div>

                            <label for="ubi">Ubicación: </label>
                            <select name="ubi" id="ubi" required>
                                <option value="">Seleccione la Ubicación</option>
                                <option value="Oxigen">Oxigen</option>
                                <option value="Entregado en Obra">Entregado en Obra</option>
                            </select>
                            
                            <label for="proveedor">Proveedor: </label>
                            <input type="text" name="proveedor" id="proveedor" placeholder="Proveedor" required>
                            
                            <label for="unidades">Unidades: </label>
                            <input type="number" name="unidades" id="unidades" placeholder="Unidades" required>
                            <br><br>
                            <label for="tipo_articulo">Tipo de Articulo:</label>
                            <select name="tipo_articulo" id="tipo_articulo" required>
                                <option value="">Seleccione el Tipo de Articulo</option>
                                <option value="Activo">Activo</option>
                                <option value="Passivo">Passivo</option>
                            </select>
                            <br><br>
                        </div>
                    </div>

                    <input type="submit" name="crear_articulo" id="crear_articulo" value="Crear Articulo">
                </form>

            </div>
        
            <h2>Articulos actuales en el Inventario</h2>

            <form action="" method="post">
                <input type="button" name="entrada" id="entrada" value="Hacer Entrada">

                <input type="button" name="salida" id="salida" value="Hacer Salida">
            </form>

            <dialog id="entrada-articulo">
                <button id="cerrar-entrada">X</button>
                <h1>Entrada Articulo</h1>

                <form class="form-entrada" action="" method="post">

                    <label for="fecha-oper">Fecha Entrada: </label>
                    <input type="date" name="fecha-oper" id="fecha-oper">
                    <br><br>

                </form>

                
            </dialog>

            <dialog id="salida-articulo">
                <button id="cerrar-salida">X</button>
                <h1>Salida Articulo</h1>

                
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
                            } else {
                                echo "<tr><td colspan='9'>No hay artículos</td></tr>";
                            }
                        ?>
                
                </table>
            </div>

        </div>

    </div>


    <script>

        const hacerEntrada = document.querySelector("#entrada");
        const hacerSalida = document.querySelector("#salida");

        const btnCerrarEntrada = document.querySelector("#cerrar-entrada");
        const btnCerrarSalida = document.querySelector("#cerrar-salida");

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
        });

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

