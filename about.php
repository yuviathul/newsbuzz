<?php include 'includes/header.php';

//**PREVENTING SESSION FIXATION**

ini_set('session.cookie_httponly', 1);

//**PREVENTING SESSION FIXATION**
ini_set('session.use_only_cookies', 1);


//uses a secure connection (HTTPS) if possible
ini_set('sesson.cookie_secure', 1);


?>
        <!-- Navigation Bar -->
   <?php include 'includes/navbar.php';?>
        <!-- Navigation Bar -->

    <div class="container">
        <div class="row">
	        <!-- Page Content -->
	        <div class="col-md-8">
            <h1 class="page-header">NewsNow™</h1>
            Hi there!
            <br>
            This application is a NEWS PUBLISHING SYSTEM which allows users to post and manage various kinds of news content.<br>
            Or you can say a simple CMS.
            <br><br><br>




           
           Main Features:
           <br><br>
           # Multiple user access: allows multiple type of users to login <br>
           # Functional Admin panel:  allows all admins to manage their content properly with admin panel  <br>
           # CRUD functionalities:  allows all users to create,read,update and delete their content in a managed format <br>
           # Profile update option: allows users to update their profile/account details <br>
           # Secure registration and login option for users <br>
           # Search news:  option for search all content 
           <br><br><br>

           Tools used: 
           <br><br>
           #Front-End:  HTML, CSS <br>
           #Back-End:   PHP       <br>
           #DataBase:   MySQL     <br>
           <br><br><br>

           <br>
           <br>



        </div>

             <div class="col-md-4">

               <?php include 'includes/sidebar.php';
?><!-- Footer -->
</div>
</div>
</div>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>