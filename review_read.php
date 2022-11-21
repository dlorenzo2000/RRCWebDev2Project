<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 20, 2022
 * Updated: Nov 21, 2022 
 * Purpose: Page for viewing whole review and comments posted by others
 ******************************************************************************/

    require_once('header.php');   

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

        }
    }           
    
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
                    AND post.restaurantid = restaurant.restaurantid
                    AND post.categoryid = foodcategory.categoryid LIMIT 1";

        $stm = $db->prepare($qry);           
        $stm->bindValue(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();

        $dat = $stm->fetch();

        $qryEditCategory = "SELECT * FROM foodcategory JOIN post WHERE 
            post.categoryid = foodcategory.categoryid AND post.postid = $postid LIMIT 1";
     
        $stmEditCategory = $db->prepare($qryEditCategory);
        $stmEditCategory->execute();
        $datEditCategory = $stmEditCategory->fetch();     
        
        $qryComment = "SELECT * FROM comment LEFT JOIN user ON comment.userid = user.userid  
            WHERE comment.postid = $postid ORDER BY comment_date DESC";
         
        $stmComment = $db->prepare($qryComment);
        $stmComment->execute();             
     }     
?> 

<div class="row justify-content-center">
    <h1>Reading review</h1>
    <br />
    <br />        
    <br />        
    <br />               
    <h5><?= $dat['restaurant_name'] ?> - <?= $datEditCategory['category_name'] ?></h5>
    <h5>Title - <?=$dat['post_title']?></h5>
    <?=$dat['post_content']?> 
    <br /> 
    <br /> 
    <?= $dat['restaurant_rating']?>/10 rating posted by <?=$dat['first_name']?> on    
    <?php $display_date = (($dat['created_date']) === ($dat['modified_date'])) ?
        date('F d, Y h:i A', strtotime($dat['created_date'])) : 
        date('F d, Y h:i A', strtotime($dat['modified_date'])); ?>  
    <?php if(isset($display_date)) echo $display_date; ?>     
    <br />
    <br />
    <br /> 
    
    <form action="review_read.php?postid=<?= $dat['postid']?>" method="post">
        <input type="hidden" name="postid" value="<?=$dat['postid']?>"> 
        <label for="comment">
            Comment
        </label>
        <input type="text" size="125" name="comment">
        <span>
            <?php if(isset($comment_error)) echo $comment_error; ?>
        </span> 
        <br />
        <br />
        <button type="submit" class="btn btn-secondary" id="submit">Add</button>        
        <button type="reset" class="btn btn-secondary">Clear</button>
        <br />
        <br />
        <br />  
    </form> 
<div class="row justify-content-center">
     <br />
    <br />
    <?php if($stmComment->rowCount() > 0): ?>
        <ul>
            <?php while($datComment = $stmComment->fetch()): ?>
                <hr>
                <li>
                    <?php if(strtotime($datComment['modified_date']) 
                        > strtotime($datComment['comment_date']))
                        $modified = "Updated on " . date('F d, Y h:i A'
                            , strtotime($datComment['modified_date']));
                    ?>
                    <p><?= $datComment['comment'] ?></p>
                    Comment posted by 
                    <?php if($datComment['userid'] == 0 ): ?>
                        Anonymous user
                    <?php else: ?>
                        <?=$datComment['first_name']; ?>
                    <?php endif ?> 
                    <br />
                    on <?= date('F d, Y h:i A', strtotime($datComment['comment_date'])) ?>
                    <br />  
                    <span><?php if(isset($modified)) echo $modified; ?></span>                          
                </li>
                <hr>          
            <?php endwhile ?>               
            </ul>
    <?php else: ?>
        <p>
           There are no comments yet. 
        </p>
    <?php endif ?>    
</div>    
<?php require_once('footer.php') ?>