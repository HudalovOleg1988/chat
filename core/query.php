<?php
	include $_SERVER['DOCUMENT_ROOT']. "/core/db.php";
	
	function query($pdo,$sql,$values=null,$select=null)
	{
		try {
			$s = $pdo->prepare($sql);

			if ($values)
			{
				foreach ($values as $key => $value)
				{
					$s->bindValue("$key",$value);
				}
			}
			$s->execute();
		} catch (PDOException $e) {
	  		// header("Location: /error/");

			echo $e->getMessage();
		  	exit;
		}

		if ($select)
		{
			if ($select == "fetch")
			{
				return $s->fetch();
			} 
			else
			{
				return $s->fetchAll();
			}
		}

	}
?>