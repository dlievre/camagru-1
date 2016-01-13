<?php
$auth = 0;
include 'lib/includes.php';
include 'partials/header.php';

if (!isset($_GET['id'])){
	header("HTTP/1.1 301 Moved Permanently");
	header('location:index.php');
	die();
}
$work_id = $db->quote($_GET['id']);
$select = $db->query("SELECT * FROM works WHERE id=$work_id");
if ($select->rowCount() == 0){
	header("HTTP/1.1 301 Moved Permanently");
	header('location:index.php');
	die();
}
$work = $select->fetch();

$select = $db->query("SELECT * FROM images WHERE work_id=$work_id");
$images = $select->fetchAll();
?>

	<h1><?php echo $work['name']; ?></h1>

	<div>
		<?php echo $work['content']; ?>
	</div>
	<?php foreach ($images as $k => $image): ?>
			<div>
				<img src="<?php echo WEBROOT . 'img/works/' . $image['name']; ?>" alt="">
			</div>
	<?php endforeach ?>	
	</div>


<?php include 'partials/footer.php'; ?>