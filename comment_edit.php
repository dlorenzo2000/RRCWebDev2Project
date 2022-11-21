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
                    WHERE post.postid = :postid LIMIT 1";
    
            $stm = $db->prepare($qry);           
            $stm->bindValue(':postid', $postid, PDO::PARAM_INT);
            $stm->execute();
    
            $dat = $stm->fetch();     
            
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                if($_POST && empty(trim($_POST['comment']))){
                    $comment_error = "* Comment form cannot be blank.";
                    
                }
                else{ 
                    if($usr_dat = CheckLogin($db)){
                        $userid = $usr_dat['userid'];
                    }        
                    else{
                        $userid = 0;
                    }
                                        
                    $comment = trim(filter_input(INPUT_POST, 'comment'
                        , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $postid = filter_input(INPUT_POST, 'postid'
                        , FILTER_SANITIZE_FULL_SPECIAL_CHARS);                    
                
                    $qryComment = "INSERT INTO comment (comment, userid, postid)
                        VALUES (:comment, :userid, :postid)";
        
                    $stmComment = $db->prepare($qryComment);
                    $stmComment->bindValue(':comment', $comment);
                    $stmComment->bindValue(':userid', $userid);
                    $stmComment->bindValue(':postid', $postid);
                    $stmComment->execute();  

                    //header("Location: review_read.php?postid=$postid");  
                    exit;                  
                }                             
            }
         }   
?> 

<form action="review_read.php?postid=<? $dat['postid'] ?>" method="post">
    <input type="hidden" name="postid" value="<?=$dat['postid']?>"> 
    <label for="comment">
        Comment
    </label>
    <br />
    <textarea rows="10em" cols="80em" name="comment"></textarea>
    <span>
        <?php if(isset($comment_error)) echo $comment_error; ?>
    </span> 
    <br />
    <br />
    <button type="submit" class="btn btn-secondary" id="submit">Add</button>        
    <button type="button" class="btn btn-secondary" 
        onclick="window.location.reload()">Clear</button>
    <br />
    <br />
    <br />  
</form> 
<?php require_once('footer.php') ?>