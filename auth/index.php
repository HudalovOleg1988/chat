<?php
	session_start();
	if(isset($_SESSION['login']) && $_SESSION['login'])
	{
		header("Location: /chats/");
		exit;
	}

	include $_SERVER['DOCUMENT_ROOT']. "/core/db.php";
	include $_SERVER['DOCUMENT_ROOT']. "/core/query.php";

	//проверка пост запроса на регистрацию
	if (isset($_POST['siginup'])) 
	{
		// заношу пост значения в переменные
		$name 		= $_POST['name'];
		$nic 		= $_POST['nic'];
		$email 		= $_POST['email'];
		$password 	= $_POST['password'];
		$confirm 	= $_POST['confirm'];
		
		//указываю переменные для редиректа
		$location_value = "name=$name&nic=$nic&email=$email&password=$password&confirm=$confirm&error_siginup=";

		//проверка заполнености всех полей
		if ($name=="" || $nic=="" || $email=="" || $password=="" || $confirm=="")
		{
			$error = "не все поля заполнены";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка длины имени
		if (!preg_match('/^[\s\S]{1,20}$/',$name))
		{
			$error = "имя не должно быть длинее 20 символов";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка формата ник
		if (!preg_match('/^[a-zA_Z0-9.-]{1,20}$/',$nic))
		{
			$error = "nic должен быть не более 20 символов и состоять только из латиницы, цифр,.-";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка уникальности ник
  		$sql = "SELECT * FROM users WHERE nic = :nic";
		$unique_nic = query( $pdo, $sql, array(":nic"=>$nic), "fetch" );

		if (!empty($unique_nic['nic']))
		{
			$error = "данный ник уже занят";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка формата адреса почты
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$email))
		{
			$error = "некорректный формат электронной почты";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка уникальности адреса почты
  		$sql = "SELECT * FROM users WHERE email = :email";
		$unique_email = query( $pdo, $sql, array(":email"=>$email), "fetch" );

		if (!empty($unique_email['email']))
		{
			$error = "данный email уже занят";
			header("Location: .?$location_value $error");
			exit;
		}

		// проверка формата пароля
		if (!preg_match('/^[\S]{6,20}$/',$password))
		{
			$error = "пароль должен состоять минимум из 6 символов, максимум из 20";
			header("Location: .?$location_value $error");
			exit;
		}

		//проверка совпадения плдтверждения пароля
		if ($password !== $confirm)
		{
			$error = "пароли не совпадают";
			header("Location: .?$location_value $error");
			exit;
		}
  		$password = hash('sha256', $password);
  		
		//производим решистрацию
		$sql = "INSERT INTO users SET name=:name, nic=:nic, email=:email, password=:password, usersdate=now()";
		query( $pdo, $sql, array(":name"=>$name,":nic"=>$nic,":email"=>$email,":password"=>$password), null );

		header("Location: .?message=можете авторизироваться");
		exit;
	}

	//проверка пост запроса на авторизацию
	if (isset($_POST['siginin']))
	{
		$login = $_POST['login'];
		$password = hash('sha256',$_POST['password']);

		//запрос инфы о пользователе
  		$sql = "SELECT * FROM users WHERE password=:password AND email=:login OR nic=:login";
		$user = query( $pdo, $sql, array(":login"=>$login,":password"=>$password), "fetch" );

		//запрос контактов пользователя
		$sql = "SELECT contact FROM user_contact WHERE user_id=:user_id";
		$contacts = query( $pdo, $sql, array(":user_id"=>$user['userId']), "fetchAll" );
		$_SESSION['contacts'] = array();

		for ($i=0; $i < COUNT($contacts); $i++) { 
			$_SESSION['contacts'][$i] = $contacts[$i]['contact'];
		}


		if (empty($user))
		{
			header("Location: .?error_login=неверный логин или пароль&login=$login");
			exit;
		}
		else
		{
			$_SESSION['login'] = TRUE;
			$_SESSION['name'] = $user['name'];
			$_SESSION['nic'] = $user['nic'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['user_id'] = $user['userId'];
			$_SESSION['avatar'] = $user['avatar'];
			header("Location: /");
			exit;
		}
	}
	
	include $_SERVER['DOCUMENT_ROOT']. "/html/auth.php";
?>