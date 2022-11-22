<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 18, 2022
 * Updated: Nov 21, 2022 
 * Purpose: Page to view individual restaurant reviews
 ******************************************************************************/
    
    require_once('header.php');

    if(isset($_GET['restaurantid'])){
        $restaurantid = filter_input(INPUT_GET, 'restaurantid'
                , FILTER_SANITIZE_NUMBER_INT);

        $qry = "SELECT * 
                FROM restaurant
                    JOIN foodcategory 
                    JOIN city
                    JOIN province
                WHERE restaurant.restaurantid = $restaurantid 
                    AND restaurant.categoryid = foodcategory.categoryid 
                    AND restaurant.cityid = city.cityid
                    AND restaurant.provinceid = province.provinceid 
                    AND restaurant.active = 1 
                    LIMIT 1";

        $stm = $db->prepare($qry);
        $stm->execute();
        
        $dat = $stm->fetch();

        $qryActive = "SELECT * FROM restaurant
            WHERE restaurantid = $restaurantid AND active = 1 LIMIT 1";
        $stmActive = $db->prepare($qryActive);
        $stmActive->execute();
        $datActive = $stmActive->fetch();

        $qryReviews = " SELECT *  
                        FROM post  
                        JOIN restaurant 
                        LEFT JOIN `user` ON post.userid = user.userid
                        LEFT JOIN foodcategory ON foodcategory.categoryid = post.categoryid 
                        WHERE post.restaurantid = restaurant.restaurantid
                        AND post.restaurantid = $restaurantid";

        $stmReviews = $db->prepare($qryReviews);
        $stmReviews->execute();
    }
?>

<h1>Restaurant Details</h1>
<br />
<h2><?= $dat['restaurant_name']?></h2> 
<h4><?= $dat['restaurant_address']?></h4>
<h4><?= $dat['city_name']?>,
<?= $dat['province_name']?></h4> 
(Food category: <a href="view_category.php?categoryid=<?=$dat['categoryid']?>?category_name=<?=$dat['category_name']?>">
    <?=$dat['category_name']?></a>)
<br />
<br />
<div class="col">
    <button onclick="location.href='post_review.php';" 
        class="btn btn-secondary">Write a review</button>
</div>
<h5>Restaurant reviews</h5>
<ul>
    <?php if($stmReviews->rowCount() > 0): ?>
        <?php while ($datReviews = $stmReviews->fetch()): ?>                        
            <li>
                <h5>
                    <?= $datReviews['restaurant_name'] ?> - 
                    <?= $datReviews['category_name'] ?>
                </h5>                                                       
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