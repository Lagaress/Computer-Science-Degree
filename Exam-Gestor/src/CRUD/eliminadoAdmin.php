<?php


    if($_POST['elec'] == 'si'){

        $conexionpersona = mysqli_connect('localhost','teresa','ranateresa','universidad') ; 
        if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            die();
        }

        $dni = $_POST['dni'];

        mysqli_query($conexionpersona ,"DELETE FROM persona WHERE DNI='$dni'");


    }else{
        header("Location: ../delAdministrador.php");
    }
    header("Location: ../delAdministrador.php")
?>