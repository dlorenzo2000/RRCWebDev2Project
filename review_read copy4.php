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

        $qryEditCategory = "SELECT * FROM foodcategory JOIN post 
            WHERE post.categoryid = foodcategory.categoryid 
            AND post.postid = $postid LIMIT 1";

        $stmEditCategory = $db->prepare($qryEditCategory);
        $stmEditCategory->execute();
        $datEditCategory = $stmEditCategory->fetch();     
        
        $qryComment = "SELECT * FROM comment 
            WHERE postid = $postid ORDER BY comment_date DESC";
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
    <div class="col">
        <button onclick="location.href='post_comment.php?postid=<?= $dat['postid']?>'" 
            class="btn btn-secondary">Comment</button>
        <input type="hidden" name="postid" value="<?=$dat['postid']?>">         
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
                        < strtotime($datComment['comment_date']))
                        $modified = "Updated on " . date('F d, Y h:i A'
                            , strtotime($datComment['modified_date']));
                    ?>
                    <p><?= $datComment['comment'] ?></p>
                    Posted on <?= date('F d, Y h:i A'
                        , strtotime($datComment['comment_date'])) ?>
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