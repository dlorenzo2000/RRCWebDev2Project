<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 12, 2022
 * Updated: Nov 17, 2022 
 * Purpose: Manage the login to the website. 
 *****************************************************************************/
 
    require_once('header.php');

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if($_POST && empty(trim($_POST['username']))){
            $username_error = "* Please enter your username.";
        }
        if($_POST && empty(trim($_POST['pwd']))){
            $password_error = "* Please enter your password.";
        }    
    }

    if($_POST && !empty(trim($_POST['username'])) && !empty(trim($_POST['pwd']))){
         
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $qry = "SELECT * FROM User WHERE username = :username LIMIT 1";
        
        $stm = $db->prepare($qry);

        $stm->bindvalue('username', $username, PDO::PARAM_STR);
        
        $stm->execute();

        if($stm->rowCount() > 0 ){            
            $dat = $stm->fetch();
            if($dat['pwd'] === $pwd){ 
                $_SESSION['username'] = $dat['username'];
                $_SESSION['userid'] = $dat['userid'];
                $_SESSION['admin'] = $dat['admin'];
                header("Location: home.php");
                die;                
            }
            else{           
                $password_error ="* Invalid password. Try again.";          
            } 
        }           
        else{  
            $username_error ="* Invalid username. Try again.";
        }
    }        
?>
  
<div class="row">
    <form method="post" action="login.php">    
        <br /> 
        <br /> 
        <br />         
        <h2>Login</h2> 
        <br />       
        <label for="username">Username</label>
        <input type="text" name="username"
            value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
        <span><?php if(isset($username_error)) echo $username_error; ?></span>   
        <br />
        <br />
        <label for="pwd">Password</label>
        <input type="password" name="pwd">    
        <span><?php if(isset($password_error)) echo $password_error; ?></span>   
        <br />
        <br />
        <button type="submit" class="btn btn-secondary">Login</button> 
        <br />
        <br />
        <a href="signup.php">Click here to sign up</a>
    </form>
</div> 
<?php require_once('footer.php'); ?> 