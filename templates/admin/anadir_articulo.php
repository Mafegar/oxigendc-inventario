
<?php

    session_start();
    require_once("../../conexion_bd/conexion.php");

    // Verificamos si el usuario ha iniciado sesión.
    if(isset($_SESSION['username']) && $_SESSION["tipo_usuario"] == 1){
        $username = $_SESSION['username'];
    } else {
        header("location: ../../index.html");
        exit();
    }

    // Hacemos una consulta a la base de datos para obtener los articulos.
    $sql = "SELECT * FROM articulos";
    $result = mysqli_query($conn, $sql);

    // Barra de navegación para buscar un articulo.
    if(isset($_POST["boton-buscar"])){
        $busuqeda = $_POST["barra-buscar"];
        $tipo_articulo = $_POST["buscar-tipo-arti"];

        if($tipo_articulo == "Equipo") {
            // Consultamos la base de bbdd para obeter los articulos de tipo Equipo.
            $sqlBuscarArticulo = "SELECT * FROM articulos WHERE tipo_producto = 'Equipo'";
            $result = mysqli_query($conn, $sqlBuscarArticulo);

        } else if ($tipo_articulo == "Kit") {
            // Consultamos la base de bbdd para obeter los articulos de tipo Kit Maleta.
            $sqlBuscarArticulo = "SELECT * FROM articulos WHERE tipo_producto = 'Kit Maleta'";
            $result = mysqli_query($conn, $sqlBuscarArticulo);

        } else if($tipo_articulo == "Herramienta"){
            // Consultamos la base de bbdd para obeter los articulos de tipo Herramienta.
            $sqlBuscarArticulo = "SELECT * FROM articulos WHERE tipo_producto = 'Herramienta'";
            $result = mysqli_query($conn, $sqlBuscarArticulo);

        } else {
            // Consultamos la bbdd para obtener los articulos que busque el usuario a traves de la barra de busqueda.
            $sqlBuscarArticulo = "SELECT * FROM articulos WHERE nombre LIKE '%$busuqeda%'";
            $result = mysqli_query($conn, $sqlBuscarArticulo);
        }
        
    }

    // Hacemos una consulta a la base de datos para obtener los articulos y hacer entradas.
    $sqlHacerEntrada = "SELECT * FROM articulos";
    $resultHacerEntrada = mysqli_query($conn, $sqlHacerEntrada);

    // Hacemos una consulta a la base de datos para obtener los articulos y hacer Salidas.
    $sqlHacerSalida = "SELECT * FROM articulos";
    $resultHacerSalida = mysqli_query($conn, $sqlHacerSalida);

    // Hacemos una consulta a la base de datos para obtener los articulos y poder Modificarlos.
    $sqlModificarArticulo = "SELECT * FROM articulos";
    $resultModificarArticulo = mysqli_query($conn, $sqlModificarArticulo);

    // Barras de navegación para buscar un articulos y modificarlos mas rapido.
    if(isset($_POST["boton-buscar-mod"])){
        $buscarMod = $_POST["barra-buscar-mod"];

        // Hacemos una consulta a la base de datos para obtener los articulos y poder Modificarlos.
        $sqlBuscarArticuloMod = "SELECT * FROM articulos WHERE nombre LIKE '%$buscarMod%'";
        $resultModificarArticulo = mysqli_query($conn, $sqlBuscarArticuloMod);

    }    

    // Hacemos una consulta a la base de datos para obtener los articulos y poder Eliminarlos.
    $sqlEliminarArticulo = "SELECT * FROM articulos";
    $resultEliminarArticulo = mysqli_query($conn, $sqlEliminarArticulo);



    
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
            width: 1100px;
            margin: auto;
        }

        .container h1{
            margin-top: 30px;
            margin-bottom: 30px;
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
            width: 1100px;
            margin: auto;
            margin-bottom: 30px;
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

        .buscador select{
            height: 21px;
        }


        /* HACER ENTRADA Y SALIDAS*/

        .titulo-entrada, .titulo-salida, .titulo-crear-articulo, .titulo-eliminar, .titulo-modificar{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo-entrada button, .titulo-salida button, .titulo-crear-articulo button, .titulo-eliminar button, .titulo-modificar button{
            height: 25px;
            background-color: red;
            color: white;
            border-radius: 5px;
        }

        /* TABLA PARA PODER BORRAR ARTICULOS */

        #eliminar-articulo{
            width: 500px;
        }

        #eliminar-articulo span{
            font-weight: 200;
        }

        #eliminar-articulo input{
            width: 120px;
            height: 25px;
            background-color: red;
            color: white;
            border-radius: 5px;
        }

        #eliminar-articulo form{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .articulo-eliminar, .mod-articulo{
            border: 1px solid black;
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .articulo-info h4{
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .mod-articulo label{
            margin-left: 10px;
        }
        
        .mod-articulo #modificar-articulo{
            background-color: red;
            border: 1px solid black;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }


    </style>

