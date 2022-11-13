<?php
/****************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 * Purpose: This library stores the funcitons
 * to be re-used by the Foodzagram website.
 ******************************************/ 

    require('connect.php');
    require('top-navigation.php');
    require('library.php');

    function CheckLogin($db){
        if(isset($_SESSION['userid'])){
            $id = $_SESSION['userid'];

            $qry = "SELECT * FROM Users WHERE userid = '$id' LIMIT 1";
            
            $stm = $db->prepare($qry);

            $stm->execute();

            if($dat.count > 0)
            {
                $usr_dat = $stm->fetch();
                return $usr_dat;
            }
        }
        else{
            //redirect to login
            header("Location: login.php");
            die;
        }
    }
?>