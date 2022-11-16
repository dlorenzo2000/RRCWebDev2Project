<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 16, 2022
 * Updated: Nov 16, 2022 
 * Purpose: Footer navigation at bottom of every page.
 *****************************************************************************/

    if(isset($_SESSION['username'])){
        $logout_link = "Logout";
        $my_reviews_link = "My Reviews";
    }
 ?>

<footer>
    <nav>
        <ul>
            <li><a href="home.php">About</a></li>
            <li><a href="home.php">Contact</a></li> 
        </ul>
    </Nav>
</footer> 