</head>
<body>

    <header>
        <div class="logo">
            <a href="./inventario_admin.html"><img src="../../img/logo-oxigen.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <li><a href="./inventario_admin.php">Inicio</a></li>
                <li><a href="./anadir_articulo.php">Inventario</a></li>
                <li><a href="./crear_usuarios.php">Usuarios</a></li>
                <li><a href="../ver_movimientos.php">Historial de Movimientos</a></li>
                <li><a href="../../conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>
    
    
    <div id="cuerpo">   

        <div class="container">
        
            <h1>Articulos en el Inventario</h1>

            <form class="funciones-articulos" action="" method="post">
                <div class="buscador">
                    <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Articulo">

                    <select name="buscar-tipo-arti" id="buscar-tipo-arti">
                        <option value="">Escoja una opcion</option>
                        <option value="Equipo">Equipo</option>
                        <option value="Kit">Kit Maleta</option>
                        <option value="Herramienta">Herramienta</option>
                    </select>

                    <input type="submit" name="boton-buscar" id="boton-buscar" value="Buscar">
                </div>



                <div class="botones-acciones">
                    <input type="button" name="crear-articulo" id="crear-articulo" value="Crear Articulo">

                    <input type="button" name="modificar" id="modificar" value="Modificar Articulo">

                    <input type="button" name="entrada" id="entrada" value="Entrada de Articulos">
                    
                    <input type="button" name="salida" id="salida" value="Salida de Articulos">

                    <input type="button" name="eliminar" id="eliminar" value="Eliminar Articulo">
                </div>
            </form>
            <br>

            <dialog id="formulario-crear">

                <div class="titulo-crear-articulo">
                    <h2>Crear Articulo</h2>
                    <button id="cerrar-crear-articulo">X</button>
                </div>

                <form class="form-crear" action="./admin_funciones.php" method="post">

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

            </dialog>

            <dialog id="entrada-articulo">
                <div class="titulo-entrada">
                    <h2>Entradas de Articulos</h2>
                    <button id="cerrar-entrada">X</button>
                </div>

                <form class="form-entrada" action="./admin_funciones.php" method="post">
                    
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

                <form class="form-salida" action="./admin_funciones.php" method="post">
                    
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
                    <label for="ubi">Ubicación: </label>
                    <select name="ubi" id="ubi" required>
                        <option value="">Seleccione la Ubicación</option>
                        <option value="Oxigen">Oxigen</option>
                        <option value="Entregado en Obra">Entregado en Obra</option>
                    </select>
                    <br><br>
                    <label for="fecha-oper-sali">Fecha Entrada: </label>
                    <input type="date" name="fecha-oper-sali" id="fecha-oper-sali" >
                    <br><br>
                    <input type="submit" name="hacer-salida" id="hacer-salida" value="Guardar Salida" required>

                </form>

            </dialog>

            <dialog id="eliminar-articulo">

                <div class="titulo-eliminar">
                    <h2>Eliminar Articulo</h2>
                    <button id="cerrar-eliminar">X</button>
                </div>

                <?php

                    if($resultEliminarArticulo->num_rows > 0){
                        
                        while($row = $resultEliminarArticulo -> fetch_assoc()){
                            echo "<div class='articulo-eliminar'>";
                                echo "<form action='admin_funciones.php' method='post'>";
                                    echo "<div class='articulo-info'>";
                                        echo "<h4> Articulo: <span>" . $row["nombre"] . "</span></h4>";
                                        echo "<h4> Tipo Producto: <span>" . $row["tipo_producto"] . "</span></h4>";
                                        echo "<h4> Ubicación: <span>" . $row["ubicacion"] . "</span></h4>";
                                        echo "<h4> Unidades: <span>" . $row["unidades"] . "</span></h4>";
                                    echo "</div>";
                                    echo "<input type='hidden' name='id_articulo' value='" . $row["id_Articulo"] . "'>";
                                    echo "<input type='submit' name='eliminar-articulo' id='eliminar-articulo' value='Eliminar Articulo'>";
                                echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No hay articulos</p>";
                    }

                ?>

            </dialog>

            <dialog id="modificar-articulo">

                <div class="titulo-modificar">
                    <h2>Modificar Articulo</h2>
                    <!-- <form action="" method="post">
                        <div class="buscador">
                            <input type="text" name="barra-buscar-mod" id="barra-buscar-mod" placeholder="Buscar Articulo">
                            <input type="submit" name="boton-buscar-mod" id="boton-buscar-mod" value="Buscar" onclick="mostrarDialogoModificar()">
                        </div>
                    </form> -->
                    <button id="cerrar-modificar">X</button>
                </div>

                <div class="formulario-modificar">

                    <?php

                        if($resultModificarArticulo->num_rows > 0){
                            $contador = 1;
                            while($row = $resultModificarArticulo -> fetch_assoc()){

                                echo "<div class='mod-articulo'>";
                                    echo "<h4>" . $row["nombre"] . "</h4>";
                                    echo "<form class='form-modif' action='admin_funciones.php' method='post'>";
                                        echo "<label for='nombre'>Nombre: </label>";
                                        echo "<input type='text' name='nombre' id='nombre' value='". $row["nombre"] ."'>";

                                        echo "<label for='marca'>Marca: </label>";
                                        echo "<input type='text' name='marca' id='marca' value='". $row["marca"] ."'>";

                                        echo "<label for='modelo'>Modelo: </label>";
                                        echo "<input type='text' name='modelo' id='modelo' value='". $row["modelo"] ."'>";
                                        echo "<br><br>";

                                        echo "<label for='detalles'>Detalles: </label>";
                                        echo "<input type='text' name='detalles' id='detalles' value='". $row["detalles"] ."'>";

                                        echo "<label for='tipo_producto_mod'>Tipo de Producto: </label>";
                                        echo "<select name='tipo_producto_mod' class='tipo_producto_mod' onchange='mostrarDivFechaControl(this.value, $contador)'>";
                                            echo "<option value=''> Escoja una Opcion</option>";
                                            echo "<option value='Equipo'>Equipo</option>";
                                            echo "<option value='Kit Maleta'>Kit Maleta</option>";
                                            echo "<option value='Herramienta'>Herramienta</option>";
                                        echo "</select>";
                                        echo "<br><br>";

                                        echo "<div id='fecha-control-inicio-$contador' style='display: none;'>";
                                            echo "<label for='fecha_control_inicio_mod'>Fecha Control: </label>";
                                            echo "<input type='date' name='fecha_control_inicio_mod' id='fecha_control_inicio_mod' value='". $row["fecha_control"] ."'>";
                                            echo "<br><br>";
                                        echo "</div>";
                                        echo "<div id='fecha-control-final-$contador' style='display: none;'>";
                                            echo "<label for='fecha_control_final_mod'>Fecha Sigiente Control: </label>";
                                            echo "<input type='date' name='fecha_control_final_mod' id='fecha_control_final_mod'>";
                                            echo "<br><br>";
                                        echo "</div>";

                                        echo "<label for='ubi'>Ubicación: </label>";
                                        echo "<select name='ubi' id='ubi'>";
                                            echo "<option value='Oxigen'>Oxigen</option>";
                                            echo "<option value='Entregado en Obra'>Entregado en Obra</option>";
                                        echo "</select>";

                                        echo "<label for='proveedor'>Proveedor: </label>";
                                        echo "<input type='text' name='proveedor' id='proveedor' value='". $row["proveedor"] ."'>";

                                        echo "<label for='unidades'>Unidades: </label>";
                                        echo "<input type='number' name='unidades' id='unidades' value='". $row["unidades"] ."'>";

                                        echo "<label for='tipo_articulo'>Tipo de Articulo: </label>";
                                        echo "<select name='tipo_articulo' id='tipo_articulo'>";
                                            echo "<option value='Activo'>Activo</option>";
                                            echo "<option value='Passivo'>Passivo</option>";
                                        echo "</select>";
                                        echo "<br><br>";

                                        echo "<input type='hidden' name='id_articulo' value='". $row["id_Articulo"] ."'>";
                                        echo "<input type='submit' name='modificar-articulo' id='modificar-articulo' value='Modificar Articulo'>";

                                    echo "</form>"; 
                                echo "</div>";

                                $contador++;
                            }
                            
                        }

                    ?>

                </div>


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
                            <th>Fecha Control</th>
                            <th>Siguiente Control</th>
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
                                        echo "<td>" . $row["fecha_control"] . "</td>";
                                        echo "<td>" . $row["fecha_sig_control"] . "</td>";
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
                                        echo "<td>" . $row["fecha_control"] . "</td>";
                                        echo "<td>" . $row["fecha_sig_control"] . "</td>";
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

        
        function mostrarDialogoModificar(){
            var dialogoModificar = document.getElementById('modificar-articulo');
            dialogoModificar.showModal();
        }

        // Botones para abrir los dialogos.
        const hacerEntrada = document.querySelector("#entrada");
        const hacerSalida = document.querySelector("#salida");
        const hacerArticulo = document.querySelector("#crear-articulo");
        const articuloEliminado = document.querySelector("#eliminar");
        const articuloModificar = document.querySelector("#modificar");
        const BuscarModificar = document.querySelector("#boton-buscar-mod");


        // Botones para cerrar los dialogos.
        const btnCerrarEntrada = document.querySelector("#cerrar-entrada");
        const btnCerrarSalida = document.querySelector("#cerrar-salida");
        const btnCrearArticulo = document.querySelector("#cerrar-crear-articulo");
        const btnEliminaeArticulo = document.querySelector("#cerrar-eliminar");
        const btnModificarArticulo = document.querySelector("#cerrar-modificar");

        // Dialogos.
        const entradaArticulo = document.querySelector("#entrada-articulo");
        const salidaArticulo = document.querySelector("#salida-articulo");
        const crearArticulo = document.querySelector("#formulario-crear");
        const eliminarArticulo = document.querySelector("#eliminar-articulo");
        const modificarArticulo = document.querySelector("#modificar-articulo");
        
        // Evento para abrir y cerrar el Hacer Entrada.
        hacerEntrada.addEventListener("click", () => {
            entradaArticulo.showModal();
        });

        btnCerrarEntrada.addEventListener("click", () => {
            entradaArticulo.close();
        });

        // Evento para abrir y cerrar el Hacer Salida.
        hacerSalida.addEventListener("click", () => {
            salidaArticulo.showModal();
        });

        btnCerrarSalida.addEventListener("click", () => {
            salidaArticulo.close();
        });

        // Evento para abrir y cerrar el Crear Articulo.
        hacerArticulo.addEventListener("click", () => {
            crearArticulo.showModal();
        });

        btnCrearArticulo.addEventListener("click", () => {
            crearArticulo.close();
        });

        // Evento para abrir y cerrar el Modificar Articulo.
        articuloModificar.addEventListener("click", () => {
            modificarArticulo.showModal();
        });

        btnModificarArticulo.addEventListener("click", () => {
            modificarArticulo.close();
        });


        // Evento para abrir y cerrar el Eliminar Articulo.
        articuloEliminado.addEventListener("click", () => {
            eliminarArticulo.showModal();
        });

        btnEliminaeArticulo.addEventListener("click", () => {
            eliminarArticulo.close();
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

        

        function mostrarDivFechaControl(valor, contador){
            var divFechaControlInicio = document.getElementById('fecha-control-inicio-' + contador);
            var divFechaControlFinal = document.getElementById('fecha-control-final-' + contador);
            if(valor === 'Equipo'){
                divFechaControlInicio.style.display = 'block';
                divFechaControlFinal.style.display = 'block';
            } else {
                divFechaControlInicio.style.display = 'none';
                divFechaControlFinal.style.display = 'none';
            }

        }
        

        

    </script>
    


</body>
</html>

