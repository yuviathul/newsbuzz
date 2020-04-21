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
include('includes/connection.php');
include('includes/adminheader.php');
include('../includes/session.php');



if (isset($_SESSION['role'])) {
$currentrole = $_SESSION['role'];
}
if ( $currentrole == 'user') {
echo "<script> alert('ONLY ADMIN CAN ADD USER');
window.location.href='./index.php'; </script>";
}
else {
if (isset($_POST['add'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
	'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
	'firstname'   => 'required|alpha|max_len,30|min_len,2',
	'lastname'    => 'required|alpha|max_len,30|min_len,1',
	'email'       => 'required|valid_email',
	'password'    => 'required|max_len,50|min_len,6',
));
$gump->filter_rules(array(
	'username' => 'trim|sanitize_string',
	'firstname' => 'trim|sanitize_string',
	'lastname' => 'trim|sanitize_string',
	'password' => 'trim',
	'email'    => 'trim|sanitize_email',
	));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
	?>
	<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
	<?php 
}
elseif(!preg_match("#[0-9]+#",$_POST['password'])) {
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Number! </font></center>";
    include ('register.php');
}
elseif(!preg_match("#[A-Z]+#",$_POST['password'])) {
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Capital Letter! </font></center>";
    include ('register.php');
}
elseif(!preg_match("#[a-z]+#",$_POST['password'])) {
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Lowercase Letter! </font></center>";
    include ('register.php');
}
elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Special Character ! </font></center>";
    include ('register.php');
}
else if ($_POST['password'] !== $_POST['cpassword']) 
{
	echo  "<center><font color='red'>Passwords do not match </font></center>";
}
else {
      $username = $validated_data['username'];
      $firstname = $validated_data['firstname'];
      $lastname = $validated_data['lastname'];
      $email = $validated_data['email'];
      $role = $_POST['role'];
      $pass = $validated_data['password'];
      $query = "INSERT INTO users(username,firstname,lastname,email,password,role) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $username = mysqli_real_escape_string($conn, htmlspecialchars($username));
    $firstname = mysqli_real_escape_string($conn, htmlspecialchars($firstname));
    $lastname = mysqli_real_escape_string($conn, htmlspecialchars($lastname));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($email));
    $password = password_hash($pass , PASSWORD_ARGON2I);
    $role = mysqli_real_escape_string($conn , $role);
    $stmt->bind_param("ssssss", $username, $firstname,$lastname,$email,$password,$role);
    $execute = $stmt->execute();
      if ($execute) {
      	echo "<script>alert('NEW USER SUCCESSFULLY ADDED');
      	window.location.href='index.php';</script>";
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

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add a new user
                        </h1>

<form role="form" action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="user_title">User Name</label>
		<input type="text" name="username" class="form-control" required>
	</div>



	<div class="form-group">
		<label for="user_author">FirstName</label>
		<input type="text" name="firstname" class="form-control" required>
	</div>

	<div class="form-group">
		<label for="user_status">LastName</label>
		<input type="text" name="lastname" class="form-control" required>
	</div>

	<div class="input-group">
		<select class="form-control" name="role" id="">
		    <label for="user_role">Role</label>
		   <?php

echo "<option value='admin'>Admin</option>";
echo "<option value='user'>User</option>";
?>

	    </select>

	</div>
	<br>
	<div class="form-group">
		<label for="user_tag">Email</label>
		<input type="email" name="email" class="form-control" required>
	</div>
	<div class="form-group">
		<label for="user_tag">Password</label>
		<input id="password" onKeyUp="checkPasswordStrength();" type="password" name="password" class="form-control" required>
	</div>
    <div id="password-strength-status"></div>
	<div class="form-group">
		<label for="user_tag">Confirm Password</label>
		<input type="password" name="cpassword" class="form-control" required>
	</div>


<button type="submit" name="add" class="btn btn-primary" value="Add User">Add User</button>

</form>
</div>
</div>
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
<?php
include('includes/adminfooter.php');
?>
