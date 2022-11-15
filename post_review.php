<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 2, 2022
 * Updated: Nov 14, 2022 
 * Purpose: The main landing page for the site.
 *****************************************************************************/

    session_start();
    require('connect.php');
    require('top-navigation.php');    
    require('library.php');  

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

        if($_POST){

            $post_title = filter_input(INPUT_POST, 'post_title'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $post_content = filter_input(INPUT_POST, 'post_content'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $restaurant_rating 
                = (int)(filter_input(INPUT_POST, 'restaurant_rating' , FILTER_VALIDATE_INT));
            $restaurantid = (int)(filter_input(INPUT_POST, 'restaurantid' , FILTER_VALIDATE_INT));
            $categoryid = (int)(filter_input(INPUT_POST, 'categoryid' , FILTER_VALIDATE_INT));

            $userid = intval($usr_dat['userid']);
     
            $qry = "INSERT INTO post (post_title, post_content, userid, restaurant_rating, 
                        restaurantid, categoryid)     
                    VALUES(:post_title, :post_content, :userid, :restaurant_rating, 
                        :restaurantid, :categoryid)";

            $stm = $db->prepare($qry);

            $stm->bindValue(':post_title', $post_title, PDO::PARAM_STR);
            $stm->bindValue(':post_content', $post_content, PDO::PARAM_STR);
            $stm->bindvalue(':restaurant_rating', $restaurant_rating, PDO::PARAM_INT);
            $stm->bindvalue(':restaurantid', $restaurantid, PDO::PARAM_INT);
            $stm->bindvalue(':categoryid', $categoryid, PDO::PARAM_INT);
            $stm->bindValue(':userid', $userid, PDO::PARAM_INT);

            $stm->execute();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" 
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css"> 
    <title>Write a review</title>
</head>
<body>
    <hr>    
    <div class="container">
        <div class="row justify-content-center">
            Hello <?= $usr_dat['first_name'] ?> userid#<?= $usr_dat['userid'] ?>
            <h4>Write a restaurant review</h4>
            <form method="post" action="post_review.php">
                <label for="post_title">Title</label>
                <input type="text" name="post_title"> 
                <br />
                <textarea name="post_content" rows="10" cols="94"></textarea>
                <br />
                <label for="restaurant_rating">Rating</label>
                <select name="restaurant_rating">
                    <option hidden disabled selected value> 
                        -- select an option -- 
                    </option>
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
                        <?php while($dat = $stmRestaurant->fetch()): ?>
                            <option value="<?= $dat['restaurantid'] ?>">
                                <?= $dat['restaurant_name'] ?> 
                            </option>
                        <?php endwhile ?>
                    <?php endif ?>
                </select>
                <a href="add_restaurant.php">Add restaurant</a>
                <br />
                <label for="categoryid">Category</label>
                <select name="categoryid">
                    <option hidden disabled selected value>
                         -- select an option -- 
                    </option>
                    <?php if($stmCategory->rowCount() > 0): ?>
                        <?php while($dat = $stmCategory->fetch()): ?>
                            <option value="<?= $dat['categoryid'] ?>">
                                <?= $dat['category_name'] ?> 
                            </option>
                        <?php endwhile ?>
                    <?php endif ?>
                </select>
                <a href="add_category.php">Add category</a>
                <br />
                <button type="submit" class="btn btn-secondary" id="submit">Submit</button>
                <br />
                <br />
            </form> 
        </div>
    </div>        
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" 
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" 
        crossorigin="anonymous"></script>  
</body>
</html>