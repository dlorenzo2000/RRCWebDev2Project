<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 ******************************************/ 

    require('top-navigation.php');

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
    <div class="container">
        <div class="row">
            <form method="post">    
            <br /> 
                <br /> 
                <br />         
                <h2>Login</h2> 
                <br />      
                <label for="username">Username</label>
                <input type="text" name="username">
                <br />
                <br />
                <label for="password">Password</label>
                <input type="text" name="password">       
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