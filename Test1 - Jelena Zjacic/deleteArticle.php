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

 
			$userid = $_SESSION['userid'];
			$getartid = $_GET['articleid'];
			$user = $_GET['username'];
			$sqldelete = "DELETE FROM articles WHERE articles.articleid = '".$getartid."'
					 AND articles.uid = '".$userid."';";
			
			$resultdelete = $conn->query($sqldelete);
			if($resultdelete === true) {
				$message = "Success";
				$message = "Connection error ".$conn->error;
				header('Location: listArticles.php');
			}/*
echo
<<<HTML
<div>
	<div class = "container">
		<div class="col-sm-3"><img src="images/{$image}" class="img-responsive thumbnail"></div>
		<div class="col-sm-9"><h3><small>Writen by </small>$user</h3>
		<p><i> $date</i> </p>
		<p>$text</p>
		<button><span class="glyphicon glyphicon-trash"></span></button>
		</div>
	</div>
</div>
HTML;

}else {
	$message = "No data";
}*/
?>
