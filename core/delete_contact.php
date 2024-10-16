<?php
	function delete_contact($pdo) {
		if (isset($_GET['delete_contact'])) {
			//наличие значения
			if ($_GET['delete_contact']=="") {
				header("Location: .");
				exit;
			}
			//удаление из БД
	  		$sql = "DELETE FROM user_contact WHERE user_id=:me AND contact=:contact";
			query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_GET['delete_contact']), null );
			//удаление контакта из массива сессии
			foreach ($_SESSION['contacts'] as $key => $value) {
				if ($_GET['delete_contact']==$value)
					unset($_SESSION['contacts'][$key]);
			}

			if (isset($_GET['search'])) {
				header("location: .?search=".$_GET['search']."&user=".$_GET['delete_contact']);
				exit;
			}
			else {
				header("location: .?user=".$_GET['delete_contact']);
				exit;
			}
		}
	}
?>