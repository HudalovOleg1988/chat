<?php
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['name']);
	unset($_SESSION['email']);
	unset($_SESSION['nic']);
	unset($_SESSION['user_id']);
	unset($_SESSION['avatar']);
	header("Location: /");
?>