<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 18, 2022
 * Updated: Nov 19, 2022 
 * Purpose: Logged in users can update food categories.
 ******************************************************************************/

    require_once('header.php');
     
    // if the user visits this page and isn't logged in, then redirect
    if(!($usr_dat = CheckLogin($db))){
        LoginRedirect();
    }
    else{
        if(isset($_GET['commentid'])){
            $commentid = filter_input(INPUT_GET, 'commentid'
                , FILTER_SANITIZE_NUMBER_INT);            

            $qry = "SELECT * 
                    FROM comment                
                    WHERE commentid = :commentid LIMIT 1";

            $stm = $db->prepare($qry);           
            $stm->bindValue(':commentid', $commentid, PDO::PARAM_INT);
            $stm->execute();

            $dat = $stm->fetch();  
        }
            
        if($_POST && empty(trim($_POST['comment']))){
            $comment_error = "* Comment cannot be blank.";            
        } 
        else{      
            if($_POST && $_POST['save'] && !empty(trim($_POST['comment']))){
                $commentid = (int)filter_input(INPUT_POST, 'commentid'
                    , FILTER_SANITIZE_NUMBER_INT);  
                $comment = trim(filter_input(INPUT_POST, 'comment'
                    , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
                $qryCategory = "UPDATE comment
                                SET comment = :comment
                                WHERE commentid = :commentid";

                $stmCategory = $db->prepare($qryCategory);
                $stmCategory->bindValue(':comment', $comment, PDO::PARAM_STR); 
                $stmCategory->bindValue(':commentid', $commentid, PDO::PARAM_INT); 
                $stmCategory->execute();     
                
                header('Location: comments.php');
                exit;
            }  
            
            if($_POST && $_POST['delete']){ 
                $commentid = filter_input(INPUT_POST, 'commentid'
                    , FILTER_SANITIZE_NUMBER_INT);
                $qry="UPDATE comment
                    SET active = 0
                    WHERE commentid = $commentid";
                        
                $stm=$db->prepare($qry);        
                $stm->execute();  
 
                header("Location: comments.php");
                exit;
            }

            if($_POST && $_POST['reactivate']){ 
                $commentid = filter_input(INPUT_POST, 'commentid'
                    , FILTER_SANITIZE_NUMBER_INT);
                $qry="UPDATE comment
                    SET active = 1
                    WHERE commentid = $commentid";
                        
                $stm=$db->prepare($qry);        
                $stm->execute();  

                header("Location: comments.php");
                exit;
            }
        }
    }
?>

<h1>Edit comment</h1>
<form action="comments_edit.php" method="post">
    <input type="hidden" name="commentid" value="<?=$dat['commentid']?>">
    <label for="comment">
        Category name
    </label>
    <input type="text" rows="30" cols="80" name="comment" 
        value="<?php if(isset($dat['comment'])) echo $dat['comment'];?>"> 
    <span>
        <?php if(isset($comment_error)) echo $comment_error; ?>
    </span> 
    <br />
    <br />
    <button type="submit" class="btn btn-secondary" name="save" value="save">Save</button>        
    <button type="button" class="btn btn-secondary" 
        onclick="window.location.replace('comments.php')">Cancel</button>
    <?php if($dat['active'] == 1): ?> 
        <button type="submit" class="btn btn-secondary" value="delete" name="delete"
            onclick="return confirm('Are you sure?')">De-activate</button>
    <?php else: ?>   
        <button type="submit" class="btn btn-secondary" 
            value="Re-activate" name="reactivate">Re-activate</button>
    <?php endif ?>   
    <br />
    <br />
    <br />   
</form>
 <?php require_once('footer.php'); ?>