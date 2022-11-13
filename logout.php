<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 ******************************************/ 

    session_start();

    if(isset($_SESSION['username'])){
        unset($_SESSION['username']);
    }

    header("Location: index.php");
    die;
?>