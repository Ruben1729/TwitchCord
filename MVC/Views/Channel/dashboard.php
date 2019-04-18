<?php
	$auth = $data['auth'];
	$description;
	$path;
	if(count($data) > 1){
		$description = $data['description'];
		$path = $data['path'];
	}
?>
<!DOCTYPE html>
<html>
	<header>
		<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="/CSS/Form.css">
		<link rel="stylesheet" href="/CSS/Profile.css">

		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
		<script src="/Javascript/Animations.js"></script>
	</header>
	<body>
		<?php require "../MVC/Views/Shared/verticalNavigation.php" ?>
		<main <?php if(array_key_exists('reload', $data)) echo "class=\"mainError\""?> id="main-form">
			<form enctype="multipart/form-data" action="dashboard" method="post">
				<h1>Channel Dashboard</h1>

				<div class="not-authorized" <?php if($auth == true)echo "id=\"hidden\"";?>>
					<a href="/Channel/Create"><button type="button">Create A Channel</button></a>
				</div>

				<div class="authorized" <?php if($auth == false)echo "id=\"hidden\"";?>>
					<div class="input-container">
						<label for="pic-id">Channel Picture</label>
						<input type="file" id="file" name="userImg" onchange="readURL(this);" class="visually-hidden">
						<img id="pic-id" src="<?php if($path !== null) echo "$path"; else echo "/Pictures/default.png"; ?>" alt="Profile Pic">
					</div>
					<div class="input-container">
						<label for="desc">Channel Description</label>
						<textarea class="paragraph-container" type="text" name="desc"><?php if(isset($description)) echo "$description"; ?></textarea>
					</div>
					<button type="submit" name="save-btn">Save Changes</button>
				</div>

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
		<style>
			a{
				color: white;
			}
			a:hover{
				text-decoration: none;
			}
		</style>
	</body>
</html>