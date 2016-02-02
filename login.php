<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['password'])){
	$username = $db->quote($_POST['username']);
	print($username);
	$password = sha1($_POST['password']);
	print($password);
	$sql = "SELECT * FROM users WHERE username=$username AND password='$password'";
	$select = $db->query($sql);
	if ($select->rowCount() > 0){
		$_SESSION['Auth'] = $select->fetch();
		setFlash('Vous êtes connecté');
		header('Location:'.WEBROOT.'admin/index.php');  
		die();
	}
}
include 'partials/header.php';
?>
	<div class="connection">
		<h1 class="title"><a href="">CAMAGRU</a></h1>
		<form action="#" method="post">
			<div class="formulaire username">
				<!-- <input type="text" placeholder="username"> -->
				<?php echo input('username'); ?>
			</div>
			<div class="formulaire password">
				<input type="password" palceholder="password">
			</div>
			<div class="formulaire submit">
				<input type="submit" value="Se connecter">
			</div>
		</form>
	</div>
<!-- 
<form action="#" method="post">
	<div>
		<label for="username">Nom d'utilisateur</label>
		<?php echo input('username'); ?>
	</div>
	<div>
		<label for="password">Password</label>
		<input type="password" id="password" name="password">
	</div>
	<button type="submit">Se connecter</button>
</form> -->
<?php include 'partials/footer.php'; 

