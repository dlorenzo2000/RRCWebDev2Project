<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 15, 2022 
 * Purpose: Manage the login to the website. 
 *****************************************************************************/
 
    session_start();
    require('connect.php');
    require('top-navigation.php');

    if($_POST && !empty($_POST['username']) && !empty($_POST['pwd'])){
         
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $qry = "SELECT * FROM User WHERE username = :username LIMIT 1";
        
        $stm = $db->prepare($qry);

        $stm->bindvalue('username', $username, PDO::PARAM_STR);
        
        $stm->execute();

        if($stm->rowCount() > 0 ){            
            $dat = $stm->fetch();
            if($dat['pwd'] === $pwd){ 
                $_SESSION['username'] = $dat['username'];
                $_SESSION['userid'] = $dat['userid'];
                header("Location: home.php");
                die;                
            }
            else{
                echo "Invalid password. Re-enter your password.";
            }
        }  
        
        ///////////////if($_SERVER['REQUEST_METHOD'] === "POST"){
            if($_POST && empty($_POST['username'])){
                $username_error = "* Please your username.";
            }
            if($_POST && empty($_POST['pwd'])){
                $password_error1 = "* Please your password.";
            }      
       ///////////// }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" 
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css"> 
    <title>Login page</title>
</head>
<body>    
    <hr>
    <div class="container">
        <div class="row">
            <form method="post" action="login.php">    
                <br /> 
                <br /> 
                <br />         
                <h2>Login</h2> 
                <br />      
                <label for="username">Username</label>
                <input type="text" name="username">

                <span><?php if(isset($username_error)) echo $username_error; ?></span>

                <br />
                <br />
                <label for="pwd">Password</label>
                <input type="password" name="pwd">       
                <br />
                <br />
                <button type="submit" class="btn btn-secondary">Login</button> 
                <br />
                <br />
                <a href="signup.php">Click here to sign up</a>
            </form>
        </div>
    </div>
</body>
</html>