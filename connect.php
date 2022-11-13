<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 * Purpose: Handles the connection to the database.
 *****************************************************************************/

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