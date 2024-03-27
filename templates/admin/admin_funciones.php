

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

        // Verificamos si en la columna de categoria_ident hay registros con la categoría 'cable', 'martillo', 'llave', etc.
        $sqlCateg = "SELECT 
                        SUM(categoria_ident LIKE 'CAB%') AS count_cab,
                        SUM(categoria_ident LIKE 'MRT%') AS count_mrt,
                        SUM(categoria_ident LIKE 'LLV%') AS count_llv
                    FROM articulos";

        $resultIdent = mysqli_query($conn, $sqlCateg);
        $rowIdent = mysqli_fetch_assoc($resultIdent);

        // Si no hay registros con la categoría "CAB", "MRT", "LLV"... Reiniciamos el valor de la tabla num_codigo a su valor inicial.
        if($rowIdent['count_cab'] == 0){
            $sqlResetCAB = "UPDATE categorias SET num_codigo = 1000 WHERE nombre = 'cable'";
            mysqli_query($conn, $sqlResetCAB);
        }
        if($rowIdent['count_mrt'] == 0){
            $sqlResetMRT = "UPDATE categorias SET num_codigo = 2000 WHERE nombre = 'martillo'";
            mysqli_query($conn, $sqlResetMRT);
        }
        if($rowIdent['count_llv'] == 0){
            $sqlResetLLV = "UPDATE categorias SET num_codigo = 3000 WHERE nombre = 'llave'";
            mysqli_query($conn, $sqlResetLLV);
        }

        $codigo_identi = '';

        // Verificamos si el articulo ya existe en la base de datos.
        $si_existe = false;

        while($row = mysqli_fetch_assoc($resultArticulo)){
            if($row["nombre"] == $nombre && $row["marca"] == $marca && $row["modelo"] == $modelo && $row["detalles"] == $detalles && $row["tipo_producto"] == $tipo_producto && $row["ubicacion"] == $ubicacion){
                $si_exsiste = true;
                break;
            }
        }
        
        if($si_existe){
            // Actualizamos las unidades del artículo en la base de datos si el artículo que se está creando ya existe.
            $sqlUpdate = "UPDATE articulos SET unidades = unidades + $unidades WHERE nombre = '$nombre' AND marca = '$marca' AND modelo = '$modelo' AND detalles = '$detalles' AND tipo_producto = '$tipo_producto' AND ubicacion = '$ubicacion'";
            $resultUpdate = mysqli_query($conn, $sqlUpdate);
        } else {
            
            if($categoria == 'cable'){
                // Obtener el valor actual de $num_codigo para la categoría 'Cable' desde la base de datos.
                $sqlCAB = "SELECT num_codigo FROM categorias WHERE nombre = 'cable'";
                $result = mysqli_query($conn, $sqlCAB);
                $row = mysqli_fetch_assoc($result);

                // Si se encuentra el valor en la base de datos, lo incrementamos.
                if ($row == TRUE) {
                    $num_codigo = intval($row['num_codigo']) + 1;
                } else {
                    // Si no hay valor en la base de datos, inicializamos $num_codigo a 1.
                    $num_codigo = 1;
                }

                // Actualizar el valor de $num_codigo en la base de datos.
                $sqlUpdate = "UPDATE categorias SET num_codigo = $num_codigo WHERE nombre = 'cable'";
                mysqli_query($conn, $sqlUpdate);

                // Construir el código identificativo para la categoría 'Cable'.
                $codigo_identi_cab = 'CAB' . sprintf("%03d", $num_codigo);

            } else if($categoria == 'martillo'){
                // Obtener el valor actual de $num_codigo para la categoría 'Cable' desde la base de datos.
                $sqlMRT = "SELECT num_codigo FROM categorias WHERE nombre = 'martillo'";
                $result = mysqli_query($conn, $sqlMRT);
                $row = mysqli_fetch_assoc($result);

                // Si se encuentra el valor en la base de datos, lo incrementamos.
                if ($row == TRUE) {
                    $num_codigo = intval($row['num_codigo']) + 1;
                } else {
                    // Si no hay valor en la base de datos, inicializamos $num_codigo a 1.
                    $num_codigo = 1;
                }

                // Actualizar el valor de $num_codigo en la base de datos.
                $sqlUpdate = "UPDATE categorias SET num_codigo = $num_codigo WHERE nombre = 'martillo'";
                mysqli_query($conn, $sqlUpdate);

                // Construir el código identificativo para la categoría 'Martillo'.
                $codigo_identi_mrt = 'MRT' . sprintf("%03d", $num_codigo);

            } else if($categoria == 'llave'){
                $sqlLLV = "SELECT num_codigo FROM categorias WHERE nombre = 'llave'";
                $result = mysqli_query($conn, $sqlLLV);
                $row = mysqli_fetch_assoc($result);

                // Si se encuentra el valor en la base de datos, lo incrementamos.
                if($row == TRUE){
                    $num_codigo = intval($row['num_codigo']) + 1;
                } else {
                    // Si no hay valor en la base de datos, inicializamos $num_codigo a 1.
                    $num_codigo = 1;
                }

                // Actualizar el valor de $num_codigo en la base de datos.
                $sqlUpdate = "UPDATE categorias SET num_codigo = $num_codigo WHERE nombre = 'llave'";
                mysqli_query($conn, $sqlUpdate);

                // Construir el código identificativo para la categoría 'Llave'.
                $codigo_identi_llv = 'LLV' . sprintf("%03d", $num_codigo);

            }

            
            // Ahora, continuamos con el switch
            switch($categoria){
                case 'cable':
                    $sigl_identi = 'CAB';
                    $codigo_identi_cab = $sigl_identi ."-". $num_codigo;
                    $num_codigo++;
                    break;
                case 'martillo':
                    $sigl_identi = 'MRT';
                    $codigo_identi_mrt = $sigl_identi ."-". $num_codigo;
                    $num_codigo++;
                    break;
                case 'llave':
                    $sigl_identi = 'LLV';
                    $codigo_identi_llv = $sigl_identi ."-". $num_codigo;
                    $num_codigo++;
                    break;
            }

            if($categoria == 'cable'){
                // Insertar el nuevo artículo en la base de datos si es tipo cable.
                if($tipo_producto == "Equipo"){
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_cab', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', '$fecha_control', '$fecha_siguiente',  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                } else {
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_cab', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', NULL , NULL,  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                }

            } else if($categoria == 'martillo'){
                // Insertar el nuevo artículo en la base de datos si es tipo martillo.
                if($tipo_producto == "Equipo"){
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_mrt', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', '$fecha_control', '$fecha_siguiente',  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                } else {
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_mrt', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', NULL , NULL,  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                }

            } else if($categoria == 'llave'){
                // Insertar el nuevo artículo en la base de datos si es tipo martillo.
                if($tipo_producto == "Equipo"){
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_llv', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', '$fecha_control', '$fecha_siguiente',  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                } else {
                    $sql = "INSERT INTO articulos (categoria_ident, nombre, marca, modelo, detalles, tipo_producto, fecha_control, fecha_sig_control, ubicacion, proveedor, unidades, forma_producto) 
                    VALUES ('$codigo_identi_llv', '$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', NULL , NULL,  '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";
                }
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