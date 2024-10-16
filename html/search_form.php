<form class="sitebar-search" method="get" action="">
	<input type="search" name="search" placeholder="<?=$placeholder;?>" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>">
</form>