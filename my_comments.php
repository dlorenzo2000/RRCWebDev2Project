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
    
    if(!($usr_dat = CheckLogin($db))){
        LoginRedirect();        
    }
    else{
        $userid = $usr_dat['userid'];
        $qryComments = "SELECT * 
            FROM comment 
            JOIN post ON comment.postid = post.postid 
            LEFT JOIN restaurant ON post.restaurantid = restaurant.restaurantid
            LEFT JOIN user ON comment.userid = user.userid
            WHERE comment.userid = $userid";
        $stmComments = $db->prepare($qryComments);
        $stmComments->execute();

        $datActive = "SELECT * FROM comment WHERE userid = $userid";
        $stmActive = $db->prepare($datActive);
        $stmActive->execute();
    }    
?> 

<h1>My Comments</h1>
<hr>
<div class="row">
    <div class="col-md-12">
        <?php if($stmComments->rowCount() > 0): ?>
            <ul>
                <?php while(($datComments = $stmComments->fetch()) 
                    && ($datActive = $stmActive->fetch())): ?>
                    <hr>
                    <li>
                        <a href="review_read.php?postid=<?=$datComments['postid']?>">
                            <?=$datComments['restaurant_name']?> - <?=$datComments['post_title']?>
                        </a> 
                        <?php if(strtotime($datComments['modified_date']) 
                            > strtotime($datComments['comment_date']))
                            $modified = "Updated on " . date('F d, Y h:i A'
                                , strtotime($datComments['modified_date']));
                        ?>
                        <br />                        
                        <p><?= $datComments['comment'] ?></p>
                        <?php if($datActive['active'] == 1): ?>
                            Active                      
                        <?php else: ?>        
                            In-active   
                        <?php endif ?>   
                        comment posted by 
                        <?php if($datComments['userid'] == 0 ): ?>
                            Anonymous user
                        <?php else: ?>
                            <?=$datComments['first_name']; ?>
                        <?php endif ?> 
                        <a href="my_comments_edit.php?commentid=<?=$datComments['commentid']?>">EDIT COMMENT </a>
                        <br />
                        on <?= date('F d, Y h:i A', strtotime($datComments['comment_date'])) ?>
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
</div> 
<?php require_once('footer.php') ?>