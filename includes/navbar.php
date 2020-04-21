<?php
session_start();
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation"">
			<div class="container">


				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">NewsNow</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                    	<li><a href="about.php">About Us</a></li>
						 
						 <li><a href="register.php">Register</a></li>
                        <?php if(isset($_SESSION['id'])){ ?>

                            <li><a href="admin/index.php">Admin</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php }?>



                    </ul>
				</div>
			</div>
	    </nav>