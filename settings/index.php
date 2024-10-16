<?php
	include $_SERVER['DOCUMENT_ROOT']. "/core/query.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/auth.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/message_count.php";










	//ПРОВЕРКА АВТОРИЗАЦИИ
	auth();










	//УДАЛЕНИЯ АВАТАРА
	if (isset($_GET['delete_avatar'])) {
		//наличия значения
		if ($_SESSION['avatar'] == "") {
			header("Location: .?error_message=у вас нет аватара");
			exit;
		}
		//удаление из папки
		$old_avatar = $_SERVER['DOCUMENT_ROOT']."/avatars/".$_SESSION['avatar'];
		if (is_file($old_avatar)) {
	    	unlink($old_avatar);
	  	}
	  	//удаление из базы данных
  		$sql = "UPDATE users SET avatar=:avatar WHERE userId=:id";
		query( $pdo, $sql, array(":avatar"=>"",":id"=>$_SESSION['user_id']), null );
		//удаление из сесси
	  	$_SESSION['avatar'] = "";

	  	header("Location: .?message_edit=аватар удален");
		exit;
	}
	//УДАЛЕНИЯ АВАТАРА










	//ИЗМЕНЕНИЯ АВАТАРА
	if (isset($_POST['change_avatar'])) {
		//проверка формата файла
		if ($_FILES['avatar']['type'] != "image/gif" && 
			$_FILES['avatar']['type'] != "image/jpg" && 
			$_FILES['avatar']['type'] != "image/jpeg" &&
			$_FILES['avatar']['type'] != "image/png") {
			header("Location: .?error_message=доспукается тип файла gif,jpeg");
			exit;
		}
		//удаление старого аватара из папки
		$old_avatar = $_SERVER['DOCUMENT_ROOT']."/avatars/".$_SESSION['avatar'];
		if (is_file($old_avatar)) {
	    	unlink($old_avatar);
	  	}
		//создание уникального имени
		$avatar = hash("sha256", rand()).time().$_SESSION['user_id'].'.jpg';
		//заносение файла в папку
		move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/avatars/".$avatar);
		//заносим уникальной имя файла в БД
  		$sql = "UPDATE users SET avatar=:avatar WHERE userId=:id";
		query( $pdo, $sql, array(":avatar"=>$avatar,":id"=>$_SESSION['user_id']), null );
		//обновление сесси аватара
		$_SESSION['avatar'] = $avatar;

		header("Location: .?message_edit=аватар обновлен");
		exit;
	}
	//ИЗМЕНЕНИЯ АВАТАРА










	//ИЗМЕНЕНИЯ ИМЕНИ
	if (isset($_POST['name'])){
		$name = $_POST['name'];
		//проверка наличия и формата значения
		if (!preg_match('/^[\s\S]{1,20}$/',$name)) {
			header("Location: .?error_message=имя должно содержать от 1 до 20 символов&name=$name");
			exit;
		}
		//обновление имени в БД
  		$sql = "UPDATE users SET name=:name WHERE userId=".$_SESSION['user_id'];
		query( $pdo, $sql, array(":name"=>$name), null );
		//обновление сесси имени
		$_SESSION['name'] = $name;

		header("Location: .?message_edit=имя измененно");
		exit;
	}
	//ИЗМЕНЕНИЯ ИМЕНИ










	//ИЗМЕНЕНИЯ НИК
	if (isset($_POST['nic'])) {
		$nic = $_POST['nic'];
		//проверка наличия и формата ник
		if (!preg_match('/^[a-zA_Z0-9.-]{1,20}$/',$nic)) {
			header("Location: .?error_message=nic должен быть не более 20 символов и состоять только из латиницы, цифр,.-;&nic=$nic");
			exit;
		}
		//проверка уникальности ник
  		$sql = "SELECT * FROM users WHERE nic = :nic";
		$unique_nic = query( $pdo, $sql, array(":nic"=>$nic), "fetch" );
		if (!empty($unique_nic['nic'])) {
			header("Location: .?error_message=данный ник уже занят&nic=$nic");
			exit;
		}
		//обновление в БД
  		$sql = "UPDATE users SET nic=:nic WHERE userId=".$_SESSION['user_id'];
		query( $pdo, $sql, array(":nic"=>$nic), null );
		//обновление сессии
		$_SESSION['nic'] = $nic;

		header("Location: .?message_edit=nic измененно");
		exit;

	}
	//ИЗМЕНЕНИЯ НИК










	//ИЗМЕНЕНИЯ ПОЧТЫ
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		//проверка наличия значеия и формата электронной почты
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$email)) {
			header("Location: .?error_message=некорректный формат электронной почты&email=$email");
			exit;
		}
		//проверка уникальности адреса почты
  		$sql = "SELECT * FROM users WHERE email = :email";
		$unique_email = query( $pdo, $sql, array(":email"=>$email), "fetch" );
		if (!empty($unique_email['email'])) {
			$error = "данный email уже занят";
			header("Location: .?error_message=данный email уже занят&email=$email");
			exit;
		}
		//обновление в БД
	  	$sql = "UPDATE users SET email=:email WHERE userId=".$_SESSION['user_id'];
		query( $pdo, $sql, array(":email"=>$email), null );
		//обновление сессии
		$_SESSION['email'] = $email;

		header("Location: .?message_edit=email изменен");
		exit;
	}
	//ИЗМЕНЕНИЯ ПОЧТЫ










	//ИЗМЕНЕНИЯ ПАРОЛЯ
	if (isset($_POST['change_password'])) {
		//запрос прежнего пароля для сверки с введенным
  		$sql = "SELECT password FROM users WHERE userId = :id";
		$password = query( $pdo, $sql, array(":id"=>$_SESSION['user_id']), "fetch" );
		$password = $password['password'];
		//значеия полей формы
		// $old_password = $_POST['old_password'];
		$old_password = hash('sha256',$_POST['old_password']);
		$new_password = $_POST['new_password'];
		$confirm = $_POST['confirm'];
		//проверка заполнености всех прлей
		if ($old_password == "" || $new_password == "" || $confirm == "") {
			header("Location: .?error_message=не все поля заполнены&new_password=$new_password&confirm=$confirm");
			exit;
		}
		//проверка старого пароля
		if ($password !== $old_password) {
			header("Location: .?error_message=старый пароль указан неверно&new_password=$new_password&confirm=$confirm");
			exit;
		}
		//проверка формата пороля
		if (!preg_match('/^[\S]{6,20}$/',$new_password)) {
			header("Location: .?error_message=пароль должен состоять минимум из 6 символов, максимум из 20&new_password=$new_password&confirm=$confirm");
			exit;
		}
		//проверка подтверждения пароля
		if ($new_password !== $confirm) {
			header("Location: .?error_message=пароли не совпадают&new_password=$new_password&confirm=$confirm");
			exit;
		}
		//изменение пароля в базе данных
		$new_password = hash('sha256',$new_password);
  		$sql = "UPDATE users SET password=:password WHERE userId=".$_SESSION['user_id'];
		query( $pdo, $sql, array(":password"=>$new_password), null );

		header("Location: .?message_edit=пароль изменен");
		exit;
	}
	//ИЗМЕНЕНИЯ ПАРОЛЯ






	//ЗАПРОС КОЛЛИЧЕСТВА НЕПРОЧИТАННЫХ СООБЩЕНИЙ
	// $sql="	SELECT * FROM message 
	// 		INNER JOIN chat_message ON textId=message_id 
	// 		INNER JOIN chat ON chat_id=chatId  
	// 		WHERE user=:user AND view=0 AND NOT user_id=:user_id";
	// $message_count = query( $pdo, $sql, array(":user"=>$_SESSION['user_id'],":user_id"=>$_SESSION['user_id']), "fetchAll" );
	//ЗАПРОС КОЛЛИЧЕСТВА НЕПРОЧИТАННЫХ СООБЩЕНИЙ
	message_count($pdo);






	

	$nav = "settings";
	include $_SERVER['DOCUMENT_ROOT']."/html/settings.php";
?>