<!DOCTYPE html>

 <?php
	include("config.php")
?>
<?php
	session_start();
	$username = !empty($_POST["username"]);
	$password = !empty($_POST["password"]);

	if($username && $password) {
		$conn = mysqli_connect(SERVER, USER, PASS, DB);

		$sql = sprintf("SELECT * FROM users WHERE username='%s'", mysqli_real_escape_string($conn, $_POST['username']));

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		$_SESSION['user'] = $row['username'];
		$_SESSION['pass'] = $row['password'];
		$_SESSION['userid'] = $row['userid'];

		if ($row) {

			if ($_POST['username'] == $_SESSION['user'] && $_POST['password'] == $_SESSION['pass'])  {
				header("Location: article.php");
			}

		}
	}
?>
<html>

<head>
	<title>Log In</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="login">
		<h1>LOG IN</h1>
		<form action="index.php" method="post">
		<input type="text" name="username" placeholder="Enter username"><br/>
		<input type="password" name="password" placeholder="Enter password"><br/>
		<input type="submit" class="submit" value="LOG IN">
		</form>
	</div>
</body>

</html>