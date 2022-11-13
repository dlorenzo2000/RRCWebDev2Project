<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 12, 2022
 * Updated: Nov 13, 2022 
 ******************************************/ 

    require('connect.php');
    require('library.php');

    session_start();    

    $usr_dat = CheckLogin($db);
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
    <title>Home</title>
</head>
<body>
    <div class="container">
        <p>            
            Hi <?= $usr_dat['first_name'] ?>. Welcome to the home page!
        </p>
    </div>
</body>
</html>