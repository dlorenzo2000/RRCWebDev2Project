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
        header("Location: login.php");
    }
    else{
        // populate the drop down boxes with the following code
        $username = $_SESSION['username'];

        // query the user table
        $qryUser = "SELECT * FROM User WHERE username = $username LIMIT 1";
        
        // query the restaurant table
        $qryRestaurant = "SELECT * FROM Restaurant";

        // query the foodcategory table
        $qryCategory = "SELECT * FROM foodcategory";

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

            $qry = "SELECT * FROM post JOIN restaurant                  
                WHERE post.postid = :postid 
                AND post.restaurantid = restaurant.restaurantid LIMIT 1";
            
            $stm = $db->prepare($qry);           
            $stm->bindValue(':postid', $postid, PDO::PARAM_INT);
            $stm->execute();

            $dat = $stm->fetch();

            $categoryid = $dat['categoryid'];

            $qryGetCateogry = "SELECT * FROM foodcategory
                 WHERE categoryid = :categoryid LIMIT 1";            

            $stmGetCategory = $db->prepare($qryGetCateogry);
            $stmGetCategory->bindValue(':categoryid', $categoryid , PDO::PARAM_INT);
            $stmGetCategory->execute();

            $datGetCategory = $stmGetCategory->fetch();                        
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
     
            $qry = "UPDATE post 
                    SET post_title=:post_title, post_content=:post_content
                        , restaurant_rating=:restaurant_rating
                        , restaurantid=:restaurantid, categoryid=:categoryid
                    WHERE postid=:postid";

            $stm = $db->prepare($qry);

            $stm->bindvalue(':postid', $postid, PDO::PARAM_INT); 
            $stm->bindValue(':post_title', $post_title, PDO::PARAM_STR);
            $stm->bindValue(':post_content', $post_content, PDO::PARAM_STR);
            $stm->bindvalue(':restaurant_rating', $restaurant_rating, PDO::PARAM_INT);
            $stm->bindvalue(':restaurantid', $restaurantid, PDO::PARAM_INT);
            $stm->bindvalue(':categoryid', $categoryid, PDO::PARAM_INT);
            
            $stm->execute();
            header("Location: my_reviews.php");
            exit;
        }

        if($_POST && $postid['delete']){ 
            $postid=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $qry="UPDATE post 
                  SET active=:active 
                  WHERE postid=:postid";
                    
            $stm=$db->prepare($qry);
            $stm->bindValue(':active', 0, PDO::PARAM_INT);
            $stm->bindValue(':postid', $postid, PDO::PARAM_INT);
            $stm->execute();

            header("Location: myreviews.php");
            exit;
        }
    }
?> 

<div class="row justify-content-center">
    <h1>EDIT review</h1>
    <form method="post" action="update_review.php">
        <input type="hidden" name="postid" value="<?=$dat['postid']?>">

        <label for="post_title">Title</label>
        
        <input type="text" name="post_title" value="<?=$dat['post_title']?>">
        <br />
        <textarea name="post_content" rows="10" cols="94"><?=$dat['post_content']?>
        </textarea>
        <br />
        <label for="restaurant_rating">Rating</label>
        <select name="restaurant_rating">
            <option hidden disabled selected value> 
                -- select an option -- 
            </option>
            <option selected><?= $dat['restaurant_rating']?></option>
            <option value = "1">1</option>
            <option value = "2">2</option>
            <option value = "3">3</option>
            <option value = "4">4</option>
            <option value = "5">5</option>
            <option value = "6">6</option>
            <option value = "7">7</option>
            <option value = "8">8</option>
            <option value = "9">9</option>
            <option value = "10">10</option>
        </select> 
        <label for="restaurantid">Restaurant</label>
        <select name="restaurantid">
            <option hidden disabled selected value> 
                -- select an option -- 
            </option>             
            <?php if($stmRestaurant->rowCount() > 0): ?>                
                <option selected value="<?= $dat['restaurantid'] ?>"><?= $dat['restaurant_name'] ?></option>                             
                <?php while($dat = $stmRestaurant->fetch()): ?>
                    <option value="<?= $dat['restaurantid'] ?>"> <?= $dat['restaurant_name'] ?> </option>
                <?php endwhile ?>
            <?php endif ?>
        </select> 
        <br />
        <label for="categoryid">Category </label>     

        <select name="categoryid">
            <option hidden disabled selected value>
                    -- select an option -- 
            </option>
            <?php if($stmCategory->rowCount() > 0): ?>
                <option selected value="<?= $dat['categoryid'] ?>"><?=  $datGetCategory['category_name'] ?></option>
                <?php while($dat = $stmCategory->fetch()): ?>
                    <option value="<?= $dat['categoryid'] ?>"><?=$dat['category_name'] ?></option>
                <?php endwhile ?>
            <?php endif ?>
        </select> 
        <br />
        <button type="submit" class="btn btn-secondary" id="submit">Save</button>        
        <button class="btn btn-secondary" onclick="history.back()">Cancel</button>
        <button type="submit" class="btn btn-secondary" value="Delete" 
            onclick="return confirm('Are you sure?')">Delete</button>
        <br />
        <br />
    </form> 
</div>   
<?php require_once('footer.php'); ?>