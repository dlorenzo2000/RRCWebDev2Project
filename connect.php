<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 2, 2022
 * Updated: Nov 12, 2022 
 ******************************************/ 

    $db_dsn = 'mysql:host=localhost;dbname=_server;charset=utf8';
    $db_usr = 'root';
    $db_pwd = '';

    // password_hash($password, PASSWORD_DEFAULT), salt is included in this function
 
    try{
        $db = new PDO($db_dsn, $db_usr, $db_pwd);
    }catch(PDOexception $e){
        print("Error" . $e->getMessage());
        die("Failed to connect to the database.");
    }
?> 