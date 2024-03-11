
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
    <link rel="stylesheet" href="./styles/crear_articulo.css">
    <title>Gestionar Inventario</title>
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
                            <br><br>
                            <label for="marca">Marca: </label>
                            <input type="text" name="marca" id="marca" placeholder="Marca">
                            <br><br>
                            <label for="modelo">Modelo: </label>
                            <input type="text" name="modelo" id="modelo" placeholder="Modelo">
                            <br><br>
                        </div>  

                        <div class="colum2">
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
                            <label for="ubi">Ubicación: </label>
                            <select name="ubi" id="ubi" required>
                                <option value="">Seleccione la Ubicación</option>
                                <option value="Oxigen">Oxigen</option>
                                <option value="Entregado en Obra">Entregado en Obra</option>
                            </select>
                            <br><br>
                        </div>

                        <div class="colum3">
                            <label for="proveedor">Proveedor: </label>
                            <input type="text" name="proveedor" id="proveedor" placeholder="Proveedor" required>
                            <br><br>
                            <label for="unidades">Unidades: </label>
                            <input type="number" name="unidades" id="unidades" placeholder="Unidades" required>
                            <br><br>
                            <label for="tipo_articulo">Tipo de Articulo:</label>
                            <select name="tipo_articulo" id="tipo_articulo" required>
                                <option value="">Seleccione el Tipo de Articulo</option>
                                <option value="Activo">Activo</option>
                                <option value="Passivo">Passivo</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="crear_articulo" id="crear_articulo" value="Crear Articulo">
                </form>

            </div>
        
            <h2>Articulos actuales en el Inventario</h2>

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
    


</body>
</html>