<?php
session_start();

if (isset($_COOKIE["user"])) {
	setcookie("user",time() - 1800);
}
if(isset($_SESSION["user"])){
	$_SESSION = array();
	session_destroy();
}

header("location: login.php");
session_destroy();
