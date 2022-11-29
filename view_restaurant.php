<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 18, 2022
 * Updated: Nov 28, 2022 
 * Purpose: Page to view individual restaurant reviews
 ******************************************************************************/
    
    require_once('header.php');

    if(isset($_GET['restaurantid'])){
        $restaurantid = filter_input(INPUT_GET, 'restaurantid'
                , FILTER_SANITIZE_NUMBER_INT);

$qryActive = "SELECT * FROM restaurant
            WHERE restaurantid = $restaurantid AND active = 1 LIMIT 1";
        $stmActive = $db->prepare($qryActive);
        $stmActive->execute();
        $datActive = $stmActive->fetch(); 

        $qryReviews = "SELECT * 
                        FROM post 
                            left join restaurant on post.restaurantid = restaurant.restaurantid 
                            left join foodcategory on foodcategory.categoryid = post.categoryid
                            left join city on city.cityid = restaurant.cityid
                            left join province on province.provinceid = restaurant.provinceid
                            left join user on post.userid = user.userid
                        where post.restaurantid = $restaurantid";
        
        $stmReviews = $db->prepare($qryReviews);
        $stmRestaurant = $db->prepare($qryReviews);

        $stmRestaurant->execute();
        $stmReviews->execute();
    }
?> 

<h1>Restaurant Details</h1>
<br />   
<ul>
    <?php if($stmReviews->rowCount() > 0): ?>
        <?php $datRestaurant = $stmRestaurant->fetch() ?> 
        <h2 class="heading_inline"><?= $datRestaurant['restaurant_name'] ?></h2>
        [<?= $datRestaurant['category_name'] ?> food]
        <br />  
        <?= $datRestaurant['restaurant_address'] ?>
        <br />
        <?= $datRestaurant['city_name'] ?>, <?= $datRestaurant['province_name'] ?> 
        <br />
        <br />
        <div class="col">
            <button onclick="location.href='post_review.php';" 
                class="btn btn-secondary">Write a review</button>
        </div>  
        <br />
        <h5>Restaurant reviews</h5> 
        <hr>
        <?php while ($datReviews = $stmReviews->fetch()): ?>                        
            <li>                                           
                <?php if(isset($usr_dat) && ($usr_dat['admin'] == 1)): ?> 
                    <?php if($datReviews['active'] == 0): ?>  
                        Inactive post                    
                    <?php endif ?>  
                    <?php if($datReviews['active'] == 1): ?>
                        Active post                      
                    <?php endif ?>        
                    <a href="review_edit.php?postid=<?= $datReviews['postid']?>">[edit]</a>  
                <?php endif ?>
                <h6>Title - 
                    <a href="review_read.php?postid=<?= $datReviews['postid']?>">
                        <?= $datReviews['post_title'] ?>
                    </a>
                </h6> 
                <p><?= $datReviews['post_content'] ?></p>        
                <h6>
                    <?= $datReviews['restaurant_rating'] ?>/10 
                    rating posted by <?= $datReviews['first_name'] ?> on                                  
                    <?php $display_date 
                        = (($datReviews['created_date']) === ($datReviews['modified_date'])) ?
                        date('F d, Y h:i A', strtotime($datReviews['created_date'])) : 
                        date('F d, Y h:i A', strtotime($datReviews['modified_date'])); ?>    
                    <?php if(isset($display_date)) echo $display_date; ?>                         
                    <a href="review_read.php?postid=<?= $datReviews['postid']?>">READ COMMENTS</a>                           
                </h6>                     
            </li> 
            <hr>
        <?php endwhile ?>    
    <?php else: ?>
        No reviews for this place yet.
    <?php endif ?>           
</ul>
<?php require_once('footer.php');