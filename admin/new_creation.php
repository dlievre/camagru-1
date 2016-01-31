<?php 
include '../lib/includes.php';

if (isset($_FILES['image'])) {
	checkCsrf();

	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))){
		
		// Le format du fichier est correct
		$user = $_SESSION['Auth'];
		$user_id = $db->quote($user['id']);
		$db->query("INSERT INTO images SET user_id=$user_id");
		$image_id = $db->lastInsertId();
		
		$image_name = $user['username'].'_'. $image_id . '.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES .'/'. $image_name);
		$image_name = $db->quote($image_name);
		$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
	}
	header('Location:'.WEBROOT.'admin/my_creations.php');
	die();
}

?>
	<div>

		<video id="video"></video>
		<button id="startbutton">Prendre une photo</button>
		<canvas id="canvas"></canvas>

		<form action="#" method="post" enctype="multipart/form-data">
			<div>
				<input type="file" name="image">
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

	<script type="text/javascript">
	(function() {

		var streaming = false,
			video        = document.querySelector('#video'),
			cover        = document.querySelector('#cover'),
			canvas       = document.querySelector('#canvas'),
			photo        = document.querySelector('#photo'),
			startbutton  = document.querySelector('#startbutton'),
			width = 320,
			height = 0;

		navigator.getMedia = ( navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);

		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);

		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		function takepicture() {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
		}

		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);

	})();
	</script>
<?php include '../partials/footer.php'; 
