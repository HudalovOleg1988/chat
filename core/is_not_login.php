<?php
	function is_not_login()
	{
		session_start();
		if(!$_SESSION['login'])
		{
			header("Location: /");
			exit;
		}
	}
?>