

<?php

    session_start();
    require_once "./conexion_bd/conexion.php";

    // Añadir los articulos a la base de datos.
    if(isset($_POST["crear_articulo"])){
        $nombre = $_POST["nombre"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $detalles = $_POST["detalles"];
        $tipo_producto = $_POST["tipo_producto"];
        $ubicacion = $_POST["ubi"];
        $proveedor = $_POST["proveedor"];
        $unidades = $_POST["unidades"];
        $tipo_articulo = $_POST["tipo_articulo"];

        $sql = "INSERT INTO articulos (nombre, marca, modelo, detalles, tipo_producto, ubicacion, proveedor, unidades, forma_producto) 
            VALUES ('$nombre', '$marca', '$modelo', '$detalles', '$tipo_producto', '$ubicacion', '$proveedor', '$unidades', '$tipo_articulo')";

        if($conn->query($sql) === TRUE){
            echo "Artículo creado con éxito.";
            header("Location: anadir_articulo.php");
            exit();
        } else {
            echo "Error al crear el artículo: " . $conn->error;
        }

    }



?>