<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chats</title>
	<link rel="stylesheet" href="/css/chats.css">
</head>
<body>
	<div class="main">

		<div class="sitebar">

			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/html/nav.php";?>
			<!-- ПОДКЛЮЧЕНИЕ НАВИГАЦИИ -->

			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->
			<?php include $_SERVER['DOCUMENT_ROOT']. "/html/search_form.php";?>
			<!-- ПОДКЛЮЧЕНИЕ ФОРМЫ ПОИСКА -->

			<?php if (!empty($users)): ?>
				<?php foreach ($users as $user_item): ?>
						<a href="?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&";?>user=<?=$user_item['userId'];?>" class="sitebar_user">
							<div class="sitebar_user_avatar" style="background: url('/avatars/<?=$user_item['avatar'];?>') no-repeat center center; background-size: cover;">
							</div>
							<div class="sitebar-user-name"><?=$user_item['name'];?></div>
							<div class="sitebar-user-nic"><?=$user_item['nic'];?></div>
							<div class="sitebar-user-nic"><?=$user_item['email'];?></div>
						</a>
				<?php endforeach ?>
			<?php endif ?>

		</div>

		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/html/chat.php";?>
		<!-- ПОДКЛЮЧЕНИЕ ЧАТА -->

		<!-- ПОДКЛЮЧЕНИЕ WARNING -->
		<?php include $_SERVER['DOCUMENT_ROOT']. "/html/warning.php";?>
		<!-- ПОДКЛЮЧЕНИЕ WARNING -->
		
	</div>
</body>
</html>