<?php
	function drop_chat($pdo) {
		if (isset($_GET['drop'])) {
			//наличие значения
			if ($_GET['drop'] == "") {
				header("Location: .");
				exit;
			}
			//проверка контакта
			if (!in_array($_GET['drop'],$_SESSION['contacts'])) {
				header("Location: .");
				exit;
			}
			//запросить id чата
			$sql="SELECT chatId FROM chat WHERE user=:user AND contact=:contact";
			$chatId=query( $pdo, $sql, array(":user"=>$_SESSION['user_id'],":contact"=>$_GET['drop']), "fetch" );
			if (empty($chatId)) {
				header("Location: .");
				exit;
			}
			//запросить сообщения чата
			$sql="SELECT * FROM message INNER JOIN chat_message ON textId=message_id WHERE chat_id=:chat_id";
			$messages=query( $pdo, $sql, array(":chat_id"=>$chatId['chatId']), "fetchAll" );
			//удалить связку сообщений с чатом
			$sql="DELETE FROM chat_message WHERE chat_id=:chat_id";
			query( $pdo, $sql, array(":chat_id"=>$chatId['chatId']), null );
			//удалить сообщения чата привязанные к одному чату или сделать update
			foreach ($messages as $i) {
				$i['chats']." ";
				if ($i['chats']==2) {
					$sql="UPDATE message SET chats=1 WHERE textId=:message_id";
				} else {
					$sql="DELETE FROM message WHERE textId=:message_id";
				}
				query( $pdo, $sql, array(":message_id"=>$i['textId']), null );
			}
			//удалить чат
			$sql="DELETE FROM chat WHERE chatId=:chat_id";
			query( $pdo, $sql, array(":chat_id"=>$chatId['chatId']), null );
			//проверка наличия поискового запроса для редиректа
			if (isset($_GET['search'])) {
				header("location: .?search=".$_GET['search']."&user=".$_GET['drop']);
				exit;
			} else {
				header("location: .?user=".$_GET['drop']);
				exit;
			}
		}
	}
?>