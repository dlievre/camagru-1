<?php 
include '../lib/includes.php';

if (isset($_POST['name']) && isset($_POST['slug'])) {
	checkCsrf();
	$slug = $_POST['slug'];
	if (preg_match('/^[a-z\-0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		if (isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE categories SET name=$name, slug=$slug WHERE id=$id");
		}else {
			$db->query("INSERT INTO categories SET name=$name, slug=$slug");
		}
		setFlash('Categorie correctement souvegardee');
		header('Location:'.WEBROOT.'admin/category.php');
		die();
	} else {
		setFlash('le slug est invalide', 'error');
	}
}

if (isset($_GET['id'])) {
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM categories WHERE id=$id");
	if ($select->rowCount() == 0){
		setFlash('L\'id de la categorie n\'existe pas', 'error');
		header('Location:'.WEBROOT.'admin/category.php');
		die();
	}
	$_POST = $select->fetch();
}

include '../partials/admin_header.php';
?>

	<h1> Editer une categorie </h1>

	<form action="#" method="post">
		<div>
			<label for="name">Nom de la categorie</label>
			<?php echo input('name'); ?>
		</div>
		<div>
			<label for="slug">slug de la categorie</label>
			<?php echo input('slug'); ?>
		</div>
		<?php echo csrfInput(); ?>
		<button type="submit">Envoyer</button>
	</form>


<?php include '../partials/footer.php'; ?>