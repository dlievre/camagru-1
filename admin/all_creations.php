<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

// DELETE A IMAGE
$user = $_SESSION['Auth'];
if (isset($_GET['delete'])) {

	// jeton de securité
	checkCsrf();

	// recuperer l'image a supprimer
	$id = $db->quote($_GET['delete']);
	$select = $db->query("SELECT name, user_id FROM images WHERE id=$id");	
	$image = $select->fetch();

	if ($image['user_id'] == $user['id']) {
	
		// l'image est bien celle de l'utilisateur connecter
		// suppression du fichier
		unlink(IMAGES . '/works/' . $image['name']);
		// supression en bdd
		$db->query("DELETE FROM images WHERE id=$id");

		// message de confirmation
		setflash('La categorie a bien été supprimée');
		header('Location:'.WEBROOT.'admin/work.php');
		die();
	}
}

// GET MY IMAGES
$user_id = $db->quote($user['id']);
$select = $db->query("SELECT * FROM images ORDER BY pub_date DESC");
$images = $select->fetchAll();

?>

	<h1> works </h1>

	<p><a href="new_creation.php">Ajouter un montage</a></p>

	<ul>
		<?php foreach ($images as $image) : ?>
			<li><?php echo $image['name']; ?></li>
		 <?php  endforeach; ?>
	</ul>
		

<?php include '../partials/footer.php'; ?>