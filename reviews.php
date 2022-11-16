<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 13, 2022
 * Updated: Nov 13, 2022 
 * Purpose: Reviews page that contains food blogs written by registered users.
 *****************************************************************************/

    session_start();

    require('connect.php');
    require('header.php');

    // query the db for all the posts
    $qry = "SELECT * FROM post";    
    
    // query the restaurants that have review posts
    $qryRestaurant = "SELECT * 
                      FROM restaurant 
                      JOIN post 
                      WHERE post.restaurantid = restaurant.restaurantid 
                        AND active = 1";
                     
    $stm = $db->prepare($qry);
    $stmRestaurant = $db->prepare($qryRestaurant);
    
    $stmRestaurant->execute();
    $stm->execute();
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
                    class="btn btn-secondary">Write a review</button>
            </div>
        </div>     
        <div class="row">              
            <?php if(($stm->rowCount() > 0) && $stmRestaurant->rowCount() > 0): ?>
                <ul>                
                    <?php while($dat = $stm->fetch()): ?>
                        <?php $datRestaurant = $stmRestaurant->fetch() ?>                        
                        <li>
                            <h5><?= $datRestaurant['restaurant_name'] ?></h5>                            
                            <h6><?= $dat['post_title'] ?> - <?= $dat['restaurant_rating'] ?>/10</h6>
                            <h6>Posted on <?= date('F d, Y h:m A', strtotime($dat['created_date'])) ?></h6>
                            <p><?= $dat['post_content'] ?></p>        
                        </li>
                    <?php endwhile ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</body>
</html>