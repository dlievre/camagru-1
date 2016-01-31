<?php
include '../lib/includes.php';
include '../partials/admin_header.php';


if (isset($_POST['cpt_1']) && isset($_POST['alpha'])) {

	// get the content of the captured image from the webcam put it in a tmp img
	list($type, $data) = explode(';', $_POST['cpt_1']);
	list(, $data) = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents( IMAGES .'/tmp1.png', $data);

	// creat image from this temporary 
	$im = imagecreatefrompng(IMAGES .'/tmp1.png');

	// get selected alpha 
	// TODO a real selected alpha
	$alpha = imagecreatefrompng(IMAGES .'/alpha1.png');
	
	// Place the alpha
	// TODO find a real place for the alpha
	$marge_right = 10;
	$marge_bottom = 10;
	$sx = imagesx($alpha);
	$sy = imagesy($alpha);

	// Merge the alpha onto our photo with an opacity of 80%
	imagecopymerge($im, $alpha, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($alpha), imagesy($alpha), 80);

	// Create file name and register the image in database
	$user = $_SESSION['Auth'];
	$user_id = $db->quote($user['id']);
	$db->query("INSERT INTO images SET user_id=$user_id");
	$image_id = $db->lastInsertId();
	$image_name = $user['username'].'_'. $image_id . '.png';

	imagepng($im,  IMAGES .'/'. $image_name);
	// free memory
	imagedestroy($im);

	$image_name = $db->quote($image_name);
	$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
	header('Location:'.WEBROOT.'admin/my_creations.php');
	die();

} else if (isset($_FILES['image'])) {
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
		<canvas style="display: none" id="canvas"></canvas>
		<img id="photo" src="">

		<form action="#" method="post" enctype="multipart/form-data">
			<div>
			<ul>
				<li><input type="radio" name="alpha" value="1">alpha1</li>
				<li><input type="radio" name="alpha" value="2">alpha2</li>
			</ul>
			</div>
			<div>
				<input type="file" name="image">
			</div>
			<div>
				<input id="cpt_1" type="hidden" name="cpt_1">
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

	<script type="text/javascript">
	(function() {

		var streaming		= false,
			video			= document.querySelector('#video'),
			cover			= document.querySelector('#cover'),
			canvas			= document.querySelector('#canvas'),
			photo			= document.querySelector('#photo'),
			startbutton		= document.querySelector('#startbutton'),
			cpt_1			= document.querySelector('#cpt_1'),
			width			= 320,
			height			= 0;

		navigator.getMedia	= ( navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);

		function sleep(milliseconds) {
			var start = new Date().getTime();
				for (var i = 0; i < 1e7; i++) {
					if ((new Date().getTime() - start) > milliseconds){
						break;
				}
			}
		}

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
			cpt_1.setAttribute('value', data);
			console.log(data);
		}


		startbutton.addEventListener('click', function(ev){
			ev.preventDefault();
			takepicture();
			sleep(1000);
			takepicture();
			sleep(1000);
			takepicture();
		}, false);

	})();
	</script>
<?php include '../partials/footer.php'; 
