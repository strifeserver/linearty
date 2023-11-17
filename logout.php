<?php

	session_start();
	unset($_SESSION['admin_sess']);
	echo "<script>window.open('Home.php', '_self');</script>";

?>