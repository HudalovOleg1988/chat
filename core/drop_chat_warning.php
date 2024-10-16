<?php
	function drop_chat_warning($pdo) {
		GLOBAL $user;
		if (isset($_GET['drop_warning'])) {
			//наличие значения
			if ($_GET['drop_warning'] == "") {
				header("Location: .");
				exit;
			}
			//проверка контакта
			if (!in_array($_GET['drop_warning'],$_SESSION['contacts'])) {
				header("Location: .");
				exit;
			}
			//запрос информации о пользователе
			$sql="SELECT * FROM users WHERE userId=:user_id";
			$user=query( $pdo, $sql, array(":user_id"=>$_GET['drop_warning']), "fetch" );
		}
	}
?>