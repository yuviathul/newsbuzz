<style>
#password-strength-status {
        padding: 5px 10px;
        color: #FFFFFF;
        border-radius: 4px;
        margin-top: 5px;
    }

    .medium-password {
        background-color: #b7d60a;
        border: #BBB418 1px solid;
    }

    .weak-password {
        background-color: #ce1d14;
        border: #AA4502 1px solid;
    }

    .strong-password {
        background-color: #12CC1A;
        border: #0FA015 1px solid;
    }
</style>
<?php
include ('includes/connection.php');
include ('includes/adminheader.php');
include('../includes/session.php');

if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$query = "SELECT * FROM users WHERE username = '$username'" ; 
	$result= mysqli_query($conn , $query) or die (mysqli_error($conn));
	if (mysqli_num_rows($result) > 0 ) {
		$row = mysqli_fetch_array($result);
		$userid = $row['id'];
		$usernm = $row['username'];
		$userpassword = $row['password'];
		$useremail = $row['email'];
		$userfirstname = $row['firstname'];
		$userlastname = $row['lastname'];

	}

if (isset($_POST['update'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 


$gump->validation_rules(array(
	'firstname'   => 'required|alpha|max_len,30|min_len,2',
	'lastname'    => 'required|alpha|max_len,30|min_len,1',
	'email'       => 'required|valid_email',
	'currentpassword' => 'required|max_len,50|min_len,6',
	'newpassword'    => 'max_len,50|min_len,6',
));
$gump->filter_rules(array(
	'firstname' => 'trim|sanitize_string',
	'lastname' => 'trim|sanitize_string',
	'currentpassword' => 'trim',
	'newpassword' => 'trim',
	'email'    => 'trim|sanitize_email',
	));
$validated_data = $gump->run($_POST);
if($validated_data === false) {
	?>
	<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
	<?php
}
else if (!password_verify($validated_data['currentpassword'] ,  $userpassword))   
{
	echo  "<center><font color='red'>Current password is wrong! </font></center>";
}
else if(empty($_POST['newpassword'])) {
	$userfirstname = $validated_data['firstname'];
      $userlastname = $validated_data['lastname'];
      $useremail = $validated_data['email'];
      $updatequery1 = "UPDATE users SET firstname = ? , lastname=? , email=? WHERE id =? " ;
    $stmt = $conn->prepare($updatequery1  );
    $firstname = mysqli_real_escape_string($conn, htmlspecialchars($userfirstname));
    $lastname = mysqli_real_escape_string($conn, htmlspecialchars($userlastname));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($useremail));
    $userid = mysqli_real_escape_string($conn, htmlspecialchars($userid));
    $stmt->bind_param("sssi",  $firstname,$lastname,$email,$userid);
    $execute = $stmt->execute();
if ($execute) {
	echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');</script>";
}
}
else if(!preg_match("#[0-9]+#",$_POST['newpassword'])) {
        echo  "<center><font color='red'>Your Password Must Contain At Least 1 Number! </font></center>";
    }
    elseif(!preg_match("#[A-Z]+#",$_POST['newpassword'])) {
        echo  "<center><font color='red'>Your Password Must Contain At Least 1 Capital Letter! </font></center>";
    }
    elseif(!preg_match("#[a-z]+#",$_POST['newpassword'])) {
        echo  "<center><font color='red'>Your Password Must Contain At Least 1 Lowercase Letter! </font></center>";
    }
    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["newpassword"])) {
        echo  "<center><font color='red'>Your Password Must Contain At Least 1 Special Character ! </font></center>";
    }
else if (isset($_POST['newpassword']) &&  ($_POST['newpassword'] !== $_POST['confirmnewpassword'])) 
{
	echo  "<center><font color='red'>New password and Confirm New password do not match </font></center>";
	
}
else {
      $userfirstname = $validated_data['firstname'];
      $userlastname = $validated_data['lastname'];
      $useremail = $validated_data['email'];
      $pass = $validated_data['newpassword'];

$updatequery = "UPDATE users SET password = ?, firstname=? , lastname= ? , email= ? WHERE id=?";
    $stmt = $conn->prepare($updatequery);
    $firstname = mysqli_real_escape_string($conn, $userfirstname);
    $lastname = mysqli_real_escape_string($conn, $userlastname);
    $email = mysqli_real_escape_string($conn, $useremail);
    $userid = mysqli_real_escape_string($conn, $userid);
    $password = password_hash($pass , PASSWORD_ARGON2I);
    $stmt->bind_param("ssssi", $password, $firstname,$lastname,$email,$userid);
    $execute = $stmt->execute();
if ($execute) {
	echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');</script>";
}
}
}
}
?>
<div id="wrapper">

        
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to your Profile 
                            <small><?php echo $_SESSION['firstname']; ?></small>
                        </h1>
<form role="form" action="" method="POST" enctype="multipart/form-data">

<div class="form-group">
		<label for="user_title">User Name</label>
		<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" readonly>
	</div>



	<div class="form-group">
		<label for="user_author">FirstName</label>
		<input type="text" name="firstname" class="form-control" value="<?php echo $userfirstname; ?>" required>
	</div>

	<div class="form-group">
		<label for="user_status">LastName</label>
		<input type="text" name="lastname" class="form-control" value="<?php echo $userlastname; ?>" required>
	</div>
	<div class="form-group">
		<label for="user_tag">Email</label>
		<input type="email" name="email" class="form-control" value="<?php echo $useremail; ?>" required>
	</div>
	<div class="form-group">
		<label for="usertag">Current Password</label>
		<input type="password" name="currentpassword" class="form-control" placeholder="Enter Current password" required>
	</div>
	<div class="form-group">
		<label for="usertag">New Password <font color='brown'> (changing password is optional)</font></label>
		<input id="password" onKeyUp="checkPasswordStrength();" type="password" name="newpassword" class="form-control" placeholder="Enter New Password">
	</div>
    <div id="password-strength-status"></div>
	<div class="form-group">
		<label for="usertag">Confirm New Password</label>
		<input type="password" name="confirmnewpassword" class="form-control" placeholder="Re-Enter New Password" >
	</div>
<hr>


<button type="submit" name="update" class="btn btn-primary" value="Update User">Update User</button>

                    </div>
                </div>
                

            </div>
            

        </div>
        
   <?php 'includes/admin_footer.php';?> -->
    </div>
    
    <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function checkPasswordStrength() {
        $("#password-strength-status").show();
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        if ($('#password').val().length < 6) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('weak-password');
            $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
        } else {
            if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('strong-password');
                $('#password-strength-status').html("Strong Password");
                $('#password-strength-status').fadeOut(3000);
            } else {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('medium-password');
                $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
            }
        }
    }
</script>

</body>

</html>







