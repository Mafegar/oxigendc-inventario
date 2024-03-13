

<?php

    session_start();
    require_once "./conexion_bd/conexion.php";

    // Verificamos si el usuario ha iniciado sesión.
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else {
        header("location: ./index.html");
        exit();
    }

    // Consultamos a la base de datos para obtener los usuarios.
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($conn, $sql);

    // Barra de búsqueda de usuarios.
    if(isset($_POST["boton-buscar"])){
        $buscarUsuario = $_POST["barra-buscar"];

        // Consultamos a la base de datos para obtener los datos del usuario.
        $sqlBuscarUsuario = "SELECT * FROM usuarios WHERE username LIKE '%$buscarUsuario%' OR nombre LIKE '%$buscarUsuario%' OR primer_apellido LIKE '%$buscarUsuario%'";
        $result = mysqli_query($conn, $sqlBuscarUsuario);
    }

    $sqlEliminarUsuario = "SELECT * FROM usuarios";
    $resultEliminar = mysqli_query($conn, $sqlEliminarUsuario);

    if(isset($_POST["eliminar_usuario"])){
        $eliminarUsuario = $_POST["eliminar_usuario"];

        $sqlEliminar = "DELETE FROM usuarios WHERE username = '$eliminarUsuario'";
        $resultEliminar = mysqli_query($conn, $sqlEliminar);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Usuarios</title>

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

        .funciones-usuarios{
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

        #btn-crear-usuario{
            width: 100px;
            margin-left: 20px;
        }

        /* MODIFICAR Y ELIMINAR*/

        .titulo-crear-usuario{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .titulo-crear-usuario button{
            height: 25px;
            background-color: red;
            color: white;
        }

        /* MOSTRAR USUARIOS */

        .ver-usuarios{
            width: 1000px;
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
                
                <li><a href="">Historial de Movimientos</a></li>
                <li><a href="./conexion_bd/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>

    <div id="cuerpo">

        <div class="container">

            <h1>Usuarios Creados</h1>

            <form class="funciones-usuarios" action="" method="post">
                <div class="buscador">
                    <input type="text" name="barra-buscar" id="barra-buscar" placeholder="Buscar Usuario">
                    <input type="submit" name="boton-buscar" id="boton-buscar" value="Buscar">
                </div>

                <div class="botones-acciones">
                    <input type="button" name="crear-articulo" id="crear-usuario" value="Crear Usuario">

                    <input type="button" name="modificar-usuario" id="modificar-usuario" value="Modificar Usuarios">

                    <input type="button" name="eliminar-usuario" id="eliminar-usuario" value="Eliminar Usuarios">
                </div>
            </form>
            <br>

            <dialog id="formulario-usuarios">

                <div class="titulo-crear-usuario">
                    <h2>Crear Usuario</h2>
                    <button id="cerrar-crear-usuario">X</button>
                </div>

                <form class="form-crear" action="admin_articulos.php" method="post">

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
            
            <dialog id="modificar-articulos">


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
                            echo "<form action='' method='post'>";
                            echo "<h4>" . $row["nombre"] . " " . $row["primer_apellido"] . "</h4>";
                            echo "<h4>". $row["username"] ." " . $row["tipo_usuario"] ."</h4>";
                            echo "<input type='hidden' name='nombre_usuario' value='" . $row["username"] . "'>";
                            echo "<input type='submit' name='eliminar_usario' value='Eliminar'>";
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
                                echo "No hay usuarios en la base de datos.";
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
        // const btnModificarUsuario = document.getElementById("modificar-usuario");
        const btnEliminarUsuario = document.getElementById("eliminar-usuario");

        // Botones para cerrar pestañas.
        const btnCerrarCrearUsuario = document.getElementById("cerrar-crear-usuario");
        // const btnCerrarModificarUsuario = document.getElementById("cerrar-modificar-usuario");
        const btnCerrarEliminarUsuario = document.getElementById("cerrar-eliminar-usuario");
        
        // Dialogos
        const formularioUsuarios = document.getElementById("formulario-usuarios");
        // const modificarUsuarios = document.getElementById("modificar-usuarios");
        const eliminarUsuarios = document.getElementById("eliminar-usuarios");

        btnCrearUsuario.addEventListener("click", () => {
            formularioUsuarios.showModal();
        });

        btnCerrarCrearUsuario.addEventListener("click", () => {
            formularioUsuarios.close();
        });
        

        btnEliminarUsuario.addEventListener("click", () => {
            eliminarUsuarios.showModal();
        });

        btnCerrarEliminarUsuario.addEventListener("click", () => {
            eliminarUsuarios.close();
        });

    </script>

</body>
</html>