<?php
$auth = 0;
include 'lib/includes.php';
include 'partials/header.php';

// $select = $db->query("SELECT works.name, works.id, works.slug, images.name as image_name FROM works LEFT JOIN images ON images.id = works.image_id");
// $works = $select->fetchAll();

?>

	<h1>Camagru</h1>

	<ul>
		<li><a href="<?php echo WEBROOT.'login'; ?>">signin</a></li>
		<li><a href="<?php echo WEBROOT.'newuser'; ?>">creat my camagru</a></li>
		<li><a href="<?php echo WEBROOT.'forget'; ?>">forget my password</a></li>
	</ul>


<?php include 'partials/footer.php'; ?>