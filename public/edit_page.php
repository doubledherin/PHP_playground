<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
	if (!$current_page) {
		// subject ID was missing or invalid or 
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)) {
		
		// Perform Update

		$id = $current_page["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		$content = mysql_prep($_POST["content"]);
		$subject = (int) $_POST["subject_id"];
	
		$query  = "UPDATE pages SET ";
		$query .= "menu_name = '{$menu_name}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible}, ";
		$query .= "content = {$content}, ";
		$query .= "subject_id = {$subject} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "Page updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$message = "Page update failed.";
		}
	
	}
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
		<?php echo navigation($current_subject, $current_page); ?>
  </div>
  <div id="page">
		<?php // $message is just a variable, doesn't use the SESSION
			if (!empty($message)) {
				echo "<div class=\"message\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); ?>
		
		<h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
		<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
		  <p>Page name:
		    <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
		  </p>
		  <p>Subject:
		    <input type="text" name="subject_id" value="<?php echo htmlentities($current_page["subject_id"]); ?>" />
		  </p>
		  <p>Position:
		    <select name="position">
				<?php
					$current_subject = find_subject_for_page($current_page["id"]) == true ? 1 : 0;
					$page_set = find_pages_for_subject($current_subject);
					$page_count = mysqli_num_rows($page_set);
					echo $page_count;
					for($count=1; $count <= $page_count; $count++) {
						echo "<option value=\"{$count}\"";
						if ($current_page["position"] == $count) {
							echo " selected";
						}
						echo ">{$count}</option>";
					}
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) { echo "checked"; } ?> /> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) { echo "checked"; } ?>/> Yes
		  </p>
		  <p>Content: 
		  	<input type="text" name="content" value=
		  		<?php if ($current_page["content"]) {
		  			echo htmlentities($current_page["content"]);
	  				} 
  				;?>
  				/>
		  </p>
		  <input type="submit" name="submit" value="Edit Page" />
		</form>
		<br />
		<a href="manage_content.php">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
