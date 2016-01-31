<?php 
include '../lib/includes.php';

if (isset($_FILES['image'])) {
	checkCsrf();

	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))){
		
		// Le format du fichier est correct
		$user = $_SESSION['Auth'];
		$user_id = $db->quote($user['id']);
		$db->query("INSERT INTO images SET user_id=$user_id");
		$image_id = $db->lastInsertId();
		
		$image_name = $user['username'].'_'. $image_id . '.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES .'/'. $image_name);
		$image_name = $db->quote($image_name);
		$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
	}
	header('Location:'.WEBROOT.'admin/my_creations.php');
	die();
}

?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
			<div>
				<input type="file" name="image">
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

<?php include '../partials/footer.php'; ?>