<?php
	// перевести все запросы в try catch
	session_start();
	if(isset($_SESSION['login']) && $_SESSION['login'])
		header("Location: /chats/");
	else
		header("Location: /auth/");
?>
