<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 15, 2022 
 * Purpose: Footer found at bottom of every page.
 *****************************************************************************/

?>


<div class="row bottom-nav-links align-item-center">        
    <div class="col-sm-8">  
        <nav>      
            <ul>
                <li class="bottom-nav-li">
                    <?php if(isset($_SESSION['username'])) 
                        echo "Hi " . strtoupper($_SESSION['username']) . "!";?>
                </li>          
                <li class="bottom-nav-li"><a href="index.php">Home</a></li>          
                <li class="bottom-nav-li"><a href="about.php">About</a></li>                   
                <li class="bottom-nav-li"><a href="contact.php">Contact</a></li>   
      
            </ul>
        </nav>   
    </div>
</div>    

