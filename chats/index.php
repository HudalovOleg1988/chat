<?php
	include $_SERVER['DOCUMENT_ROOT']. "/core/query.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/auth.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/send_message.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/open_chat.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/add_contact.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/message_count.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/delete_contact.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/delete_messages.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/delete_messages_warning.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/drop_chat.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/drop_chat_warning.php";
	//ПРОВЕРКА АВТОРИЗАЦИИ
	auth();
	//ОТКРЫТИЕ ЧАТА С ПОЛЬЗОВАТЕЛЕМ
	open_chat($pdo);
	//ОТПРАВКА СООБЩЕНИЯ
	send_message($pdo);
	//УДАЛЕНИЕ КОНТАКТА
	delete_contact($pdo);
	//ДОБАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯ В СПИСОК КОНТАКТОВ
	add_contact($pdo);
	//ПРЕДУПРЕЖДЕНИЕ О УДАЛЕНИИ СООБЩЕНИЙ ЧАТА
	delete_messages_warning($pdo);
	//УДАЛЕНИЕ ВСЕХ СООБЩЕНИЙ ЧАТА
	delete_messages($pdo);
	//ПРЕДУПРЕЖДЕНИЕ О УДАЛЕНИИ ЧАТА
	drop_chat_warning($pdo);
	//УДАЛЕНИЕ ЧАТА
	drop_chat($pdo);
	//ЗАПРОС КОЛЛИЧЕСТВА НЕПРОЧИТАННЫХ СООБЩЕНИЙ
	message_count($pdo);
	//ПОСТРОЕНИЕ ЗАПРОСА В ЗАВИСИМОСТИ ОТ НАЛИЧИЯ ПОИСКОВОГО ЗАПРОСА
	$sql = "SELECT * FROM users INNER JOIN chat ON users.userId=chat.contact WHERE chat.user=:user ORDER BY lastupdate DESC";
	if (isset($_GET['search']))
	{
		$search = $_GET['search'];
		$sql = "SELECT * FROM users INNER JOIN chat ON users.userId=chat.contact WHERE 
		chat.user=:user AND name LIKE '%$search%' OR nic LIKE '%$search%' OR email LIKE '%$search%' 
		ORDER BY lastupdate DESC";
	}
	$chats = query( $pdo, $sql, array(":user"=>$_SESSION['user_id']), "fetchAll" );
	//ЗАПРОС ПОСЛЕДНЕГО СООБЩЕНИЯ КАЖДОГО ЧАТА
	if (!empty($chats)) {
		// $chats_id="";
		for ($i=0; $i < COUNT($chats); $i++) {
			$sql = "SELECT * FROM message 
					INNER JOIN chat_message ON textId=message_id 
					INNER JOIN chat ON chat_id=chatId 
					WHERE chatId=:chat_id
					ORDER BY messagetime DESC LIMIT 1";
			$message = query( $pdo, $sql, array(":chat_id"=>$chats[$i]['chatId']), "fetch" );
			$chats[$i]['message'] = "";
			$chats[$i]['message_time'] = "";
			if (!empty($message)) {
				$chats[$i]['message'] = $message['message'];
				$chats[$i]['message_time'] = $message['messagetime'];
				$chats[$i]['view'] = $message['view'];
			}
		}
	}
	$nav = "chats";
	$placeholder = "search chats";
	include $_SERVER['DOCUMENT_ROOT']."/html/chats.php";
?>