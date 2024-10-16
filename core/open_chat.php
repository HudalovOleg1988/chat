<?php
	function open_chat($pdo) {
		GLOBAL $user, $chat, $contact, $messages;
		if (isset($_GET['user'])) {
			//пустое значение
			if ($_GET['user']=="") {
				header("Location: .");
				exit;
			}
			//запрос информации о пользователе
	  		$sql = "SELECT * FROM users WHERE userId=:user";
			$user = query( $pdo, $sql, array(":user"=>$_GET['user']), "fetch" );
			if (empty($user)) {
				header("Location: .");
				exit;
			}
			//запрос чата пользователя
			$sql = "SELECT * FROM chat WHERE user=:me AND contact=:contact";
			$chat = query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":contact"=>$_GET['user']), "fetch" );
			if (in_array($user['userId'],$_SESSION['contacts']) && !empty($chat)) {
				//указать что опонент является контактом
				$contact = true;
				// запрос сообщений чата
				$sql = "SELECT * FROM message INNER JOIN chat_message ON message.textId=chat_message.message_id 
	  				WHERE chat_message.chat_id=:chat_id ORDER BY messagetime DESC";
				$messages = query( $pdo, $sql, array(":chat_id"=>$chat['chatId']), "fetchAll" );
				//проставить просмотренно в присланных сообщениях
				$sql = "UPDATE message 
						INNER JOIN chat_message ON message.textId=chat_message.message_id
						INNER JOIN chat ON chat_message.chat_id=chat.chatId
						SET message.view=1 
						WHERE chatId=:chat_id AND NOT user_id=:me";
				query( $pdo, $sql, array(":me"=>$_SESSION['user_id'],":chat_id"=>$chat['chatId']), null );
			} else {
				$contact = false;
			}
		}
	}
?>