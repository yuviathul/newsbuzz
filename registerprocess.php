<?php
include('includes/connection.php');
if (isset($_POST['register'])) {
require "gump.class.php";
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
	include ('register.php');
}
elseif(!preg_match("#[0-9]+#",$_POST['password'])) {
    $passwordErr = "Your Password Must Contain At Least 1 Number!";
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Number! </font></center>";
    include ('register.php');
}
elseif(!preg_match("#[A-Z]+#",$_POST['password'])) {
    $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Capital Letter! </font></center>";
    include ('register.php');
}
elseif(!preg_match("#[a-z]+#",$_POST['password'])) {
    $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Lowercase Letter! </font></center>";
    include ('register.php');
}
elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
    $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
    echo  "<center><font color='red'>Your Password Must Contain At Least 1 Special Character ! </font></center>";
    include ('register.php');
}
else if ($_POST['password'] !== $_POST['cpassword']) 
{
	echo  "<center><font color='red'>Passwords do not match </font></center>";
	include ('register.php');
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $count = mysqli_num_rows($run_check); 
      if ($count > 0 ) {
	  echo  "<center><font color='red'>username already taken! try a different one</font></center>";
	  include ('register.php');
	  exit();
}
    $username = $validated_data['username'];
    $firstname = $validated_data['firstname'];
    $lastname = $validated_data['lastname'];
    $email = $validated_data['email'];
    $pass = $validated_data['password'];
    $query = "INSERT INTO users(username,firstname,lastname,email,password) VALUES (?,?,?,?,?)";
      $stmt = $conn->prepare($query);
    $username = mysqli_real_escape_string($conn, htmlspecialchars($username));
    $firstname = mysqli_real_escape_string($conn, htmlspecialchars($firstname));
    $lastname = mysqli_real_escape_string($conn, htmlspecialchars($lastname));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($email));
    $password = password_hash($pass , PASSWORD_ARGON2I);
    $stmt->bind_param("sssss", $username, $firstname,$lastname,$email,$password);
    $execute = $stmt->execute();
//      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if ($execute) {
      	echo "<script>alert('SUCCESSFULLY REGISTERED');
      	window.location.href='index.php';</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');
      	window.location.href='register.php';</script>";
}
}
}
else {
	header('location: register.php');
}
?>
