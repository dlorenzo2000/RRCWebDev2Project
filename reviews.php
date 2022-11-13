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
    require('top-navigation.php');

    // query the db for all the posts
    $qry = "SELECT * FROM post";    
    $stm = $db->prepare($qry);
    $stm->execute();

    // query the restaurants that have review posts
    $qryRestaurant = "SELECT * 
                      FROM restaurant 
                      JOIN post 
                      WHERE post.restaurantid = restaurant.restaurantid";
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
    <div class="container">        
        <div class="row">  
            <?php if(($stm->rowCount() > 0) && $stmRestaurant->rowCount() > 0): ?>
                <ul>                
                    <?php while($dat = $stm->fetch() 
                        && $datRestaurant = $stmRestaurant->fetch()): ?>
                        <li>
                            <h2><?= $datRestaurant['restaurant_name'] ?></h2>                            
                            <h3><?= $dat['post_title'] ?></h3>
                            <p><?= $dat['post_content'] ?></p>
                        </li>
                    <?php endwhile ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</body>
</html>