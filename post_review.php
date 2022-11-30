<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 2, 2022 
 * Purpose: Handles the insert review propcess.
 *****************************************************************************/

    require_once('header.php');

    // checks to see if the user is logged in and redirects to login if not
    if(!($usr_dat = CheckLogin($db))){
        LoginRedirect();
    }
    else{
        // populate the drop down boxes with the following code
        $username = $_SESSION['username'];

        // query the user table
        $qryUser = "SELECT * FROM User WHERE username = $username LIMIT 1";
        
        // query the restaurant table
        $qryRestaurant = "SELECT * FROM Restaurant ORDER BY restaurant_name";

        // query the foodcategory table
        $qryCategory = "SELECT * FROM foodcategory ORDER BY category_name";

        $stmUser = $db->prepare($qryUser);
        $stmRestaurant = $db->prepare($qryRestaurant);
        $stmCategory = $db->prepare($qryCategory);

        $stmUser->execute();
        $stmRestaurant->execute();
        $stmCategory->execute();
         
        if($_POST){
            $post_title = trim(filter_input(INPUT_POST, 'post_title'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $post_content = trim(filter_input(INPUT_POST, 'post_content'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $restaurant_rating 
                = intval(filter_input(INPUT_POST, 'restaurant_rating' 
                    , FILTER_SANITIZE_NUMBER_INT));
            $restaurantid = intval(filter_input(INPUT_POST, 'restaurantid' 
                    , FILTER_SANITIZE_NUMBER_INT));
            $categoryid = intval(filter_input(INPUT_POST, 'categoryid' 
                    , FILTER_SANITIZE_NUMBER_INT));

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
            
            //get the postid of this latest post assign it to the session 
            $qry_postid = "SELECT * from post where postid=(select MAX(postid) FROM post LIMIT 1)";
            $stm_postid = $db->prepare($qry_postid);
            $stm_postid->execute();
            
            $postid = $stm_postid->fetch();
            $_SESSION['postid'] = $postid['postid'];
            
            //header("Location: my_reviews.php");
            //exit;

            //////////////////////////////////////////////////////////////////////////////////////////////////////// 
            function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
                $current_folder = dirname(__FILE__);
                
                $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
                
                return join(DIRECTORY_SEPARATOR, $path_segments);
            }
        
            function file_is_an_image($temporary_path, $new_path) {                
                $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
                $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];
                
                $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
                $actual_mime_type        = mime_content_type($temporary_path);
                
                $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
                $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
                
                return $file_extension_is_valid && $mime_type_is_valid; 
            }
            
            $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
            $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

            // if ($image_upload_detected) {         
              
                $image_filename = $_FILES['image']['name'];      
        
                $temporary_image_path = $_FILES['image']['tmp_name'];
        
                $new_image_path = file_upload_path($image_filename);
        
                if (file_is_an_image($temporary_image_path, $new_image_path)) 
                {
                    $qryImage = "INSERT INTO images (image_name, postid)
                                    VALUES(:image_name, :postid)";

                    $stmImage = $db->prepare($qryImage);
                    $stmImage->bindValue(':image_name', $image_filename, PDO::PARAM_STR);
                    $stmImage->bindValue(':postid', $postid['postid'], PDO::PARAM_INT);
                    $stmImage->execute();

                    move_uploaded_file($temporary_image_path, $new_image_path);           
                }
            // }    
            /////////////////////////////////////////////////////////////////////////////////////////////////////
        } 
    }
?>
image file upload detected <?= $image_upload_detected ?>
<br />
postid is <?= $postid['postid'] ?>
<br />
<?php if($_POST): ?>
<pre><?= print_r($_FILES)?></pre>
<?php endif ?>

<h1>Write a restaurant review</h1>
<div class="row justify-content-center">
    <form method="post" action="post_review.php" enctype="multipart/form-data"> -->
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
        <a href="restaurant.php">Add restaurant</a>
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
        <a href="category.php">Add category</a>
        <br />
        <label for="image">Upload food image:</label> 
        <input type="file" name="image" id="image" /> 
        <br />
        <button type="submit" class="btn btn-secondary" id="submit">Submit</button>
        <button type="button" class="btn btn-secondary" 
            onclick="window.location.replace('my_reviews.php')">Cancel</button>
        <br />
        <br />
    </form>     
</div> 
<?php require_once('footer.php'); ?>