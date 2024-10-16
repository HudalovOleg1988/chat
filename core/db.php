<?php
	try
	{
		$pdo = new PDO('mysql:host=localhost;dbname=chat','root','root');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');
	}
	catch (PDOException $e)
	{
		echo "невозможно подключиться к базе данных".$e->getMessage();
		exit();
	}
?>