<?php
$pass = "testing";
var_dump($pass);
$password_hashed = password_hash($pass , PASSWORD_ARGON2I);
var_dump($password_hashed);
$test = password_verify($pass, $password_hashed);
var_dump($test);
die();