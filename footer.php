<?php
/****************************************************************************** 
 * Name: Dean Lorenzo
 * Student number: 0367298
 * Course: Web Development - 2008 (228566)
 * Assignment: Final Project
 * Created: Nov 16, 2022
 * Updated: Nov 16, 2022 
 * Purpose: Footer navigation at bottom of every page.
 *****************************************************************************/

    if(isset($_SESSION['username'])){
        $logout_link = "Logout";
        $my_reviews_link = "My Reviews";
    }
 ?>

</div> <!-- close div class="container -->
<hr>
<footer>
    <nav>
        <ul>
            <li class="bottom-nav-li"><a href="about.php">About</a></li>
            <li class="bottom-nav-li"><a href="contact.php">Contact</a></li> 
        </ul>
    </Nav>
</footer> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" 
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" 
    crossorigin="anonymous"></script>  
</body>
</html>