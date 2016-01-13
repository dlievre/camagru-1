<?php
$auth = 0;
include 'lib/includes.php';
include 'partials/header.php';

$select = $db->query("SELECT works.name, works.id, works.slug, images.name as image_name FROM works LEFT JOIN images ON images.id = works.image_id");
$works = $select->fetchAll();

?>

	<h1>Camagru</h1>

	<div>
	<?php foreach ($works as $k => $work): ?>
			<div>
				<a href="view.php?id=<?php echo $work['id']; ?>">
					<img src="<?php echo WEBROOT . 'img/works/' . $work['image_name']; ?>" alt="">
					<?php echo $work['name']; ?>
				</a>
			</div>
	<?php endforeach ?>	
	</div>


<?php include 'partials/footer.php'; ?>