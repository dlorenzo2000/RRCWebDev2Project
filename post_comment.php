<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 20, 2022
 * Updated: Nov 20, 2022 
 * Purpose: Page for viewing whole review and comments posted by others
 ******************************************************************************/

    require_once('header.php');   
    
    // get the postid from the selected review to output to the page on load
    if(isset($_GET['postid'])){
        $postid = filter_input(INPUT_GET, 'postid'
            , FILTER_SANITIZE_NUMBER_INT);    
            
        $qry = "SELECT * 
                FROM post 
                    JOIN restaurant
                    JOIN foodcategory  
                    JOIN user                
                WHERE post.postid = :postid 
                    AND post.userid = user.userid
                    AND post.restaurantid = restaurant.restaurantid";
     
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if($_POST && empty($_POST['post-comment'])){
                $post_comment_error = "* Comment form cannot be blank.";
            }
        }
    } 
  
?> 

<div class="row justify-content-center">
    <h1>Post comment</h1>
    <form action="post_comment.php">
        <label for="post-comment"></label>
        <textarea name="post-comment" rows="10" cols="94"></textarea>
        <span><?php if(isset($post_comment_error)) echo $post_comment_error; ?></span> 
        <br>
        <button type="submit" class="btn btn-secondary" id="submit">Submit</button>
        <button type="button" class="btn btn-secondary" 
            onclick="window.location.replace('my_reviews.php')">Cancel</button>
    </form> 
<?php require_once('footer.php') ?>