<?php
//**PREVENTING SESSION HIJACKING**
ini_set('session.cookie_httponly', 1);

//**PREVENTING SESSION FIXATION**
ini_set('session.use_only_cookies', 1);

//**uses a secure connection (HTTPS) if possible**
ini_set('sesson.cookie_secure', 1);

//**PREVENTING FRAMEBURSTNG**
header('X-Frame-Options: DENY');

session_start();


include('includes/connection.php');
/*include('csrf.php');*/
if (isset($_POST['login'])) {
	$username  = $_POST['user_name'];
	$password = $_POST['user_password'];
	mysqli_real_escape_string($conn, $username);
	mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$user = $row['username'];
		$pass = $row['password'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$role= $row['role'];
		//$image = $row['image'];
		if (password_verify($password, $pass )) {
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $user;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['email']  = $email;
			$_SESSION['role'] = $role;
			$_SESSION['image'] = $image;
            $_SESSION['pgasuid']=$id;
            $_SESSION['last_login_timestmp']= time();
            $cookie_name['pgasaid']=$id;
            $cookie_value = $id;
            setcookie($cookie_name, $cookie_value);
            setcookie($cookie_name, $cookie_value, time() + 900, "/");
            if(!isset($_COOKIE[$cookie_name]))
            {
                echo "cookie named '" . $cookie_name . "'is set!<br>";
                echo "value is: " . $_COOKIE[$cookie_name];
            }
			header('location: admin');
		}
		else {
			echo "<script>alert('invalid username/password');
			window.location.href= 'index.php';</script>";

		}
	}
}
else {
			echo "<script>alert('invalid username/password');
			window.location.href= 'index.php';</script>";

		}
}
else {
	header('location: index.php');
}
?>


