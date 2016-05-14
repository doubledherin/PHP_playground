<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>
<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo; Main menu<br /></a>
		<?php echo navigation($current_subject, $current_page); ?>
		<br />
		<a href="new_subject.php">+ Add a subject</a>
	</div> 
	<div id="page">
		<?php echo message(); ?>
		<?php if ($current_subject) { ?>
			<h2>Manage Subject</h2>
				Subject name: <?php echo htmlentities($current_subject["menu_name"]); ?><br />
				Position: <?php echo $current_subject["position"]; ?><br />
				Visible: <?php echo $current_subject["visible"] == 1 ? 'yes' : 'no'; ?><br />
				<br />
				<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a><br />
				<br />
				<a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Add Page</a>
			<?php } elseif ($current_page) { ?>
			<h2>Manage Page</h2>
				Page name: <?php echo htmlentities($current_page["menu_name"]); ?><br />
				Position: <?php echo $current_page["position"]; ?><br />
				Visible: <?php echo $current_page["visible"] == 1 ? 'yes' : 'no'; ?><br />
				<br />
				Content:<br />
				<div class="view-content">
				<?php echo htmlentities($current_page["content"]); ?>
				</div>
				<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit Page</a><br />
				<br />
				<a href="new_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Add Page</a>
	 		<?php } else { ?>
	 			<?php echo "Please select a subject or a page."; ?>
 		<?php } ?>
	</div>
</div>
<?php include("../includes/layouts/footer.php"); ?>
	</body>
</html>