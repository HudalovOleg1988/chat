<?php
	function message_count($pdo) {
		GLOBAL $message_count;
		$sql="	SELECT * FROM message 
			INNER JOIN chat_message ON textId=message_id 
			INNER JOIN chat ON chat_id=chatId  
			WHERE user=:user AND view=0 AND NOT user_id=:user_id";
		$message_count = query( $pdo, $sql, array(":user"=>$_SESSION['user_id'],":user_id"=>$_SESSION['user_id']), "fetchAll" );
	}
?>