<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 15, 2022
 * Updated: Nov 16, 2022 
 * Purpose: Handles the update review process.
 *****************************************************************************/

    require_once('header.php');
    
    // checks to see if the user is logged in and redirects to login if not
    if(!($usr_dat = CheckLogin($db))){
        LoginRedirect();
    }
    else{
        // populate the drop down boxes with the following code
        $username = $_SESSION['username'];

        if($usr_dat['admin'] == 1){
            // query the user table for all posts
            $qryUser = "SELECT * FROM User";
        }
        else{
            // query the user table for only one user
            $qryUser = "SELECT * FROM User WHERE username = $username LIMIT 1";    
        } 
        
        // query the restaurant table
        $qryRestaurant = "SELECT * FROM Restaurant ORDER BY restaurant_name ASC";

        // query the foodcategory table
        $qryCategory = "SELECT * FROM foodcategory ORDER BY category_name ASC";

        $stmUser = $db->prepare($qryUser);
        $stmRestaurant = $db->prepare($qryRestaurant);
        $stmCategory = $db->prepare($qryCategory);

        $stmUser->execute();
        $stmRestaurant->execute();
        $stmCategory->execute();
 
        // get the postid from the selected review to output to the page on load
        if(isset($_GET['postid'])){
            $postid = filter_input(INPUT_GET, 'postid'
                , FILTER_SANITIZE_NUMBER_INT);    
                     

            $qry = "SELECT * 
                    FROM post 
                        JOIN restaurant
                        JOIN foodcategory                  
                    WHERE post.postid = :postid 
                    AND post.restaurantid = restaurant.restaurantid
                    AND post.categoryid = foodcategory.categoryid LIMIT 1";

            $stm = $db->prepare($qry);           
            $stm->bindValue(':postid', $postid, PDO::PARAM_INT);
            $stm->execute();

            $dat = $stm->fetch();

            $qryEditCategory = "SELECT * FROM foodcategory JOIN post 
                WHERE post.categoryid = foodcategory.categoryid 
                AND post.postid = $postid LIMIT 1";

            $stmEditCategory = $db->prepare($qryEditCategory);
            $stmEditCategory->execute();
            $datEditCategory = $stmEditCategory->fetch();            
        }

        if($_POST && ($_POST['delete'])){ 
            $postid = filter_input(INPUT_POST, 'postid'
                , FILTER_SANITIZE_NUMBER_INT);
            $qry="UPDATE post 
                  SET active = 0 
                  WHERE postid = $postid";
                    
            $stm=$db->prepare($qry);        
            $stm->execute();

            header("Location: my_reviews.php");
            exit;
        }

        if($_POST && ($_POST['activate'])){ 
            $postid = filter_input(INPUT_POST, 'postid'
                , FILTER_SANITIZE_NUMBER_INT);
            $qry="UPDATE post 
                  SET active = 1 
                  WHERE postid = $postid";
                    
            $stm=$db->prepare($qry);        
            $stm->execute();

            header("Location: my_reviews.php");
            exit;
        }

        if($_POST){
            $postid = filter_input(INPUT_POST, 'postid'
                , FILTER_SANITIZE_NUMBER_INT);
            $post_title = trim(filter_input(INPUT_POST, 'post_title'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $post_content = trim(filter_input(INPUT_POST, 'post_content'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $restaurant_rating 
                = (int)(filter_input(INPUT_POST, 'restaurant_rating'
                    , FILTER_SANITIZE_NUMBER_INT));
            $restaurantid 
                = (int)(filter_input(INPUT_POST, 'restaurantid'
                    , FILTER_SANITIZE_NUMBER_INT));
            $categoryid 
                = (int)(filter_input(INPUT_POST, 'categoryid'
                    , FILTER_SANITIZE_NUMBER_INT));
     
            $qryPost = "UPDATE post 
                        SET post_title=:post_title, post_content=:post_content
                            , restaurant_rating=:restaurant_rating
                            , restaurantid=:restaurantid, categoryid=:categoryid
                        WHERE postid=:postid";

            $stmPost = $db->prepare($qryPost);

            $stmPost->bindvalue(':postid', $postid, PDO::PARAM_INT); 
            $stmPost->bindValue(':post_title', $post_title, PDO::PARAM_STR);
            $stmPost->bindValue(':post_content', $post_content, PDO::PARAM_STR);
            $stmPost->bindvalue(':restaurant_rating', $restaurant_rating, PDO::PARAM_INT);
            $stmPost->bindvalue(':restaurantid', $restaurantid, PDO::PARAM_INT);
            $stmPost->bindvalue(':categoryid', $categoryid, PDO::PARAM_INT);
            
            $stmPost->execute();
            header("Location: my_reviews.php");
            exit;
        }        
    }
?> 

<div class="row justify-content-center">
    <h1>EDIT review</h1>
    <form method="post" action="review_edit.php">
        <input type="hidden" name="postid" value="<?=$dat['postid']?>">
        <label for="post_title">Title</label>        
        <input type="text" name="post_title" value="<?=$dat['post_title']?>">
        <br />
        <textarea name="post_content" rows="10" cols="94"><?=$dat['post_content']?>
        </textarea>
        <br />
        <label for="restaurant_rating">Rating </label>
        <select name="restaurant_rating">
            <option hidden disabled selected value> 
                -- select an option -- 
            </option>
            <option selected value="<?= $dat['restaurant_rating']?>">
                <?= $dat['restaurant_rating']?>
            </option>
            <?php for($i=1; $i<=10; $i++): ?>
                <option value = "<?=$i ?>">
                    <?=$i ?>
                </option>
            <?php endfor ?>
        </select> 
        <label for="restaurantid">Restaurant</label>
        <select name="restaurantid">
            <option hidden disabled selected value> 
                -- select an option -- 
            </option>             
            <?php if($stmRestaurant->rowCount() > 0): ?>                
                <option selected value="<?= $dat['restaurantid'] ?>">
                    <?= $dat['restaurant_name'] ?>
                </option>                             
                <?php while($dat = $stmRestaurant->fetch()): ?>
                    <option value="<?= $dat['restaurantid'] ?>">
                        <?= $dat['restaurant_name'] ?> 
                    </option>
                <?php endwhile ?>
            <?php endif ?>
        </select> 
        <a href="restaurant.php">Add restaurant</a>
        <br />
        <label for="categoryid">Category </label>    
        <select name="categoryid">
            <option hidden disabled selected value>
                    -- select an option -- 
            </option>
            <?php if($stmCategory->rowCount() > 0): ?>
                <option selected value="<?= $datEditCategory['categoryid'] ?>">
                    <?= $datEditCategory['category_name'] ?> 
                </option>
                <?php while($datCategory = $stmCategory->fetch()): ?>
                    <option value="<?= $datCategory['categoryid'] ?>">
                        <?=$datCategory['category_name'] ?>
                    </option>                    
                <?php endwhile ?>
            <?php endif ?>            
        </select> 
        <a href="category.php">Add category</a>
        <br />
        <button type="submit" class="btn btn-secondary" id="submit">Save</button>  
        <button class="btn btn-secondary"   
            onclick="window.location.replace('my_reviews.php')">Cancel</button>

        <?php if($dat['active']): ?>
            <button type="submit" class="btn btn-secondary" value="delete" name="delete"        
                onclick="return confirm('Are you sure?')">De-activate</button>
        <?php else: ?>
            <button type="submit" class="btn btn-secondary" value="delete" name="activate"        
                onclick="return confirm('Are you sure?')">Re-activate</button>
        <?php endif ?>
        <br />
        <br />  
    </form>  
</div>    