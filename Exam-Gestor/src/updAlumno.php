
</html><!DOCTYPE html>
<html>
    <head>
        <title>Actualizar Alumno</title>
        <link href="../templates/tabla.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <h1 style= "color: blue;">Selecciona un alumno</h1>
    <?php   
         $conexionadmin = mysqli_connect('localhost','teresa','ranateresa','universidad') ; 
         if (mysqli_connect_errno()) {
             printf("Conexión fallida: %s\n", mysqli_connect_error());
             die();
        }
        session_start();
        $_SESSION['nopass']=" ";
     

        
        $consulta = mysqli_query($conexionadmin, "SELECT * FROM persona where TIPO='ALUMNO'");
        $consultaalum = mysqli_query($conexionadmin, "SELECT * FROM alumno");
        $numcol = mysqli_num_rows($consulta);

        for( $i = 0 ; $i < $numcol ; $i++ ){
            $fila = mysqli_fetch_array($consulta);
            $filaalum = mysqli_fetch_array($consultaalum);

            if($i == 0){
                echo "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"./CRUD/modalumno.php\" > 
                <table class=\"encabezado\" > 
                <tr class = \"titulos\">
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Tipo</th>
                <th>DNI</th>
                <th>Seleccion</th>

                </tr>";
            }
                $dni = $fila['DNI'];
                echo  
                "<tr class=\"filas\" >
                <td> ".$fila['ID']." </td>
                <td> ".$fila['NOMBRE']." </td>
                <td> ".$fila['APELLIDOS']." </td>
                <td> ".$fila['TIPO']." </td>
                <td> ".$fila['DNI']." </td>
                <td> <input type=\"submit\" name=\"dni\" value=\"".$dni."\"  ></td>
                <tr>";
        }
        echo "</table></form>";
        $_SESSION['DNI']=$dni;
            
        mysqli_close($conexionadmin);
        
        echo " <br>   <form action=\"./paneladmin.php\" >
        <input type=\"submit\" value=\"Volver\" />
        </form>";

       
       

    ?>
    </body>
</html>