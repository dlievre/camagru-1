<?php
$auth = 0;
include 'lib/includes.php';
if (isset($_POST['username']) && isset($_POST['q']) && isset($_POST['password'])){

	$username = $db->quote($_POST['username']);
	$select = $db->query("SELECT * FROM users WHERE username=$username");
	if ($select->rowCount() == 0) {

		// No User Found
		setFlash('a problem happend ici', 'error');
	
	} else {

		// User Found
		$user = $select->fetch();
		$salt = 'r9P+*p3CBT^qP^t@Y1|{~g9F[jOL)3_qlj>O)vPXymMyGiPQW(:aYkk^x?I63/.y';

		$p = hash('sha512', $salt.$user['email']);

		echo 'p '. $p;
		echo 'q '. $_POST['q'];

		if ($p == $_POST['q']) {

			// hash Email and link matches
			$password = $db->quote($_POST['password']);
			$db->query("UPDATE users SET password=$password WHERE username=$username");
			mail( $_POST['email'] , "new count" , $_POST['username'].", your password was successefully changed. lets start !!" );
			header('Location:'.WEBROOT.'login.php');  

		} else {

			// hash Email and link doesn't match
			setFlash('a problem happend la', 'error');
		
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
		<label for="password">New Password</label>
		<input type="password" id="password" name="password">
	</div>
	<input type="hidden" name="q" value='<?php if (isset($_GET["q"])) { echo $_GET["q"];} ?>' />
	<button type="submit">Reset</button>
</form>
<?php include 'partials/footer.php'; 

