<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	if (isset($_POST['submit'])) {

	} else {
		// This is probably a GET request
		redirect_to("new_subject.php");
	}
?>
<?php 
	if (isset($connection)) { mysqli_close($connection); }
?>
