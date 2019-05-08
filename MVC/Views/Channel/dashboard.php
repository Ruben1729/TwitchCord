<?php
$auth = $data['auth'];
$description;
$path;
$followers;
$groups;

//Permission Binary Stuff
$MOD_FLAG = 1 << 2;

if (count($data) > 1) {
	$description = $data['description'];
	$path = $data['path'];
	$followers = $data['followers'];
	$groups = $data['groups'];
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
	<main <?php if (array_key_exists('reload', $data)) echo "class=\"mainError\"" ?> id="main-form">
		<?php if ($auth == true) { ?>
			<form class="left-container" action="Moderation" method="post">
				<h1>Follower list</h1>
				<ul class="list">
					<?php foreach ($followers as $key => $value) : ?>
						<div class="follower">
							<p><?= $value->username ?></p>
							<button type="submit" name="type" value="{&quot;type&quot;:1,&quot;user_id&quot;:<?= $value->user_id ?>,&quot;channel_id&quot;:<?= $value->channel_id ?>}">Kick</button>
							<button type="submit" name="type" value="{&quot;type&quot;:2,&quot;user_id&quot;:<?= $value->user_id ?>,&quot;channel_id&quot;:<?= $value->channel_id ?>}">Ban</button>
							<?php if (($value->permission_binary & $MOD_FLAG) == 0) { ?>
								<button type="submit" name="type" value="{&quot;type&quot;:3,&quot;user_id&quot;:<?= $value->user_id ?>,&quot;channel_id&quot;:<?= $value->channel_id ?>,&quot;permission_binary&quot;:<?= $value->permission_binary ?>}">Mod</button>
							<?php } ?>
						</div>
					<?php endforeach; ?>
				</ul>
			</form>
		<?php } ?>
		<form <?php if ($auth == true) echo "class=\"right-container\"" ?> enctype="multipart/form-data" action="dashboard" method="post">
			<h1>Channel Dashboard</h1>

			<div class="not-authorized" <?php if ($auth == true) echo "id=\"hidden\""; ?>>
				<a href="/Channel/Create"><button type="button">Create A Channel</button></a>
			</div>

			<div class="authorized" <?php if ($auth == false) echo "id=\"hidden\""; ?>>
				<div class="input-container">
					<label for="pic-id">Channel Picture</label>
					<input type="file" id="file" name="userImg" onchange="readURL(this);" class="visually-hidden">
					<img id="pic-id" src="<?php if ($path !== null) echo "$path";
											else echo "/Pictures/default.png"; ?>" alt="Profile Pic">
				</div>
				<div class="input-container">
					<label for="desc">Channel Description</label>
					<textarea class="paragraph-container" type="text" name="desc"><?php if (isset($description)) echo "$description"; ?></textarea>
				</div>
				<button type="submit" name="save-btn">Save Changes</button>
				<hr>
			</div>
		</form>
		<?php if ($auth == true) { ?>
			<form class="right-container" action="add_group" method="post">
				<div class="input-container">
					<h1>Group Chats</h1>
					<ul class="list group">
						<?php foreach ($groups as $key => $value) : ?>
							<div class="follower">
								<p><?= $value->name . ' ' . $value->chat_type ?></p>
							</div>
						<?php endforeach; ?>
					</ul>
					<div class="group-input">
						<input type="text" name="group-name" value="" placeholder="group-chat name" required>
						<fieldset>
							<label for="group-text"><input type="radio" id="group-text" name="type" value="text" checked="checked">Text</label>
							<label for="group-voice"><input type="radio" id="group-voice" name="type" value="voice">Voice</label>
						</fieldset>
					</div>
					<button type="submit" name="group-add">Add Group</button>
				</div>
			</form>
		<?php } ?>
	</main>
	<script>
		var elem = document.getElementById("pic-id");
		var fileIn = document.getElementById("file");

		elem.addEventListener("click", function() {
			fileIn.click();
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					$('#pic-id').attr('src', e.target.result)
				};

				reader.readAsDataURL(input.files[0]);
			}
		}

		window.addEventListener("load", function() {

			var reload = <?php
							if (!array_key_exists('reload', $data))
								echo "true";
							else
								echo "false";
							?>;

			if (reload) {

				var elem = document.querySelector("#main-form");
				animateForm(elem);

			}

		})
	</script>
	<style>
		a {
			color: white;
		}

		a:hover {
			text-decoration: none;
		}
	</style>
</body>

</html>