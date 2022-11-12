<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 2, 2022
 * Updated: Nov 12, 2022 
 ******************************************/ 

    define('DB_DSN', 'mysql:host=localhost;dbname=_server;charset=utf8');
    define('DB_USER', 'thor');
    define('DB_PASSWORD', 'godofthunder');

    // password_hash($password, PASSWORD_DEFAULT), salt is included in this function
 
    try{
        $db=new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    }catch(PDOexception $e){
        print("Error" . $e->getMessage());
        die();
    }
?> 