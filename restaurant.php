<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 19, 2022
 * Updated: Nov 20, 2022 
 * Purpose: Logged in users can create and update restaurants.
 ******************************************************************************/

    require_once('header.php');
     
    // if the user visits this page and isn't logged in, then redirect
    if(!($usr_dat = CheckLogin($db))){
    }
    else{
        if($_SERVER['REQUEST_METHOD'] === "POST" && !empty(trim($_POST['restaurant-name'])
            && !empty(trim($_POST['restaurant-address'])))){

            $restaurant_name = trim(filter_input(INPUT_POST, 'restaurant-name'                
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $restaurant_address = trim(filter_input(INPUT_POST, 'restaurant-address'                
                , FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $cityid = trim(filter_input(INPUT_POST, 'cityid'                
                , FILTER_SANITIZE_NUMBER_INT));
            $provinceid = trim(filter_input(INPUT_POST, 'provinceid'                
                , FILTER_SANITIZE_NUMBER_INT));
            $cateogryid = trim(filter_input(INPUT_POST, 'categoryid'                
                , FILTER_SANITIZE_NUMBER_INT));         

            $qryRestaurant = "INSERT INTO restaurant (restaurant_name, restaurant_address
                                ,cityid, provinceid, categoryid) 
                              VALUES (:restaurant_name, :restaurant_address, :cityid,
                                :provinceid, :categoryid)";

            $stmRestaurant = $db->prepare($qryRestaurant);

            $stmRestaurant->bindValue(':restaurant_name', $restaurant_name);
            $stmRestaurant->bindValue(':restaurant_address', $restaurant_address);
            $stmRestaurant->bindValue(':cityid', $cityid);
            $stmRestaurant->bindValue(':provinceid', $provinceid);
            $stmRestaurant->bindValue(':categoryid', $cateogryid); 

            $stmRestaurant->execute();

            header('location: restaurant.php');
        }     
        else{
            if($_POST && empty(trim($_POST['restaurant-name'])))
                $restaurant_name_error = "* Restaurant name cannot be blank.";
    
            if($_POST && empty(trim($_POST['restaurant-address'])))
                $restaurant_address_error = "* Address cannot be blank."; 
        }    
    }                    
        
    // fill in drop down field for city
    $qryCity = "SELECT * FROM city";
    $stmCity = $db->prepare($qryCity);
    $stmCity->execute();

    // fill in drop down field for province
    $qryProvince = "SELECT * FROM province";
    $stmProvince = $db->prepare($qryProvince);
    $stmProvince->execute();

    // fill in drop down field for category
    $qryCategory = "SELECT * FROM foodcategory ORDER BY category_name";
    $stmCategory = $db->prepare($qryCategory);
    $stmCategory->execute();

    $qryRestaurants = "SELECT * FROM restaurant ORDER BY restaurant_name";
    $stmRestaurants = $db->prepare($qryRestaurants);
    $stmRestaurants->execute();
?>

<h1>Restaurants</h1>
<br />
<?php if($stmRestaurants->rowCount() > 0): ?> 
    <?php while($datRestaurants = $stmRestaurants->fetch()): ?>
        <?= $datRestaurants['restaurant_name'] ?>          
        <?php if(isset($usr_dat)): ?>
            <a href="restaurant_edit.php?restaurantid=<?= $datRestaurants['restaurantid']?>">edit</a> 
            <?php if($usr_dat['admin'] == 1 ) echo " - active " . $datRestaurants['active']; ?>                  
        <?php endif ?>
        <br />
    <?php endwhile ?> 
<?php endif ?>    
<?php require_once('footer.php'); ?>