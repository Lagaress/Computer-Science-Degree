<?php
include('./database/config.php'); // Database configuration
session_start();
 
// We restrict access to users unless they are logged in.
if(!isset($_SESSION['user_id'])){
    header('Location: /MyFirstDapp/frontend/register.php');
    exit;
} else {
}

// Logout Button 
if (isset($_POST['logoutButton'])) {

    session_start();
    unset($_SESSION);
    session_destroy();
    session_write_close();
    header('Location: /MyFirstDapp/frontend/register.php');
    die;

}

// Add a Relative
if (isset($_POST['addRelativeButton'])) {
 
    // The searched user
    $relative2 = $_POST['relativeUser'];
    // The user that did the query
    $relative1 = $_SESSION['user_id'] ; 

    // Search the user to check if exist
    $sql = "SELECT id from users WHERE username='$relative2'" ;
    $result = $connection->query($sql) ;
    $row = mysqli_fetch_array($result);

    if (!$result) { // Is null
        $error1 = "This user doesn't exist!" ;
    } else {

        $sql = "SELECT id from users WHERE username='$relative2'" ;
        $result = $connection->query($sql) ;
        $row = mysqli_fetch_array($result);
        $relative2 = $row[0] ; 
        
        $sql = "SELECT * from relations WHERE relative1='$relative1'" ;
        $result = $connection->query($sql) ;
        $row = mysqli_fetch_array($result);
        $auxiliarFlag = true ; 
        while($row = $result->fetch_assoc() and $auxiliarFlag ) {

            if ( $row['relative2'] == $relative2 )
            {

                $auxiliarFlag = false ; 

            }

        }

        if (!$auxiliarFlag)
        {

            $error2 = "Your family member is already on your list" ;

        }

        else
        {

            $sql = ("INSERT INTO relations(RELATIVE1,RELATIVE2) VALUES ($relative1,$relative2)");
            $result = $connection->query($sql) ;
            $successMessage = "Family added" ; 


        }

        
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=devide-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>FairBank</title>

</head>

<body>

    <div class = "content">
    <form>
        <div class ="page-title-div">
            <img src="./images/logo.png" alt="page-title" height="70%" width="70%"/>
        </div>

    <div id="contenedor"> 
        <div class = "balanceAccount">
            <p>Check an account balance:</p>
            <div class="input-group1 ">
                <div class="input-container">
                    <input id="addressGetBalance" type="text" class="form-control" placeholder="Account Address">
                </div>
                <br>
                <button class="btn btn-success" type="button" id="btnGetBalance">Ver el Balance</button>
                <p class="col-12 text-center p-3 h6 bg-secondary text-white mt-3"><span id="balance">Balance: 0 ACOIN</span></p>
            </div>
        </div>

        <div class = "transferAccount">
            <p>Transfer FBCOIN to a Relative</p>
            <div class="input-container">
                <input type="text" class="form-control" id="addressBeneficiaria" placeholder="Destiny Account Address">
                <br> <br>
                <input type="number" class="form-control" id="cantidad" placeholder="Amount of FBCOIN">
            </div>
            <br>
            <button class="btn btn-success d-block" style="margin-left: auto;" id="transferir">Transfer</button> 
            <p class="col-12 text-center p-3 h6 bg-secondary text-white mt-3"><span id="transferConfirmation">Your transfer has been successfully executed</span></p>
        </div>
        </form>
    </div>
        <br>

        <div class = "enableEthereumButtonDiv">
            <button id="enableEthereumButton" class="btn btn-warning text-white d-none">Connect Metamask</button>
        </div>
        <p id="accountSelected" class="text-end p-4"></p>
  
        <div id="listRelatives">
            <form method="post" action="">
                <div class="input-container">
                    <button type="submit" name="listRelativeButton" value="listRelativeButton">List Relatives</button>
                </div>
            <form>

            <?php

                if (isset($_POST['listRelativeButton'])) {
                
                    // The user that did the query
                    $relative1 = $_SESSION['user_id'] ; 
                    
                    $sql = "SELECT * from relations WHERE relative1='$relative1'" ;
                    $result = $connection->query($sql) ;
                    $row = mysqli_fetch_array($result);

                    // Create the table
                    echo '
                    <div class = "tableDiv"> 
                    <table border="0" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td style="background-color: #825832;"> <font face="Source Sans Pro">User</font> </td> 
                        <td style="background-color: #825832;"> <font face="Source Sans Pro">Address</font> </td> 
                    </tr>
                    <div>';


                    while($row = $result->fetch_assoc()) {

                        $user = $row['relative2'] ; 

                        $sql = "SELECT * from users WHERE id='$user'" ;
                        $newResult = $connection->query($sql) ;
                        $newRow = mysqli_fetch_array($newResult);

                        echo '<tr> 
                        <td>'.$newRow['username'].'</td> 
                        <td style="font-size: 10px;">'.$newRow['address'].'</td> 
                        </tr>';

                        
    

                    }

                }

            ?>

        </div>

        <br>
    
        <div class = "addRelativeDiv">
            <form method="post" action="">
                <div class="input-container">
                    <input type="text" class="form-control" id="relativeUser" name ="relativeUser" placeholder="Relative User">
                    <button type="submit" class ="relativeButton" name="addRelativeButton" value="addRelativeButton">Add Relative</button>
                    <br> <br>
                </div>
            <form>

            <?php 
            // Error message from search relatives
                if(isset($error1))
                {

                    echo "<p style=\"color:red; margin-bottom:-8%; \">This user doesn't exist</p>" ;

                }

                if (isset($successMessage))
                {

                    echo "<p style=\"color:green; margin-bottom:-8%; \">Family added</p>" ;

                }

                if (isset($error2))
                {
                    
                    echo "<p style=\"color:red; margin-bottom:-8%; \">Your family member is already on the list</p>" ;

                }

            ?>
        </div>



        <form method="post" action="">
            <div class="input-container">
                <button type="submit" class="btn btn-warning text-white d-none" id ="logoutButton" name="logoutButton" value="logoutButton">Logout</button>
            </div>
        <form>
        <script src="./web3.min.js"></script>
        <script type="module" src="./index.js"></script>
    
    </div>

</body>
</html>