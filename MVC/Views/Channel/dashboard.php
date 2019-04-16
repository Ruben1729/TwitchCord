<?php
	
	$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
	$auth = true;
	if(empty($userChannel)){
		$auth = false;
	} else {
		if(array_key_exists('description', $data)){
		$description = $data['description'];
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<header>
		<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="/CSS/Form.css">
		<link rel="stylesheet" href="/CSS/Profile.css">

		<link rel="stylesheet" href="/CSS/Dashboard.css">

		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
		<script src="/Javascript/Animations.js"></script>
	</header>
	<body>
		<?php require "../MVC/Views/Shared/verticalNavigation.php" ?>
		<main id="main-form">
			<form enctype="multipart/form-data" action="create" method="post">
				<h1>Channel Dashboard</h1>

				<div class="right input-container">
					<label for="pic-id">Upload Picture</label>
					<input type="file" id="file" name="userImg" onchange="readURL(this);" class="visually-hidden">
					<img id="pic-id" src="/Pictures/default.png" alt="Profile Pic">
				</div>
				
				<div class="right input-container">
					<label for="bio">Channel Bio</label>
					<textarea class="paragraph-container" type="text" name="bio"><?php if(isset($description))echo $description ?></textarea>
				</div>

				<div class="left input-container">
					<label>Followers</label>
					<div class="display-followers">
					</div>
				</div>
				
				<button type="submit" name="save-btn">Save Changes</button>
			</form>
		</main>
		<script>

			var elem = document.getElementById("pic-id");
			var fileIn = document.getElementById("file");

			elem.addEventListener("click", function(){
				fileIn.click();
			});

			function readURL(input) {
		        if (input.files && input.files[0]) {
		            var reader = new FileReader();

		            reader.onload = function (e) {
		                $('#pic-id').attr('src', e.target.result)
		            };

		            reader.readAsDataURL(input.files[0]);
		        }
		    }

			window.addEventListener("load", function() {

				var reload = <?php 
				if(!array_key_exists('reload', $data))
					echo "true";
				else
					echo "false";
				?>;

				if(reload){

					var elem = document.querySelector("#main-form");
					animateForm(elem);

				}

			})
		</script>
	</body>
</html>