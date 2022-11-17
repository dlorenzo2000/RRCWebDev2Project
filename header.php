<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 15, 2022 
 * Purpose: Header found on every page.
 *****************************************************************************/

    if(isset($_SESSION['username'])){
        $logout_link = "Logout";
        $my_reviews_link = "My Reviews";
    }   
?>
   
<header>
    <div class="row top-nav-links align-item-center">
        <div class="col-sm-4">
            <a href="index.php">
                <img src="images/foodzagram-logo-sm.png" class="top-logo"/>
            </a>
        </div>    
        <div class="col-sm-8">  
            <nav>      
                <ul>
                    <li class="top-nav-li">
                        <?php if(isset($_SESSION['username'])) 
                            echo "Hi " . strtoupper($_SESSION['username']);?>
                    </li>          
                    <li class="top-nav-li"><a href="index.php">Home</a></li>          
                    <li class="top-nav-li"><a href="my_reviews.php">
                        <?php if(isset($logout_link)) echo $my_reviews_link; ?> </a>
                    </li>                    
                    <li class="top-nav-li"><a href="logout.php">
                        <?php if(isset($logout_link)) echo $logout_link; ?> </a>
                    </li>
                    <li class="top-nav-li">
                        <form action="#" class="top-nav-search">
                            <input type="text">
                        </form>
                        <a href="search.php">
                            <button class="btn btn-secondary">Search</button>
                        </a>
                    </li> 
                    <button onclick="location.href='login.php';" 
                        class="btn btn-secondary" >Login/Sign Up
                    </button>                      
                </ul>
            </nav>   
        </div>
    </div>            
</header>       