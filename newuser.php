<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$username = $db->quote($_POST['username']);
		$email = $db->quote($_POST['email']);
		$password = $db->quote(sha1($_POST['password']));


		$select = $db->query("SELECT * FROM users WHERE username=$username");
		if ($select->rowCount() == 0) {
			$db->query("INSERT INTO users SET username=$username, password=$password, email=$email");

			mail( $_POST['email'] , "new count" , "Welcom to you ".$_POST['username'].", you successefully regiter to Camagru. lets start !!" );
			header('Location:'.WEBROOT.'login.php');  
		} else {
			setFlash('username already existe', 'error');
		}
	}
}
include 'partials/header.php';
?>

<form action="#" method="post">
	<div>
		<label for="username">Nom d'utilisateur</label>
		<?php echo input('username'); ?>
	</div>
	<div>
		<label for="email">Email</label>
		<?php echo input('email'); ?>
	</div>
	<div>
		<label for="password">Password</label>
		<input type="password" id="password" name="password">
	</div>
	<button type="submit">Se connecter</button>
</form>
<?php include 'partials/footer.php'; 

