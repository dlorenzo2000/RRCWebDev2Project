<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 2, 2022
 * Updated: Nov 13, 2022 
 * Purpose: The main landing page for the site.
 *****************************************************************************/
    
    require_once('header.php');
?>
 
<h1>Main</h1>
<div class="row">
    <div class="col-md-4">
        <a href="restaurant.php">Restaurants</a>
    </div>    
        <a href="reviews.php">Reviews</a>
    </div>
    <div class="col-md-4">
        <?php if(($usr_dat = CheckLogin($db))):?>
            <div class="col-md-4">
                <a href="my_comments.php">My Comments</a>
            </div>
        <?php endif ?>
    </div>
</div>  
<?php require_once('footer.php'); ?>
