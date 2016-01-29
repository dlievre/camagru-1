<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

// DELETE A WORK
if (isset($_GET['delete'])) {
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM works WHERE id=$id");
	$select = $db->query("SELECT name FROM images WHERE work_id=$id");
	$image = $select->fetch();
	unlink(IMAGES . '/works/' . $image['name']);
	$db->query("DELETE FROM images WHERE work_id=$id");
	setflash('La categorie a bien été supprimée');
	header('Location:'.WEBROOT.'admin/work.php');
	die();
}

// GET WORKS
$select = $db->query('SELECT id, name, slug FROM works');
$works = $select->fetchAll();

?>

	<h1> works </h1>

	<p><a href="work_edit.php">Ajouter un travail</a></p>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($works as $work) : ?>
				<tr>
					<td><?php echo $work['id'];?></td>
					<td><?php echo $work['name'];?></td>
					<td>
						<a href="work_edit.php?id=<?php echo $work['id'];?>">Editer</a>
						<a href="?delete=<?php echo $work['id'].'&'.csrf();?>" onclick="return('Sur sur sur ?')">Supprimer</a>
					</td>
				</tr>
			 <?php  endforeach; ?>
		</tbody>
	</table>


<?php include '../partials/footer.php'; ?> ?>