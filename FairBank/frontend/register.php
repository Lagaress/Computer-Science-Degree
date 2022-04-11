<?php
 
include('./database/config.php'); // Database configuration
session_start();
 
// Register funcionality 
if (isset($_POST['register'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'] ;
    $password_hash = password_hash($password, PASSWORD_BCRYPT); // Protect the sensible information
 
    $sql = "SELECT * FROM users WHERE username='$username'" ;
    $result = $connection->query($sql) ;

    $totalRow = mysqli_num_rows($result) ;
    if ($totalRow > 0) {
        $error1 = "This user is already register!" ;
    }
    else
    {
        $sql = ("INSERT INTO users(USERNAME,PASSWORD,ADDRESS) VALUES ('$username','$password','$address')");
        $result = $connection->query($sql) ;

        if ($result)
        {

            $sql = "SELECT * FROM users WHERE username='$username'" ;
            $result = $connection->query($sql) ;
            $row = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $row['id'];

            // Navigate
            header('Location: /MyFirstDapp/frontend/index.php'); // If register ok => Go to the bank page

        }
        else
        {

            $error2 = "Something went wrong during register! Try another time" ;

        }

    }
 
}

// Login funcionality
if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $sql = "SELECT * FROM users WHERE username='$username'" ;
    $result = $connection->query($sql) ;
    $row = mysqli_fetch_array($result);
    $totalRow = mysqli_num_rows($result) ;
 
    if ($totalRow == 0) {
        $error3 = "Username password combination is wrong!" ;
    } else {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: /MyFirstDapp/frontend/index.php'); // If register ok => Go to the bank page
        } else {
            $error4 = "Username password combination is wrong!" ;
        }
    }
}
 
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=devide-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <title>FairBank</title>
    </head>
<body>
    <div class ="login-form">
        <div class ="page-title-div">
            <img src="./images/logo.png" alt="page-title" height="100%" width="100%"/>
        </div>
        <form action="" method="post">
 
                <div class="input-container">
                    <input name="username" type="text" placeholder="User" required >
                    <br><br>
                    <input name="password" type="password" placeholder="Password" required >
                    <br><br>
                    <input name="address" type="text" placeholder="Address" required >
                    <br><br>
                </div>
                <button type="submit" name="login" value="login">Login</button>
                <button type="submit" name="register" value="register">Register</button>
        </form>
        <?php 
            if(isset($error1))
            {

                echo "<p style=\"color:red; margin-bottom:-8%; \">This user is already register!</p>" ;

            }

            if (isset($error2))
            {

                echo "<p style=\"color:red; margin-bottom:-8%; \">Something went wrong during register! Try another time!</p>" ;

            }
        
            if (isset($error3) or isset($error4) )
            {

                echo "<p style=\"color:red; margin-bottom:-8%; \">Username password combination is wrong!</p>" ;

            }
        ?>
    </div>


</body>
</html>
