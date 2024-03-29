

<?php

    session_start();
    require_once("../../conexion_bd/conexion.php");

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else {
        header("location: ../../index.html");
        exit();
    }

    
    // Hacer una entrada a la base de datos.
    if(isset($_POST["hacer-entrada"])){
        $nombre_entr = $_POST["nombre-entr"];
        $unidades_entr = $_POST["unidades-entr"];
        $fecha_entr = $_POST["fecha-oper-entr"];

        // Consulta para obtener el nombre del usuario que ha iniciado sesión.
        $sqlNombreUsuaioEntr = "SELECT nombre FROM usuarios WHERE username = '$username'";
        $result = mysqli_query($conn, $sqlNombreUsuaioEntr);
        $nombre_usuario_entr = mysqli_fetch_assoc($result)["nombre"];

        // Consulta para obtener el id del articulo.
        $sqlidArticulo = "SELECT id_Articulo FROM articulos WHERE nombre = '$nombre_entr'";
        $resultIdArticulo = mysqli_query($conn, $sqlidArticulo);

        // Insertamos la entrada del articulo en la tabla de entradas.
        $sql = "INSERT INTO entradas (nombre_articulo, unidades, fecha_entrada, nombre_usuario)
            VALUES ('$nombre_entr', '$unidades_entr', '$fecha_entr', '$nombre_usuario_entr')";

        // Actualizamos las unidades del articulo en la tabla de articulos.
        $sqlActualizarUnidades = "UPDATE articulos SET unidades = unidades + $unidades_entr WHERE nombre = '$nombre_entr'";

        // Comprobamos si se ha realizado la entrada en la tabla de entradas.
        if($conn->query($sql) === TRUE && $conn->query($sqlActualizarUnidades) === TRUE){
            
            // Insertamos la entrada que hacemos en la tabla de movimientos.
            $sqlMovimiento = "INSERT INTO movimientos (tipo_movimiento, nombre_articulo, unidades, fecha_movimiento, nombre_usuario)
                VALUES ('Entrada', '$nombre_entr', '$unidades_entr', '$fecha_entr', '$nombre_usuario_entr')";

            // Comprobamos si se ha realizado la entrada en la tabla de movimientos.
            if($conn->query($sqlMovimiento) === TRUE){
                $mensaje = "Entrada realizada con éxito.";
                echo "<script> alert('". $mensaje ."') </script>";
                header("refresh: 0; url=anadir_articulo_user.php");
                exit();
            } else {
                echo "Error al realizar la entrada: " . $conn->error;
            }

        } else {
            echo "Error al realizar la entrada: " . $conn->error;
        }

    }

    // Hacer una salida a la base de datos.
    if(isset($_POST["hacer-salida"])){
        $nombre_sali = $_POST["nombre-sali"];
        $unidades_sali = $_POST["unidades-sali"];
        $ubicacion_sali = $_POST["ubi"];
        $fecha_sali = $_POST["fecha-oper-sali"];

        $sqlUnidades = "SELECT unidades FROM articulos WHERE nombre = '$nombre_sali'";
        $result = mysqli_query($conn, $sqlUnidades);
        $unidades = mysqli_fetch_assoc($result)["unidades"];

        // Consulta para obtener el nombre del usuario que ha iniciado sesión.
        $sqlNombreUsuaioSali = "SELECT nombre FROM usuarios WHERE username = '$username'";
        $result = mysqli_query($conn, $sqlNombreUsuaioSali);
        $nombre_usuario_sali = mysqli_fetch_assoc($result)["nombre"];

        // Consulta para obtener el id del articulo.
        $sqlidArticulo = "SELECT id_Articulo FROM articulos WHERE nombre = '$nombre_sali'";

        if($unidades < 0 || $unidades >= $unidades_sali){
            // Insertamos la salida del articulo en la tabla de salidas.
            $sql = "INSERT INTO salidas (nombre_articulo, unidades, fecha_salida, nombre_usuario)
            VALUES ('$nombre_sali', '$unidades_sali', '$fecha_sali', '$nombre_usuario_sali')";

            // Actualizamos las unidades del articulo en la tabla de articulos.
            $sqlActualizarUnidades = "UPDATE articulos SET unidades = unidades - $unidades_sali WHERE nombre = '$nombre_sali'";

            if($conn->query($sql) === TRUE && $conn->query($sqlActualizarUnidades) === TRUE){
                
                if($ubicacion_sali == "Oxigen"){
                    // Insertamos la entrada que hacemos en la tabla de movimientos.
                    $sqlMovimiento = "INSERT INTO movimientos (tipo_movimiento, nombre_articulo, unidades, fecha_movimiento, ubicacion ,nombre_usuario)
                        VALUES ('Salida', '$nombre_sali', '$unidades_sali', '$fecha_sali', 'Oxigen' ,'$nombre_usuario_sali')";
                } else {
                    // Insertamos la entrada que hacemos en la tabla de movimientos.
                    $sqlMovimiento = "INSERT INTO movimientos (tipo_movimiento, nombre_articulo, unidades, fecha_movimiento, ubicacion ,nombre_usuario)
                        VALUES ('Salida', '$nombre_sali', '$unidades_sali', '$fecha_sali', 'Obra' ,'$nombre_usuario_sali')";
                }

                // Comprobamos si se ha realizado la entrada en la tabla de movimientos.
                if($conn->query($sqlMovimiento) === TRUE){
                    $mensaje = "Salida realizada con éxito.";
                    echo "<script> alert('". $mensaje ."') </script>";
                    header("refresh: 0; url=anadir_articulo_user.php");
                    exit();
                } else {
                    echo "Error al realizar la salida: " . $conn->error;
                }
            } else {
                echo "Error al realizar la salida: " . $conn->error;
            }
        } else {
            $mensaje = "No hay suficientes unidades para realizar la salida.";
            echo "<script> alert('". $mensaje ."') </script>";
            header("refresh:0.5;url=anadir_articulo_user.php");
            exit();
        }
        
    }
    /**------------------------------------------------------------------------ */

    // Crear Usuarios y añadirlos a la base de datos.
    if(isset($_POST["crear-usuario"])){
        $nombre = $_POST["nombre"];
        $primer_apellido = $_POST["primer_apellido"];
        $segundo_apellido = $_POST["segundo_apellido"];
        $username = $_POST["user"];
        $password = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        $tipo_usuario = $_POST["tipo_usuario"];

        // Insertamos los datos en la base de datos.
        $sql = "INSERT INTO usuarios (nombre, primer_apellido, segundo_apellido, username, password, tipo_usuario)
            VALUES ('$nombre', '$primer_apellido', '$segundo_apellido', '$username', '$password', '$tipo_usuario')";

        if($conn->query($sql) === TRUE){
            header("Location: crear_usuarios.php");
            exit();
        } else {
            echo "Error al crear el usuario: " . $conn->error;
        }
    }


    // Modificar usuarios de la base de datos.
    if(isset($_POST["modificar_usuario"])){
        $id_usuario = $_POST["id_usuario"];
        $nombre = $_POST["nombre"];
        $primer_apellido = $_POST["primer_apellido"];
        $segundo_apellido = $_POST["segundo_apellido"];
        $username = $_POST["user"];
        $nuevo_password = $_POST["pass"];
        $tipo_usuario = $_POST["tipo_usuario"];

        if(isset($_POST["cambio_contra"])){
            $cambio_contra = $_POST["cambio_contra"]; 
        } else {
            $cambio_contra = 0;
        }

        // Verificamos si se a solicitado un cambio de contraseña.
        if($cambio_contra == 1){
            $password = password_hash($nuevo_password, PASSWORD_DEFAULT);

            // Actualizar los datos del usuario en la base de datos junto a la contraseña.
            $sql = "UPDATE usuarios SET nombre = '$nombre', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido', username = '$username', password = '$password', tipo_usuario = '$tipo_usuario' WHERE id_Usuario = '$id_usuario'";

        } else {
            // Actualizar los datos del usuario en la base de datos sin la contraseña.
            $sql = "UPDATE usuarios SET nombre = '$nombre', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido', username = '$username', tipo_usuario = '$tipo_usuario' WHERE id_Usuario = '$id_usuario'";
        }
       

        if($conn->query($sql) === TRUE){
            header("Location: crear_usuarios.php");
            exit();
        } else {
            echo "Error al modificar el usuario: " . $conn->error;
        }
    }


    // Eliminar usuarios de la base de datos.
    if(isset($_POST["eliminar_usario"])){
        $id_usuario = $_POST["id_usuario"];

        $sql = "DELETE FROM usuarios WHERE id_Usuario = '$id_usuario'";

        if($conn->query($sql) === TRUE){
            header("Location: crear_usuarios.php");
            exit();
        } else {
            echo "Error al eliminar el usuario: " . $conn->error;
        }

    }





?>