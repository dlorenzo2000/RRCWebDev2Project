<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 ******************************************/ 

    require('connect.php');
    //require('top-navigation.php');
    //require('library.php');
 
    //session_start();

    if($_POST && !empty($_POST['first-name']) && !empty($_POST['last-name'])
        && !empty($_POST['email']) && !empty($_POST['username']) 
        && !empty($_POST['pwd'])){
        
        $first_name = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $qry = "INSERT INTO User (first_name, last_name, email, username, pwd) 
                VALUES (:first_name, :last_name, :email, :username, :pwd)";
        
        $stm = $db->prepare($qry);

        $stm->bindvalue(':first_name', $first_name, PDO::PARAM_STR);
        $stm->bindvalue(':last_name', $last_name, PDO::PARAM_STR);
        $stm->bindvalue(':email', $email, PDO::PARAM_STR);
        $stm->bindvalue(':username', $username, PDO::PARAM_STR);
        $stm->bindvalue(':pwd', $pwd, PDO::PARAM_STR);
        
        $stm->execute();

        header("Location: login.php");
        die;
    }

    if($_POST && empty($_POST['first-name']) || empty($_POST['last-name'])
        || empty($_POST['email']) || empty($_POST['username']) 
        || empty($_POST['pwd'])){

        //////////////// TO DO
        echo "Please enter all fields.";
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
    <title>Sign up page</title>
</head>
<body>    
    <div class="container">
        <div class="row">
            <form method="post" action="signup.php">    
            <br /> 
                <br /> 
                <br />         
                <h2>Sign up</h2> 

                <br />
                <label for="first-name">First name</label>
                <input type="text" name="first-name">
                <br />
                <br />
                <label for="last-name">Last name</label>
                <input type="text" name="last-name">
                <br />
                <br />
                <label for="email">Email</label>
                <input type="text" name="email">
                <br />
                <br />     
                <label for="username">Username</label>
                <input type="text" name="username">
                <br />
                <br />
                <label for="pwd">Password</label>
                <input type="text" name="pwd">       
                <br />
                <br />
                <button type="submit" class="btn btn-secondary" id="submit">Register</button> 
                <br />
                <br />
                <a href="login.php">Click here to login</a>
            </form>
        </div>
    </div>
</body>
</html>