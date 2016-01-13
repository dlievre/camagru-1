<?php 
include '../lib/includes.php';

if (isset($_POST['name']) && isset($_POST['slug'])) {
	checkCsrf();
	$slug = $_POST['slug'];
	if (preg_match('/^[a-z\-0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		$content = $db->quote($_POST['content']);
		$category_id = $db->quote($_POST['category_id']);
		
		// Enregistrement du contenu
		if (isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE works SET name=$name, slug=$slug, content=$content, category_id=$category_id WHERE id=$id");
		}else {
			$db->query("INSERT INTO works SET name=$name, slug=$slug, content=$content, category_id=$category_id");
			$_GET['id'] = $db->lastInsertId();
		}
		setFlash('Categorie correctement souvegardee');

		// Enregistrement des images
		$work_id = $db->quote($_GET['id']);
		$image = $_FILES['image'];
		$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
		if (in_array($extension, array('jpg', 'png'))){
			$db->query("INSERT INTO images SET work_id=$work_id");
			$image_id = $db->lastInsertId();
			$image_name = $image_id . '.' . $extension;
			move_uploaded_file($image['tmp_name'], IMAGES . '/works/' . $image_name);
			$image_name = $db->quote($image_name);
			$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
		}

		header('Location:'.WEBROOT.'admin/work.php');
		die();
	} else {
		setFlash('le slug est invalide', 'error');
	}
}

if (isset($_GET['id'])) {
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM works WHERE id=$id");
	if ($select->rowCount() == 0){
		setFlash('L\'id de la categorie n\'existe pas', 'error');
		header('Location:'.WEBROOT.'admin/work.php');
		die();
	}
	$_POST = $select->fetch();
}

// Récupérer les categories
$select = $db->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories = $select->fetchAll();
$categories_list = array();
foreach ($categories as $category) {
	$categories_list[$category['id']] = $category['name'];
}

// Récupérer les images
if (isset($_GET['id'])) {
	$work_id = $db->quote($_GET['id']);
	$select = $db->query("SELECT id, name FROM images WHERE work_id=$work_id");
	$images = $select->fetchAll();		
} else {
	$images = array();
}

// Supprimer les images
if (isset($_GET['delete_image'])) {
	checkCsrf();
	$id = $db->quote($_GET['delete_image']);
	$select = $db->query("SELECT name, work_id FROM images WHERE id=$id");
	$image = $select->fetch();
	unlink(IMAGES . '/works/' . $image['name']);
	$db->query("DELETE FROM images WHERE id=$id");
	setFlash('L\'image a ete suprime');
	header('Location:'.WEBROOT.'admin/work_edit.php?id='. $image['work_id']);
	die();
}

// mettre une image à la une
if (isset($_GET['highlight_image'])) {
	checkCsrf();
	$work_id = $db->quote($_GET['id']);
	$image_id = $db->quote($_GET['highlight_image']);
	$select = $db->query("UPDATE works SET image_id=$image_id WHERE id=$work_id");
	setFlash('Une nouvelle image est à la une');
	header('Location:'.WEBROOT.'admin/work_edit.php?id='. $_GET['id']);
	die();
}

include '../partials/admin_header.php';
?>

	<h1> Editer une work </h1>
	
	<div>
		<?php foreach ($images as $k => $image): ?>
			<p><img src="<?php echo WEBROOT; ?>img/works/<?php echo $image['name']; ?>" width="100"></p>
			<a href="?delete_image=<?php echo $image['id'];?>&<?php echo csrf();?>" onclick="return confirm('sur sur sur ?');">supprimer</a>
			<a href="?highlight_image=<?php echo $image['id'];?>&id=<?php echo $_GET['id']; ?>&<?php echo csrf();?> ">mettre a la une</a>
		<?php endforeach ?>
	</div>

	<div>
		<form action="#" method="post" enctype="multipart/form-data">
			<div>
				<label for="name">Nom de la work</label>
				<?php echo input('name'); ?>
			</div>
			<div>
				<label for="slug">slug de la work</label>
				<?php echo input('slug'); ?>
			</div>
			<div>
				<label for="content">Contenu de la work</label>
				<?php echo textarea('content'); ?>
			</div>
			<div>
				<label for="category_id">Nom de la Categorie</label>
				<?php echo select('category_id', $categories_list); ?>
			</div>
			<div>
				<input type="file" name="image">
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

<?php include '../partials/footer.php'; ?>