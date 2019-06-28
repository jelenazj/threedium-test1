<!DOCTYPE html>
<?php
	session_start();
	 	include("config.php");

	 	if(empty($_SESSION['user'])) {
		header("Location: index.php");
	} else {
		//echo("Welcome ".$_SESSION['user']);
	}

	$username = $_SESSION['user'];
		// create connestion
	$conn = new mysqli(SERVER, USER, PASS, DB);
		// check connection
	if($conn->connect_error) {
		die("connection failed: ".$conn->connect_error);
	}
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<header>
		<div class="container"> 
			<div class="col-sm-9">
				<p><?php echo("Welcome ".$_SESSION['user']); ?></p>
				<a href="listArticles.php">All Articles</a>
				<a href="createArticle.php">Create Article</a>
			</div>
			<div class="col-sm-3">
				<a href = "logout.php"><button>LOG OUT</button></a>
			</div>
		</div>
	</header>
	<!-- publish article -->
	<div>
		<?php 
		

			$userid = $_SESSION['userid'];
			$getartid = $_GET['articleid'];
			$user = $_GET['username'];
			$sql1 = "SELECT	* FROM articles INNER JOIN users
					 WHERE articles.articleid = '".$getartid."'
					 AND username = '".$user."'";
			$res = $conn->query($sql1);
			//$postrows = [];
			if($res->num_rows > 0) {
				while($row = $res->fetch_assoc()) {
					//$postrows[] = $row;
					$articleid = $row['articleid'];
					$user = $row['username'];
					$image = $row['image'];
					$text = $row['articletext'];
					$date = $row['articledate'];
			if(!empty($_POST['editPost'])){
			$articletext = $_POST['text'];
			$sql = "UPDATE articles
				SET articletext = '".$text."'
				WHERE uid = $userid
				AND articleid = '$articleid'";
	}
echo
<<<HTML
<div>
	<div class = "container">
		<div class="col-sm-3"><img src="images/{$image}" class="img-responsive thumbnail"></div>
		
		<div class="col-sm-9"><h3><small>Writen by </small>$user</h3>
		<p><i> $date</i> </p>
		<p>$text</p>
		<form action="updateArticle.php" method="post">
		<input type="hidden" name="articleid" value="{$articleid}">
		<input type="text" name="articletext" value="{$text}">
		<input type="submit" name="editPost">
		</form>
		
		</div>
	</div>
</div>
HTML;
				}
			} else {
				$postsuccessmessage = "No data";
			}

		?>

		
	</div>
</body>
</html>