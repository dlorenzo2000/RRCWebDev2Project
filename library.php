<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 12, 2022 
 * Purpose: This library stores the funcitons to be re-used by the Foodzagram 
 *          website.
 *****************************************************************************/

    require('connect.php');
    require('top-navigation.php'); 

    // This function checks to see if a user is logged in succesfuly and
    // creates a SESSION variable if the session is created. 
    // PARAMETER: $db is a connection to the database 
    function CheckLogin($db){
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];

            $qry = "SELECT * FROM User WHERE username = :username LIMIT 1";
        
            $stm = $db->prepare($qry);
    
            $stm->bindvalue('username', $username, PDO::PARAM_STR);
            
            $stm->execute();

            
            
            if($stm->rowCount() > 0){                
                $usr_dat = $stm->fetch();
                return $usr_dat;
            }
        }
        else{
            // redirect to login if user tries to access pages that
            // only registered users are allowed
            header("Location: login.php");
            die;
        }
    }
?>