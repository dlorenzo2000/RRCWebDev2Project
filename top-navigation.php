<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 15, 2022 
 * Purpose: Top navigation bar that is found on every page.
 *****************************************************************************/

    if(isset($_SESSION['username'])){
        $logout_link = "Logout";
        $my_reviews_link = "My Reviews";
    }

 ?>

<!DOCTYPE html>
<html lang="en">
   
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" 
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Document</title>
</head>
<body>
    <div class="container top-nav">
        <div class="row top-nav-links align-item-center">
            <div class="col-sm-4">
                <a href="index.php">
                    <img src="images/foodzagram-logo-sm.png" class="top-logo"/>
                </a>
            </div>    
            <div class="col-sm-8">            
                <ul>
                    <li class="top-nav-li"><a href="index.php">Home</a></li>        
                    <li class="top-nav-li"><a href="about.php">About</a></li>
                    <li class="top-nav-li"><a href="contact.php">Contact</a></li>    
                    <li class="top-nav-li"><a href="my_reviews.php">
                        <?php if(isset($logout_link)) echo $my_reviews_link; ?> </a></li>    
                      
                    <li class="top-nav-li"><a href="logout.php">
                        <?php if(isset($logout_link)) echo $logout_link; ?> </a></li>
                    <li class="top-nav-li">
                        <form action="#" class="top-nav-search">
                            <input type="text">
                        </form>
                        <a href="search.php"><button class="btn btn-secondary">
                            Search</button>
                        </a>
                    </li> 
                    <button onclick="location.href='login.php';" 
                        class="btn btn-secondary" >Login/Sign Up</button>                      
                </ul>
            </div>
        </div>        
    </div>          
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" 
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" 
        crossorigin="anonymous"></script>        
</body>
</html>