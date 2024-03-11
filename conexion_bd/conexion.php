
<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "inventario";

    $conn = new mysqli($host, $user, $pass, $db);
    mysqli_query($conn, "SET character_set_results=utf8");
    if($conn -> connect_error){
        die("Error en la conexion: " . $conn -> connect_error);
    }

?>