<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 13, 2022
 * Updated: Nov 20, 2022 
 * Purpose: Reviews page that contains food blogs written by registered users.
 *          This can be viewed by all visitors to this page.
 *****************************************************************************/

    require_once('header.php');

    if($usr_dat = CheckLogin($db)){
        if($usr_dat['admin'] == 1){
            // if all posts will be visible when this WHERE
            // claus is exercised for admins
            $and_active = "";   
        }
        else{            
            $and_active = "AND post.active = 1";
        }           
    }
    else{
        $and_active = "AND post.active = 1";
    }

    $sortCriteria = "";

    if($_POST){
        if($_POST['sort-reviews'] == "newest-reviews")
            $sortCriteria = "ORDER BY post.modified_date DESC";
        elseif($_POST['sort-reviews'] == "restaurant-name")
            $sortCriteria = "ORDER BY restaurant.restaurant_name";
        else{
            $sortCriteria = "ORDER BY foodcategory.category_name";
        }   

    } 

    $qryRestaurant = "SELECT * 
                    FROM post 
                        INNER JOIN restaurant
                        JOIN user
                        JOIN foodcategory
                    WHERE post.restaurantid = restaurant.restaurantid   
                        AND post.categoryid = foodcategory.categoryid
                        AND post.userid = user.userid
                        $and_active
                        $sortCriteria";

    $stmRestaurant = $db->prepare($qryRestaurant);

    $stmRestaurant->execute();
?>
  
<div class="row">
    <div class="col">
        <button onclick="location.href='post_review.php';" 
            class="btn btn-secondary">Write a review</button>
    </div>
</div>     
<div class="row col-md-6">      
    <?php if($stmRestaurant->rowCount() > 0): ?>
        <form action="reviews.php" method="post">            
            <label for="sort-reviews">Sort ALL reviews by:</label>
            <select name="sort-reviews">    
                <option hidden disabled selected value>
                        -- select an option -- 
                </option>             
                <option value="restaurant-name">Restaurant Name</option>                 
                <option value="food-category">Food Category</option>
                <option value="newest-reviews">Newest reviews</option> 
            </select>
            <button type="submit" class="btn btn-secondary" id="submit">Sort</button>
            <br />

            <!-- <label for="view-by">Show reviews by food category</label>
            <select name ="view-by">
                <option hidden disabled selected value>
                        -- select an option -- 
                </option>  
                <option value="view-category">Food Category</option>
                <option value="view-restaurant">Restaurant</option>
            </select>        
            <button type="submit" class="btn btn-secondary" >View</button> -->
        
       
        </form> 
        <ul>                
            <?php while ($datRestaurant = $stmRestaurant->fetch()): ?>                        
                <li>
                    <h5><?= $datRestaurant['restaurant_name'] ?> - <?= $datRestaurant['category_name'] ?></h5>                                                       
                    <?php if(isset($usr_dat) && ($usr_dat['admin'] == 1)): ?>
                        
                        <?php if($datRestaurant['active'] == 0): ?>
                            [Inactive post]                      
                        <?php endif ?> 

                        <?php if($datRestaurant['active'] == 1): ?>
                            [Active post]                      
                        <?php endif ?>
                                                   
                        <a href="my_review_edit.php?postid=<?= $datRestaurant['postid']?>">EDIT</a>  
                    <?php endif ?>
                    <h6>Title - <a href="review_read.php?postid=<?= $datRestaurant['postid']?>">
                        <?= $datRestaurant['post_title'] ?></a></h6>                                                       
                    <?php if(strlen($datRestaurant['post_content']) > 100): ?>

                    <?php endif ?>
                    <p><?= $datRestaurant['post_content'] ?></p>        
                    <h6>
                        <?= $datRestaurant['restaurant_rating'] ?>/10 
                        rating posted by <?= $datRestaurant['first_name'] ?> on                                  
                        <?php $display_date = (($datRestaurant['created_date']) === ($datRestaurant['modified_date'])) ?
                            date('F d, Y h:i A', strtotime($datRestaurant['created_date'])) : 
                            date('F d, Y h:i A', strtotime($datRestaurant['modified_date'])); ?>    
                        <?php if(isset($display_date)) echo $display_date; ?>                         
                        <a href="review_read.php?postid=<?= $datRestaurant['postid']?>">READ COMMENTS</a>                           
                    </h6>                     
                </li> 
                <hr>
            <?php endwhile ?>
        </ul>
    <?php endif ?>
</div>
<?php require_once('footer.php'); ?> 