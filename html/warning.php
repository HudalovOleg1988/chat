<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ СООБЩЕНИЙ ЧАТА -->
<?php if (isset($_GET['clean_warning'])): ?>
	<div class="clean_warning_block">
		<div class="clean_warning">
			<div class="clean_warning_avatar" style="background: url('/avatars/<?=$user['avatar'];?>') no-repeat center center;background-size: cover;"></div>
			<div class="clean_warning_name"><?=$user['name'];?></div>

			<a href="?user=<?=$user['userId'];?>" class="clean_warning_cancel">Cancel</a>
			<a href="?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&";?>clean=<?=$user['userId'];?>" class="clean_warning_clean">Clean chat</a>
		</div>
	</div>
<?php endif ?>
<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ СООБЩЕНИЙ ЧАТА -->

<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ ЧАТА -->
<?php if (isset($_GET['drop_warning'])): ?>
	<div class="clean_warning_block">
		<div class="clean_warning">
			<div class="clean_warning_avatar" style="background: url('/avatars/<?=$user['avatar'];?>') no-repeat center center;background-size: cover;"></div>
			<div class="clean_warning_name"><?=$user['name'];?></div>

			<a href="?user=<?=$user['userId'];?>" class="clean_warning_cancel">Cancel</a>
			<a href="?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&";?>drop=<?=$user['userId'];?>" class="clean_warning_clean">Drop chat</a>
		</div>
	</div>
<?php endif ?>
<!-- ПРЕДУПРЕЖДЕНИЕ У УДАЛЕНИИ ЧАТА -->