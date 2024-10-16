<?php
	function delete_messages_warning($pdo) {
		GLOBAL $user;
		if (isset($_GET['clean_warning'])) {
			//наличие значения
			if ($_GET['clean_warning'] == "") {
				header("Location: .");
				exit;
			}
			//проверка контакта
			if (!in_array($_GET['clean_warning'],$_SESSION['contacts'])) {
				header("Location: .");
				exit;
			}
			//запрос информации о пользователе
			$sql="SELECT * FROM users WHERE userId=:user_id";
			$user=query( $pdo, $sql, array(":user_id"=>$_GET['clean_warning']), "fetch" );
		}
	}
?>