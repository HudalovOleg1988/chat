<?php
	function delete_messages($pdo) {
		if (isset($_GET['clean'])) {
			//пустое значение
			if ($_GET['clean'] == "") {
				header("Location: .");
				exit;
			}
			//проверка контакта
			if (!in_array($_GET['clean'],$_SESSION['contacts'])) {
				header("Location: .");
				exit;
			}
			//запрос id чата с опонентом
			$sql="SELECT chatId FROM chat WHERE user=:user AND contact=:contact";
			$chat=query( $pdo, $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$_GET['clean']), "fetch" );
			//удаление сообщений чата
			//запрос id всех сообщений относящихся к чату
			$sql = "SELECT textId,chats FROM message 
					INNER JOIN chat_message ON textId=message_id
					INNER JOIN chat ON chat_id=chatId
					WHERE chatId=:chat_id";
			$messages_id=query( $pdo, $sql, array(":chat_id"=>$chat['chatId']), "fetchAll" );
			if (empty($messages_id)) {
				header("Location: .");
				exit;
			}
			//удаление связки чата с удаляемыми сообщениями
			foreach ($messages_id as $i) {
				$sql="DELETE FROM chat_message WHERE chat_id=:chat_id AND message_id=:message_id";
				query( $pdo, $sql, array(":chat_id"=>$chat['chatId'],":message_id"=>$i['textId']), null );
			}
			//удаление или update сообщений
			foreach ($messages_id as $i) {
				if ($i['chats']==2) {
					$sql="UPDATE message SET chats=1 WHERE textId=:text_id";
				} else {
					$sql="DELETE FROM message WHERE textId=:text_id";
				}
				query( $pdo, $sql, array(":text_id"=>$i['textId']), null );
			}
			//проверка наличия поискового запроса для редиректа
			if (isset($_GET['search'])) {
				header("location: .?search=".$_GET['search']."&user=".$_GET['clean']);
				exit;
			} else {
				header("location: .?user=".$_GET['clean']);
				exit;
			}
		}
	}
?>