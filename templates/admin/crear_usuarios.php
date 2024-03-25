

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

    // Consultamos a la base de datos para obtener los usuarios.
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($conn, $sql);

    // Barra de búsqueda de usuarios.
    if(isset($_POST["boton-buscar"])){
        $buscarUsuario = $_POST["barra-buscar"];
        $tipoUsuario = $_POST["buscar-tipo-user"];

        if($tipoUsuario == "Admin"){
            // Consultamos a la base de datos para obtener los usuarios administradores.
            $sqlBuscarAdmin = "SELECT * FROM usuarios WHERE tipo_usuario = 1 ";
            $result = mysqli_query($conn, $sqlBuscarAdmin);

        } else if($tipoUsuario == "Users"){
            // Consultamos a la base de datos para obtener los usuarios normales.
            $sqlBuscarUsuario = "SELECT * FROM usuarios WHERE tipo_usuario = 0";
            $result = mysqli_query($conn, $sqlBuscarUsuario);
        
        } else {
            // Consultamos a la base de datos para obtener los datos del usuario.
            $sqlBuscarUsuarioNombre = "SELECT * FROM usuarios WHERE username LIKE '%$buscarUsuario%' OR nombre LIKE '%$buscarUsuario%' OR primer_apellido LIKE '%$buscarUsuario%' OR segundo_apellido LIKE '%$buscarUsuario%'";
            $result = mysqli_query($conn, $sqlBuscarUsuarioNombre);
        }


        
    }

    // Consulta para Modificar Usuario.
    $sqlModificarUsuario = "SELECT * FROM usuarios";
    $resultModificar = mysqli_query($conn, $sqlModificarUsuario);

    // Consulta para Eliminar Usuario.
    $sqlEliminarUsuario = "SELECT * FROM usuarios";
    $resultEliminar = mysqli_query($conn, $sqlEliminarUsuario);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Usuarios</title>

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

        /* FUNCIONES DE ARTICULOS */

        .funciones-usuarios{
            display: flex;
            justify-content: end;
        }

        .botones-acciones{
            display: flex;
            gap: 10px;
        }

        .buscador{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filtrar button i{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            font-style: normal;
        }

        #barra-buscar{
            width: 250px;
            text-align: center;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: 400;
        }

        #buscar-tipo-user{
            width: 150px;
            height: 21px;
            border-radius: 5px;
        }

        /* TABLA CREAR ARTICULO */

        .formulario-crear{
            padding-left: 20px;
        }

        .form-crear label, .form-modif label{
            margin-left: 20px;
        }

        .form-crear input{
            width: 200px;
        }

        #btn-crear-usuario, #btn-modificar-usuario{
            width: 100px;
            margin-top: 15px;
            margin-left: 20px;
            display: block !important;
        }

        /* CREAR / MODIFICAR / ELIMINAR */

        #formulario-usuarios{
            padding: 30px;
        }

        .titulo-crear-usuario{
            width: 670px;
            margin: auto;
        }

        .titulo-crear-usuario,.titulo-eliminar, .titulo-modificar{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo-crear-usuario button, .titulo-eliminar button, .titulo-modificar button{
            height: 25px;
            background-color: red;
            color: white;
            border-radius: 5px;
        }

        .mod-usuario{
            border: 1px solid black;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .botones-modificar{
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .boton-contra{
            display: flex;
            align-items: center;
            margin-top: 16px;
        }

        .boton-contra label{
            margin-left: 5px;
        }

        #eliminar-usuarios{
            width: 320px;
        }

        #eliminar-usuarios span{
            font-weight: 200;
        }

        #eliminar-usuarios input{
            width: 70px;
            height: 25px;
            background-color: red;
            color: white;
            border-radius: 5px;
        }

        #eliminar-usuarios form{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .usuarios{
            border: 1px solid black;
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .eliminar_usario{
            cursor: pointer;
        }

        .usuarios-info h4{
            margin-top: 10px;
            margin-bottom: 10px;
        }

        

        /* MOSTRAR USUARIOS */

        .ver-usuarios{
            width: 1100px;
            margin-top: ;
        }

        .ver-usuarios table{
            width: 100%;
            border-collapse: collapse;
        }

        .ver-usuarios table th, td{
            border: 1px solid black;
            padding: 8px;
        }

        /* BOTONES DE ACCIONES */

        #eliminar-usuario, #crear-usuario, #modificar-usuario{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            text-align: center;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }

        #eliminar-usuario{
            color: red;
        }

        #eliminar-usuario i, #crear-usuario i, #modificar-usuario i{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 0.9em;
            font-style: normal;
            font-family: "Raleway", sans-serif;
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

                <div class="buscador">

                    <h1>Usuarios Creados</h1>
                    
                    <div class="filtrar">
                        <form action="" method="post">
                            <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Usuario">
                            <select name="buscar-tipo-user" id="buscar-tipo-user">
                                <option value="">Tipo de Usuario</option>
                                <option value="Admin">Administrador</option>
                                <option value="Users">Usuario</option>
                            </select>
                            <button type="submit" name="boton-buscar" id="boton-buscar"><i class="bi bi-search">Buscar</i></button>
                        </form>
                    </div>

                </div>
            <form class="funciones-usuarios" action="" method="post">

                <div class="botones-acciones">
                    <div id="crear-usuario">
                        <i class="bi bi-clipboard2-plus-fill">Crear Usuario</i>
                    </div>
                    <!-- <input type="button" name="crear-usuario" id="crear-usuario" value="Crear Usuario"> -->

                    <div id="modificar-usuario">
                    <i class="bi bi-pen-fill">Modificar Usuarios</i>
                    </div>
                    <!-- <input type="button" name="modificar-usuario" id="modificar-usuario" value="Modificar Usuarios"> -->
                    
                    <div id="eliminar-usuario">
                        <i class="bi bi-trash-fill">Eliminar Usuarios</i>
                    </div>
                    <!-- <input type="button" name="eliminar-usuario" id="eliminar-usuario" value="Eliminar Usuarios"> -->
                </div>
            </form>
            <br>

            <dialog id="formulario-usuarios">

                <div class="titulo-crear-usuario">
                    <h2>Crear Usuario</h2>
                    <button id="cerrar-crear-usuario">X</button>
                </div>

                <form class="form-crear" action="admin_funciones.php" method="post">

                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del Usuario" required>

                    <label for="tipo_usuario">Tipo de Usuario: </label>
                    <select name="tipo_usuario" id="tipo_usuario">
                        <option value="1">Administrador</option>
                        <option value="0">Usuario</option>
                    </select>
                    <br><br>
                    <label for="primer_apellid">Primer Apellido: </label>
                    <input type="text" name="primer_apellido" id="primer_apellido" placeholder="Primer Apellido" required>

                    <label for="segundo_apellid">Segundo Apellido: </label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" placeholder="Segundo Apellido" required>
                    <br><br>
                    <label for="user">Nombre de Usuario: </label>
                    <input type="text" name="user" id="user" placeholder="Username">

                    <label for="pass">Contraseña: </label>
                    <input type="text" name="pass" id="pass" placeholder="Contraseña">
                    <br><br>
                    <input type="submit" name="crear-usuario" id="btn-crear-usuario" value="Crear Usuario">

                </form>

            </dialog>

            
            <dialog id="modificar-usuarios">

                <div class="titulo-modificar">
                    <h2>Modificar Usuarios</h2>
                    <button id="cerrar-modificar-usuario">X</button>
                </div>

                <div class="formulario-modificar">

                    <?php

                        // Verificamos si hay usuarios en la base de datos.
                        if($resultModificar -> num_rows > 0){

                            // Recorremos la base de datos para mostrar los usuarios.
                            while($row = $resultModificar -> fetch_assoc()){
                                echo "<div class='mod-usuario'>";
                                    echo "<form class='form-modif' action='admin_funciones.php' method='post'>";
                                        echo "<label for='nombre'>Nombre: </label>";
                                        echo "<input type='text' name='nombre' id='nombre' value='". $row["nombre"] ."' required>";

                                        echo "<label for='tipo_usuario'>Tipo de Usuario: </label>";
                                        echo "<input type='text' name='tipo_usuario' id='tipo_usuario' value='". $row["tipo_usuario"] ."' required>";
                                        echo "<br><br>";
                                        echo "<label for='primer_apellid'>Primer Apellido: </label>";
                                        echo "<input type='text' name='primer_apellido' id='primer_apellido' value='". $row["primer_apellido"] ."' required>";

                                        echo "<label for='segundo_apellid'>Segundo Apellido: </label>";
                                        echo "<input type='text' name='segundo_apellido' id='segundo_apellido' value='". $row["segundo_apellido"] ."' required>";
                                        echo "<br><br>";

                                        echo "<label for='user'>Nombre de Usuario: </label>";
                                        echo "<input type='text' name='user' id='user' value='". $row["username"] ."' required>";

                                        echo "<label for='pass'>Nueva Contraseña: </label>";
                                        echo "<input type='text' name='pass' id='pass' placeholder='Nueva contraseña (Opcional)'>";

                                        echo "<input type='hidden' name='id_usuario' value='" . $row["id_Usuario"] . "'>";
                                        echo "<div class='botones-modificar'>";
                                            echo "<input type='submit' name='modificar_usuario' id='btn-modificar-usuario' value='Modificar'>";
                                            echo "<div class='boton-contra'>";
                                                echo "<input type='hidden' name='cambio_contra' value='0'>";
                                                echo "<input type='checkbox' id='cambio_contra_marcador' name='cambio_contra' value='1'>";
                                                echo "<label for='cambio_contra_marcador'>Cambiar Contraseña</label>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</form>";


                                echo "</div>";
                            }


                        }


                    ?>



                </div>

            </dialog>


            <dialog id="eliminar-usuarios">

                <div class="titulo-eliminar">
                    <h2>Eliminar Usuarios</h2>
                    <button id="cerrar-eliminar-usuario">X</button>
                </div>

                <?php

                    // Verificamos si hay usuarios en la base de datos.
                    if($resultEliminar->num_rows > 0){
                        // Hacemos un bucle para mostrar todos los usuarios de la BBDD.
                        while($row = $resultEliminar->fetch_assoc()){
                            echo "<div class='usuarios'>";
                                echo "<form action='admin_funciones.php' method='post'>";
                                    echo "<div class='usuarios-info'>";
                                        echo "<h4> Nombre: <span>" . $row["nombre"] . "</span> <span>" . $row["primer_apellido"] . "</span></h4>";
                                        echo "<h4> User: <span>". $row["username"] ."</span></h4>";
                                    echo "</div>";
                                    echo "<input type='hidden' name='id_usuario' value='" . $row["id_Usuario"] . "'>";
                                    echo "<input type='submit' name='eliminar_usario' class='eliminar_usario' value='Eliminar'>";
                                echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "No hay usuarios en la base de datos.";
                    }

                ?>

            </dialog>



            <div class="ver-usuarios">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Tipo de Usuario</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            // Verificamos si hay usuarios en la base de datos.
                            if($result->num_rows > 0){
                                // Hacemos un bucle para mostrar todos los usuarios de la BBDD.
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>" . $row["nombre"] . "</td>";
                                    echo "<td>" . $row["primer_apellido"] . "</td>";
                                    echo "<td>" . $row["segundo_apellido"] . "</td>";
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "<td>" . $row["password"] . "</td>";
                                    echo "<td>" . $row["tipo_usuario"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                $mensaje_alert = "No se encontro ningun usuario con ese nombre.";
                                $mensaje = "No hay usuarios con ese nombre.";
                                echo "<script>alert('$mensaje_alert');</script>";
                                echo "<td style='text-align: center' colspan='11'>". $mensaje ."</td>";  
                            }


                        ?>

                    </tbody>
                </table>
            </div>


        </div>

    </div>
    

    <script>

        // Botones para abrir pestañas.
        const btnCrearUsuario = document.getElementById("crear-usuario");
        const btnModificarUsuario = document.getElementById("modificar-usuario");
        const btnEliminarUsuario = document.getElementById("eliminar-usuario");

        // Botones para cerrar pestañas.
        const btnCerrarCrearUsuario = document.getElementById("cerrar-crear-usuario");
        const btnCerrarModificarUsuario = document.getElementById("cerrar-modificar-usuario");
        const btnCerrarEliminarUsuario = document.getElementById("cerrar-eliminar-usuario");
        
        // Dialogos
        const formularioUsuarios = document.getElementById("formulario-usuarios");
        const modificarUsuarios = document.getElementById("modificar-usuarios");
        const eliminarUsuarios = document.getElementById("eliminar-usuarios");

        // Evento para abrir y cerrar de crear usuario.
        btnCrearUsuario.addEventListener("click", () => {
            formularioUsuarios.showModal();
        });

        btnCerrarCrearUsuario.addEventListener("click", () => {
            formularioUsuarios.close();
        });

        // Evento para abrir y cerrar de modificar usuario.
        btnModificarUsuario.addEventListener("click", () => {
            modificarUsuarios.showModal();
        });

        btnCerrarModificarUsuario.addEventListener("click", () => {
            modificarUsuarios.close();
        });
        
        // Evento para abrir y cerrar de eliminar usuario.
        btnEliminarUsuario.addEventListener("click", () => {
            eliminarUsuarios.showModal();
        });

        btnCerrarEliminarUsuario.addEventListener("click", () => {
            eliminarUsuarios.close();
        });

    </script>

</body>
</html>