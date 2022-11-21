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
                     
        if($_POST && empty(trim($_POST['comment']))){
                $post_comment_error = "* Comment field cannot be blank.";
        }
        else{
            $comment = trim(filter_input(INPUT_POST, 'comment'
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            // if the user is logged in grab their userid
            if($usr_dat = CheckLogin($db)){
                $userid = $usr_dat['userid'];
            }        
            else
                $userid = 0;
            
            $qryComment = "INSERT INTO comment (comment, userid, postid)
                VALUES (:comment, :userid, :postid)";

            $stmComment = $db->prepare($qryComment);
            $stmComment->bindValue(':comment', $comment);
            $stmComment->bindValue(':userid', $userid);
            $stmComment->bindValue(':userid', $postid);
            $stmComment->execute();

            header('Location: review_read.php?postid=');
            exit;         
        }
    }  
?> 

<div class="row justify-content-center">
    <h1>Post comment</h1>  
    <form action="post_comment.php">
        <input type="hidden" name="postid" value="<?=$dat['restaurantid']?>"> 
        <label for="post-comment"></label>
        <textarea name="comment" rows="10" cols="94"></textarea>
        <span><?php if(isset($post_comment_error)) echo $post_comment_error; ?></span> 
        <br>
        <button type="submit" class="btn btn-secondary" id="submit">Submit</button>
        <button type="button" class="btn btn-secondary" 
            onclick="window.location.replace('review_read.php')">Cancel</button>
    </form> 
<?php require_once('footer.php') ?>