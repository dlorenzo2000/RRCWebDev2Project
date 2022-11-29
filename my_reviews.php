<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 15, 2022
 * Updated: Nov 24, 2022 
 * Purpose: Reviews page displays the reviews posted by a logged in user.
 *****************************************************************************/

    require_once('header.php');

    // if the user visits this page and isn't logged in, then redirect
    if(!($usr_dat = CheckLogin($db))){
        LoginRedirect();
    }
    
    $userid = $_SESSION['userid']; 

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
   
    $qryPost = "SELECT * 
                FROM post       
                JOIN foodcategory                
                INNER JOIN restaurant   
                WHERE post.restaurantid = restaurant.restaurantid 
                    AND foodcategory.categoryid = post.categoryid
                    AND post.active = 1 
                    AND post.userid = $userid $sortCriteria";               
                    
    $stmPost = $db->prepare($qryPost);
    
    $stmPost->execute(); 
?>

<h1>My reviews</h1>
  
<div class="row">
    <div class="col">
        <button onclick="location.href='post_review.php';" 
            class="btn btn-secondary">New review</button>
    </div>
</div>     
<div class="row">            
    <?php if($stmPost->rowCount() > 0): ?> 
        <form action="my_reviews.php" method="post">            
            <label for="sort-reviews">Sort reviews by:</label>
            <select name="sort-reviews">    
                <option hidden disabled selected value>
                        -- select an option -- 
                </option>             
                <option value="restaurant-name">Restaurant Name</option>                 
                <option value="food-category">Food Category</option>
                <option value="newest-reviews">Newest reviews</option> 
            </select>
            <button type="submit" class="btn btn-secondary" id="submit">GO</button>
        </form> 
        <ul>                
            <?php while($datPost = $stmPost->fetch()): ?>   
                <li>
                    <?php if(strtotime($datPost['modified_date']) < strtotime($datPost['created_date']))
                        $modified = "Updated on " . date('F d, Y h:i A', strtotime($datPost['modified_date']));
                    ?>
                    <h5><?= $datPost['restaurant_name'] ?> - <?= $datPost['category_name']?></h5>  
                    <a href="review_edit.php?postid=<?= $datPost['postid']?>">EDIT</a>                          
                    <h6><?= $datPost['post_title'] ?> - RATING <?= $datPost['restaurant_rating'] ?>/10</h6>                    
                        Posted on <?= date('F d, Y h:i A', strtotime($datPost['modified_date'])) ?>
                        <br />  
                        <span><?php if(isset($modified)) echo $modified; ?></span>       
                    <p><?= $datPost['post_content'] ?></p>   
                    <a href="review_read.php?postid=<?= $datPost['postid']?>">READ COMMENTS</a> 
                </li>
                <hr>
            <?php endwhile ?>
        </ul>
    <?php else: ?>
        <p>
            You have no reviews yet. Click on New review.
        </p>
    <?php endif ?>
</div> 
<?php require_once('footer.php'); ?> 