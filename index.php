<?php
ob_start();
session_start();

$_SESSION['sortOrder'] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>BeeJee - test task</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="scripts/main.js"></script>
	<link href = "styles/main.css" rel = "stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<div class="badge badge-light">
		<?php if ($_SESSION['username'] != 'admin') { ?>
		<a href="login.php" class="a-block login-btn">Login</a>
		<?php } else { echo $_SESSION['username']; ?>
			<a href="logout.php" class="page-item a-block a login-btn alert alert-success"> - Logout</a>
		<?php } ?>
	</div>
	<div class="btn-group-vertical float-right">
		<span class="alert-warning">sort by: </span>
		<button class="page-item btn-block btn sort-username" value="username">username</button>
		<button class="page-item btn-block btn sort-email" value="email">email</button>
		<button class="page-item btn-block btn sort-status" value="status">status</button>
	</div>

	<?php 
		require_once("./tasksViewer.php");
		$tasksViewer = new View();
		$tasksViewer->makeControl();
	?>

	<div class="input-group mb-3 newTask">
		<input type="text" name="username" id="username" class="form-control newTask__username" required minlength="2" maxlength="44" title="В этом поле допускают 2-44 символа" />
		<label class="input-group-text" for="username">username</label>
		<input type="email" name="email" id="email" class="form-control newTask__email" title="В этом поле допускают формат email" required />
		<label class="input-group-text" for="email">email</label>
		<input type="text" name="text" id="text" class="form-control newTask__text" required spellcheck="true" minlength="3" maxlength="1024" title="В этом поле допускают 3-1024 символа"  />
		<label class="input-group-text" for="text">text</label>
		<button class="btn-block btn addTask" value="addTask">Add Task</button>
		<div class="wrongData"></div>
	</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>
</html>