
<!DOCTYPE html>
<html>
<head>
	<title>Camagru 42</title>
	<link rel="stylesheet" href="../stylesheets/style.css">
</head>
<body>
	<h1>Bienvenu, <?php echo $_SESSION['Auth']['username'] ?></h1>
	<div class="navigation">
		<ul>
			<li><a href="<?php echo WEBROOT ?>admin/">HOME</a></li>
			<li><a href="<?php echo WEBROOT ?>logout.php">Log out</a></li>
		</ul>
		<ul>
			<li><a href="all_creations.php"> View all creations</a></li>
			<li><a href="my_creations.php"> View my creations</a></li>
			<li><a href="new_creation.php"> Create new creation</a></li>
		</ul>
	</div>	
	<?php echo flash();