<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		printf('yes');
		$username = $db->quote($_POST['username']);
		$email = $db->quote($_POST['email']);
		$password = $db->quote(sha1($_POST['password']));

		echo $password;
		//TODO check if user already exist

		$db->query("INSERT INTO users SET username=$username, password=$password, email=$email");

		mail( $email , "new count" , "Welcom to you ".$username.", you successefully regiter to Camagru. lets start" );
		header('Location:'.WEBROOT.'login.php');  
		die();
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

