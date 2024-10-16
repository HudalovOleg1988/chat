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
	//запрос списка пользователей в зависимости от наличия запроса
	$sql = "SELECT * FROM users INNER JOIN user_contact ON userId=contact WHERE TRUE";
	if (isset($_GET['search'])) {
		$search = $_GET['search'];
		$sql .= " AND email LIKE '%$search%' OR nic LIKE '%$search%' OR name LIKE '%$search%'";
	}
	$sql .= " AND user_id=:user_id";
	$users = query( $pdo, $sql, array(":user"=>$_SESSION['user_id']), "fetchAll");

	$nav = "contact";
	$placeholder = "search contact";
	include $_SERVER['DOCUMENT_ROOT']."/html/contact.php";
?>