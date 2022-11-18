<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 13, 2022
 * Updated: Nov 16, 2022 
 * Purpose: Reviews page that contains food blogs written by registered users.
 *****************************************************************************/

    require_once('header.php');
    
    // query the restaurants that have review posts
    $qryRestaurant = "SELECT * 
                      FROM post 
                      INNER JOIN restaurant
                        JOIN user
                        JOIN foodcategory
                      WHERE post.restaurantid = restaurant.restaurantid                        
                        AND post.active = 1
                        AND post.categoryid = foodcategory.categoryid
                        AND post.userid = user.userid";
                      
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
        <ul>                
            <?php while ($datRestaurant = $stmRestaurant->fetch()): ?>                        
                <li>

                <!--
                    <h5><?= $datRestaurant['restaurant_name'] = isset($datRestaurant['restaurant_name']) ?  $datRestaurant['restaurant_name'] : 'data not found' ?></h5>                                                       
            -->
                    <h5><?= $datRestaurant['restaurant_name'] ?> - <?= $datRestaurant['category_name'] ?></h5>                                                       
                    <h6>Title - <?= $datRestaurant['post_title'] ?></h6>                                                       
                    <p><?= $datRestaurant['post_content'] ?></p>        
                    <h6>
                        <?= $datRestaurant['restaurant_rating'] ?>/10 
                        rating posted by <?= $datRestaurant['first_name'] ?> on                                  
                        <?php $display_date = (($datRestaurant['created_date']) === ($datRestaurant['modified_date'])) ?
                            date('F d, Y h:i A', strtotime($datRestaurant['created_date'])) : 
                            date('F d, Y h:i A', strtotime($datRestaurant['modified_date'])); ?>    
                        <?php if(isset($display_date)) echo $display_date; ?>                             
                    </h6> 
                </li>
                <hr>
            <?php endwhile ?>
        </ul>
    <?php endif ?>
</div>
<?php require_once('footer.php'); ?> 