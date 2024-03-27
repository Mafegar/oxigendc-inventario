

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

    $sql = "SELECT * FROM articulos";
    $result = mysqli_query($conn, $sql);

    // Añadir los articulos a la base de datos.
    if(isset($_POST["crear_articulo"])){
        $nombre = $_POST["nombre"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $detalles = $_POST["detalles"];
        $tipo_producto = $_POST["tipo_producto"];
        $fecha_control = $_POST["fecha_control_inicio"];
        $fecha_siguiente = $_POST["fecha_control_final"];
        $categoria = $_POST["categoria"];
        $ubicacion = $_POST["ubi"];
        $proveedor = $_POST["proveedor"];
        $unidades = $_POST["unidades"];
        $tipo_articulo = $_POST["tipo_articulo"];

        // Hacemos una consulta para obtener los datos de los articulos que hay en la base de datos.
        $sqlArticulo = "SELECT * FROM articulos";
        $resultArticulo = mysqli_query($conn, $sqlArticulo);

        $codigo_identi = '';

        switch($categoria){
            case 'cable':
                $codigo_identi = 'CAB';
                break;
            case 'alicate':
                $codigo_identi = 'ALC';
                break;
            case 'llave':
                $codigo_identi = 'LLV';
                break;
        }

        

        $categoria_articulo = obtenerUltimoIdent($conn, $codigo_identi);
        $codigo_articulo_final = $codigo_identi ."-". $categoria_articulo;


        // Verificamos si el articulo ya existe en la base de datos.
        $si_exsiste = false;

        while($row = mysqli_fetch_assoc($resultArticulo)){
            if($row["nombre"] == $nombre && $row["marca"] == $marca && $row["modelo"] == $modelo && $row["detalles"] == $detalles && $row["tipo_producto"] == $tipo_producto && $row["ubicacion"] == $ubicacion){
                $si_exsiste = true;
                break;
            }
        }

        if($si_exsiste == true){
            // Actualizamos las unidades del articulo en la base de datos si el articulo que crea ya existe.
            $sqlUpdate = "UPDATE articulos SET unidades = unidades + $unidades WHERE nombre = '$nombre' AND marca = '$marca' AND modelo = '$modelo' AND detalles = '$detalles' AND tipo_producto = '$tipo_producto' AND ubicacion = '$ubicacion'";
            $resultUpdate = mysqli_query($conn, $sqlUpdate);
        } else {
            // Verificamos si el articulo es un equipo para insertar las fechas de control.
            if($tipo_producto == "Equipo"){
                $sql = "INSERT INTO articulos (cate_ident, ident_Arti, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                VALUES ('$codigo_identi', '$codigo_articulo_final', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', '$fecha_control', '$fecha_siguiente',  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
            } else {
                $sql = "INSERT INTO articulos (cate_ident, ident_Arti, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                VALUES ('$codigo_identi',  '$codigo_articulo_final', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', NULL , NULL,  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
            } 
        }

        if($conn->query($sql) === TRUE or $conn->query($sqlUpdate) === TRUE){
            $mensaje = "Articulo creado con éxito.";
            echo "<script> alert('". $mensaje ."') </script>";
            header("refresh: 0; url=anadir_articulo.php");
            exit();
        } else {
            echo "Error al crear el artículo: " . $conn->error;
        }

    }

    function obtenerUltimoIdent($conn, $codigo_identi){
        // Hacemos una consulta para obtener el ultimo identificador de articulo.
        $sqlIdenArticulo = "SELECT MAX(SUBSTRING(ident_Arti, LENGTH(cate_ident) + 2)) AS ultimo_iden FROM articulos WHERE cate_ident = '$codigo_identi'";
        // Ejecutamos la consulta.
        $resultIdenArticulo = $conn->query($sqlIdenArticulo);
    
        // Verificamos si se ha realizado la consulta.
        if($resultIdenArticulo->num_rows > 0){
            // Obtenemos el ultimo identificador de articulo
            $row = $resultIdenArticulo->fetch_assoc();
            $ultimo_iden = $row["ultimo_iden"];
            // Verificamos si el ultimo identificador es nulo.
            if($ultimo_iden == null){
                return '001';
            } else {
                // Incrementamos el identificador y lo formateamos adecuadamente (rellenando con ceros a la izquierda si es necesario)
                $siguiente_iden = str_pad($ultimo_iden + 1, 3, "0", STR_PAD_LEFT);
                return $siguiente_iden;
            }
        } else {
            return '001';
        }
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
            $sqlMovimiento = "INSERT INTO movimientos (tipo_movimiento, nombre_articulo, unidades, fecha_movimiento, ubicacion, nombre_usuario)
                VALUES ('Entrada', '$nombre_entr', '$unidades_entr', '$fecha_entr', 'Oxigen' ,'$nombre_usuario_entr')";

            // Comprobamos si se ha realizado la entrada en la tabla de movimientos.
            if($conn->query($sqlMovimiento) === TRUE){
                $mensaje = "Entrada realizada con éxito.";
                echo "<script> alert('". $mensaje ."') </script>";
                header("refresh: 0; url=anadir_articulo.php");
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
                    header("refresh: 0; url=anadir_articulo.php");
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
            header("refresh:0.5;url=anadir_articulo.php");
            exit();
        }
        
    } 

    // Modificar articulos de la base de datos.
    if(isset($_POST["modificar-articulo"])){
        $id_articulo = $_POST["id_articulo"];
        $nombre = $_POST["nombre"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $detalles = $_POST["detalles"];
        $tipo_producto = $_POST["tipo_producto_mod"];
        $fecha_control = $_POST["fecha_control_inicio_mod"];
        $fecha_siguiente = $_POST["fecha_control_final_mod"];
        $ubicacion = $_POST["ubi"];
        $proveedor = $_POST["proveedor"];
        $unidades = $_POST["unidades"];
        $tipo_articulo = $_POST["tipo_articulo"];

        $sql = "UPDATE articulos SET nombre = '$nombre', marca = '$marca', modelo = '$modelo', detalles = '$detalles', tipo_producto = '$tipo_producto', fecha_control = '$fecha_control', fecha_sig_control = '$fecha_siguiente', ubicacion = '$ubicacion', proveedor = '$proveedor', unidades = '$unidades', forma_producto = '$tipo_articulo' WHERE id_Articulo = '$id_articulo'";

        if($conn->query($sql) === TRUE){
            $mensaje = "Modificacion realizada con éxito.";
            echo "<script> alert('". $mensaje ."') </script>";
            header("refresh: 0; url=anadir_articulo.php");
            exit();
        } else {
            echo "Error al modificar el artículo: " . $conn->error;
        }

    }
    

    // Eliminar articulos de la base de datos.
    if(isset($_POST["eliminar-articulo"])){
        $id_articulo = $_POST["id_articulo"];

        $sql = "DELETE FROM articulos WHERE id_Articulo = '$id_articulo'";

        if($conn->query($sql) === TRUE){
            $mensaje = "Eliminación realizada con éxito.";
            echo "<script> alert('". $mensaje ."') </script>";
            header("refresh: 0; url=anadir_articulo.php");
            exit();
        } else {
            echo "Error al eliminar el artículo: " . $conn->error;
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
            $mensaje = "Se creo correctamemte el Usuario: ". $nombre ." " . $primer_apellido ."";
            echo "<script> alert('". $mensaje ."') </script>";
            header("refresh: 0; url=crear_usuarios.php");
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

        $sqlContraseña = "SELECT password FROM usuarios WHERE id_Usuario = '$id_usuario'";
        $resultPassword = mysqli_query($conn, $sqlContraseña);
        $row = mysqli_fetch_assoc($resultPassword);

        // Verificamos si se a solicitado un cambio de contraseña.
        if($cambio_contra == 1){

            if($nuevo_password == "" || $nuevo_password == null){
                $mensaje = "La contraseña no puede estar vacia.";
                echo "<script> alert('". $mensaje ."') </script>";
                header("refresh: 0; url=crear_usuarios.php");

            } else {
                
                if(password_verify($nuevo_password, $row["password"])){
                    $mensaje = "La contraseña no puede ser la misma que la anterior.";
                    echo "<script> alert('". $mensaje ."') </script>";
                    header("refresh: 0; url=crear_usuarios.php");

                } else {
                    $password = password_hash($nuevo_password, PASSWORD_DEFAULT);
    
                    // Actualizar los datos del usuario en la base de datos junto a la contraseña.
                    $sql = "UPDATE usuarios SET nombre = '$nombre', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido', username = '$username', password = '$password', tipo_usuario = '$tipo_usuario' WHERE id_Usuario = '$id_usuario'";
                }
            }
            
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