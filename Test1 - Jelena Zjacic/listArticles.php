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
<link rel="stylesheet" type="text/css" href="style.css">
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
			$username = $_SESSION['user'];
			$userid = $_SESSION['userid'];
			
			$sql1 = "SELECT  articles.articleid,
							articles.articletext,
							articles.articledate,
							articles.articleid,
							articles.uid,
							articles.image,
							users.userid,
							users.username
							FROM articles INNER JOIN users 
							ON articles.uid = users.userid
							ORDER BY articles.articleid DESC";
			$res = $conn->query($sql1);
			//$artrows = [];
			if($res->num_rows > 0) {
				while($row = $res->fetch_assoc()) {
					$artid = $row['articleid'];
					$user = $row['username'];
					$image = $row['image'];
					$text = $row['articletext'];
					$date = $row['articledate'];
					$rowid = $row['userid'];
					$uid = $row['uid'];
// show edit/delete button for logged in users articles				
if($userid == $uid) {			
echo
<<<HTML
<div class="container">
	<div class = "row">
		<div class="col-sm-3"><img src="images/{$image}" class="img-responsive thumbnail">
		</div>
		
		<div class="col-sm-9"><h3><small>Writen by </small><a href="listuserarticles.php?username={$user}&uid={$uid}">$user</a></h3>
			<p><i> $date</i> </p>
			<p class="linesOfText">$text</p>
		</div>
	<div>
		<button><a class="btn" href="singleArticle.php?articleid={$artid}&username={$user}">Read more...</a></button>
		<button name="artedit"><a href="updateArticle.php?articleid={$artid}&username={$user}&articletext={$text}" class="glyphicon glyphicon-pencil"></a></button>
		<button onclick="alert('This article will be deleted.')"><a href="deleteArticle.php?articleid={$artid}&username={$user}" class="glyphicon glyphicon-trash"></a></button>
		
		<hr/>
	</div>
	</div>
</div>
HTML;
// don't show edit/delete buttons if it's not logged in user
}else{
echo
<<<HTML
<div class="container">
	<div class = "row">
		<div class="col-sm-3"><img src="images/{$image}" class="img-responsive thumbnail">
		</div>
		
		<div class="col-sm-9"><h3><small>Writen by </small><a href="listuserarticles.php?username={$user}">$user</a></h3>
			<p><i> $date</i> </p>
			<p class="linesOfText">$text</p>
		</div>
	<div>
		<button><a class="btn" href="singleArticle.php?articleid={$artid}&username={$user}">Read more...</a></button>		
		<hr/>
	</div>
	</div>
</div>
HTML;
}
}
}
?>
</body>
</html>