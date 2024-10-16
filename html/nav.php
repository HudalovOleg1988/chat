<div class="sitebar-nav">
	<a href="/chats/" <?php if($nav=="chats") echo "class='active'";?>>
		chats 
		<?php echo (!empty($message_count)) ? COUNT($message_count) : '0';?>
	</a>
	<a href="/search/" <?php if($nav=="search") echo "class='active'";?>>search</a>
	<a href="/contact/" <?php if($nav=="contact") echo "class='active'";?>>contact</a>
	<a href="/settings/" <?php if($nav=="settings") echo "class='active'";?>>settings</a>
	<a href="/logout/">logout</a>
</div>