<?php
	function send_message($pdo) {
		if (isset($_POST['message'])) {
			//наличие значения
			if ($_POST['id']=="") {
				header("Location: .");
				exit;
			}
			//является ли контактом
			if (!in_array($_POST['id'],$_SESSION['contacts'])) {
				header("Location: .");
				exit;
			}
			//наличия сообщения
			if ($_POST['message']=="") {
				if ($_POST['search']!="") {
					header("Location: .?search=".$_POST['search']."&user=".$_POST['id']);
					exit;
				} else {
					header("Location: .?user=".$_POST['id']);
					exit;
				}
			}
			//проверка наличия чата у меня, если нет - создать
	  		$sql = "SELECT * FROM chat WHERE user=:me AND contact=:contact";
			$chat = query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_POST['id']), "fetch" );
			if (!empty($chat)) {
				$chat_user_id = $chat['chatId'];
			} else {
		  		$sql = "INSERT INTO chat SET chatdate=now(), lastupdate=now(), user=:me, contact=:contact";
				query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_POST['id']), null );
				$chat_user_id = $pdo->lastInsertId();
			}
			//проверка наличия чата у опонента, если нет - создать
			$sql = "SELECT * FROM chat WHERE user=:contact AND contact=:me";
			$chat = query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_POST['id']), "fetch" );
			if (!empty($chat)) {
				$chat_oponent_id = $chat['chatId'];
			} else {
				$sql = "INSERT INTO chat SET chatdate=now(), lastupdate=now(), user=:contact, contact=:me";
				query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_POST['id']), null );
				$chat_oponent_id = $pdo->lastInsertId();
			}
			//вносим сообщение в БД
			$sql = "INSERT INTO message SET message=:message, messagetime=now(), view=0, chats = 2, user_id=:user_id";
			query( $pdo, $sql, array(":message"=>$_POST['message'],":user_id"=>$_SESSION['user_id']), null );
			$message_id = $pdo->lastInsertId();
			//привязываем сообщение к моему чату
			$sql = "INSERT INTO chat_message SET chat_id=:chat_id, message_id=:message_id";
			query( $pdo, $sql, array(":chat_id"=>$chat_user_id,":message_id"=>$message_id), null );
			//привязываем сообщение к чату опонента
			$sql = "INSERT INTO chat_message SET chat_id=:chat_id, message_id=:message_id";
			query( $pdo, $sql, array(":chat_id"=>$chat_oponent_id,":message_id"=>$message_id), null );
			//проставить последние обновления в чатах
			$sql = "UPDATE chat SET lastupdate = now() WHERE chatId=:chat_id";
			query( $pdo, $sql, array(":chat_id"=>$chat_user_id), null );
			$sql = "UPDATE chat SET lastupdate = now() WHERE chatId=:chat_id";
			query( $pdo, $sql, array(":chat_id"=>$chat_oponent_id), null );

			if ($_POST['search']!="") {
				header("Location: .?search=".$_POST['search']."&user=".$_POST['id']);
				exit;
			} else {
				header("Location: .?user=".$_POST['id']);
				exit;
			}
		}
	}
?>