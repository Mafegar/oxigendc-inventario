

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

        if(password_verify($password,$row["password"])){

            $_SESSION["username"] = $username;
            $_SESSION["tipo_usuario"] = $row["tipo_usuario"];

            if($row["tipo_usuario"] == 1){
                header("Location: ./templates/admin/inventario_admin.php");
            } else {
                header("Location: ./templates/users/inventario_user.html");
            }

        } else {
            echo "Usuario o contraseña incorrectos.";
            header("location: ./index.html");
        }
    }



?>
