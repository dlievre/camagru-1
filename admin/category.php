<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

// DELETE A CATEGORY
if (isset($_GET['delete'])) {
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM categories WHERE id=$id");
	setflash('La categorie a bien été supprimée');
	header('Location:'.WEBROOT.'admin/category.php');
	die();
}

// GET CATEGORIES
$select = $db->query('SELECT id, name, slug FROM categories');
$categories = $select->fetchAll();

?>

	<h1> Categories </h1>

	<p><a href="category_edit.php">Ajouter une catégorie</a></p>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $category) : ?>
				<tr>
					<td><?php echo $category['id'];?></td>
					<td><?php echo $category['name'];?></td>
					<td>
						<a href="category_edit.php?id=<?php echo $category['id'];?>">Editer</a>
						<a href="?delete=<?php echo $category['id'].'&'.csrf();?>" onclick="return('Sur sur sur ?')">Supprimer</a>
					</td>
				</tr>
			 <?php  endforeach; ?>
		</tbody>
	</table>


<?php include '../partials/footer.php'; ?>