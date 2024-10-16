<?php
	
if (settings) {
	$_SESSION['dir'] = "settings";
	header("Location: ");
} else if (search) {
	$_SESSION['dir'] = "search";
	header("Location: ");
} else if (contact) {
	$_SESSION['dir'] = "contact";
	header("Location: ");
} else if (chats) {
	$_SESSION['dir'] = "chats";
	header("Location: ");
} else if (logout) {
	$_SESSION['dir'] = "logout";
	header("Location: ");
} else {
	$_SESSION['dir'] = "chats";
	header("Location: ");
}