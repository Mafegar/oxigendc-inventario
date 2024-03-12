

<?php

    session_start();
    require_once "./conexion_bd/conexion.php";


    if(isset($_POST["iniciar_sesion"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        // Consultamos a la base de datos para obtener el usuario y la contraseña.
        $sql = "SELECT * FROM usuarios WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        // Obtenemos la fila correspondiente a la consulta.
        $row = mysqli_fetch_assoc($result);

        // Verificamos si la contraseña ingresada es igual a la contraseña almacenada en la base de datos.
        if($password === $row["password"]){

            $_SESSION["username"] = $username;
            if($row["tipo_usuario"] == 1){
                header("Location: ./inventario_admin.php");
            } else {
                header("Location: ./user.html");
            }

        } else {
            echo "Usuario o contraseña incorrectos.";
            header("location: ./index.html");
        }
    }



?>
