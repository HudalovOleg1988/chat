<?php
	function add_contact($pdo) {
		if (isset($_GET['add_contact'])) {
			//пустое значение
			if ($_GET['add_contact']=="") {
				header("Location: .");
				exit;
			}
			//проверить наличие пользователя
			$sql = "SELECT * FROM users WHERE userId=:user_id";
			$user_contact = query( $pdo, $sql, array(":user_id"=>$_GET['add_contact']), "fetch" );
			if (empty($user_contact)) {
				header("Location: .");
			  	exit;
			}
			//проверить наличие контакта с этим пользователем
	  		$sql = "SELECT * FROM user_contact WHERE user_id=:user_id AND contact=:contact";
			$contact = query( $pdo, $sql, array(":user_id"=>$_SESSION['user_id'],":contact"=>$_GET['add_contact']), "fetch" );
			if (empty($contact)) {
		  		$sql = "INSERT INTO user_contact SET user_id=:user, contact=:contact";
				query( $pdo, $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$_GET['add_contact']), null );
				//обновление сессии
				$_SESSION['contacts'][] = $_GET['add_contact'];
			}
			//проверка наличия поискового запроса для редиректа
			if (isset($_GET['search'])) {
				header("location: .?search=".$_GET['search']."&user=".$_GET['add_contact']);
				exit;
			} else {
				header("location: .?user=".$_GET['add_contact']);
				exit;
			}
		}
	}
?>