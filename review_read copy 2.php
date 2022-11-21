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
     
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if($_POST && empty($_POST['post-comment'])){
            $post_comment_error = "* Comment form cannot be blank.";
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
            
            $qryComment = "INSERT INTO comment (comment, userid)
                VALUES (:comment, :userid)";

            $stmComment = $db->prepare($qryComment);
            $stmComment->bindValue(':comment', $comment);
            $stmComment->bindValue(':userid', $userid);
            $stmComment->execute();

            header('Location: review_read.php?postid=');
            exit; 
        }
    }   

    $postid = trim(filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT));
            
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

    $qryEditCategory = "SELECT * FROM foodcategory JOIN post 
        WHERE post.categoryid = foodcategory.categoryid 
        AND post.postid = $postid LIMIT 1";

    $stmEditCategory = $db->prepare($qryEditCategory);
    $stmEditCategory->execute();
    $datEditCategory = $stmEditCategory->fetch();     
    
    $qryComment = "SELECT * FROM comment WHERE postid = $postid";
    $stmComment = $db->prepare($qryComment);
    $stmComment->execute();            
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



<form action="review_read.php" method="post">

<label for="comment">
    <input type="hidden" name="postid" value="<?=$dat['postid']?>">
    Comment
    </label>
    <input type="text" size=100 name="comment">
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


  
</div> 
<div class="row justify-content-center">
     <br />
    <br />
    <?php if($stmComment->rowCount() > 0): ?>
        <ul>
            <?php while($datComment = $stmComment->fetch()): ?>
                <li>
                    <p><?= $datComment ?></p>
                    Posted on <?= date('F d, Y h:i A', strtotime($datComment['created_date'])) ?>
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