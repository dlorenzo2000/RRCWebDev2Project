<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 15, 2022
 * Updated: Nov 16, 2022 
 * Purpose: Reviews page displays the reviews posted by a logged in user.
 *****************************************************************************/

    session_start();

    require('connect.php'); 

    require_once('header.php');
    $userid =  $_SESSION['userid']; 
    
    // query the restaurants that have review posts
    $qryRestaurant = "SELECT * 
                      FROM restaurant 
                      INNER JOIN post 
                      WHERE post.restaurantid = restaurant.restaurantid
                        AND post.active = 1";
                      
    $stmRestaurant = $db->prepare($qryRestaurant);
    
    $stmRestaurant->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
</head>
<body>
    <hr>
    <div class="container">   
        <div class="row">
            <div class="col">
                <button onclick="location.href='post_review.php';" 
                    class="btn btn-secondary">New review</button>
            </div>
        </div>     
        <div class="row">              
            <?php if(stmRestaurant->rowCount() > 0): ?>
                <ul>                
                    <?php while($datRestaurant = $stmRestaurant->fetch()): ?>                        
                        <li>
                            <h5><?= $datRestaurant['restaurant_name'] ?></h5>                            
                            <h6><?= $datRestaurant['post_title'] ?> - <?= $datRestaurant['restaurant_rating'] ?>/10</h6>
                            <h6>
                                Posted on <?= date('F d, Y h:m A', strtotime($datRestaurant['created_date'])) ?>
                                <a href="update_review.php?postid=<?= $datRestaurant['postid'] ?>">EDIT</a>                                
                            </h6>
                            <p><?= $datRestaurant['post_content'] ?></p>   
                        </li>
                    <?php endwhile ?>
                </ul>
            <?php else: ?>
                <p>
                    You have no reviews yet. Click on New review.
                </p>
            <?php endif ?>
        </div>
    </div>
    <?php require_once('footer.php'); ?>
</body>
</html>