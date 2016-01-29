<?php 
include '../lib/includes.php';
include '../partials/admin_header.php';

$select = $db->query('SELECT id, name FROM images');
$categories = $select->fetchAll();

//TODO recuperer toute les images associer 

?>
	<h1> admin </h1>



	
<?php
include '../partials/footer.php';
?>