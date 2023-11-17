<?php

	session_start();
	unset($_SESSION['admin_sess']);
	echo "<script>window.open('Logsign.php', '_self');</script>";

?>