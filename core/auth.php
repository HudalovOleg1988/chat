<?php
	function auth() {
		session_start();
		if (!$_SESSION['login']) {
			header("Location: /");
			exit;
		}
	}
?>