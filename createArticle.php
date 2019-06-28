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

	// unos podataka u bazu
	if(!empty($_POST['submit'])) {
		$articleText = $_POST['articletext'];
		$userid = $_SESSION['userid']; 
		$image = $_FILES["image"]["name"];
		$artinput = mysqli_real_escape_string($conn, $articleText);

		$sqlInsert = "INSERT INTO articles(articleid, articletext, articledate, uid, image) VALUES (null, '".$artinput."', now(), '".$userid."', '".$image."')";
		$resultInsert = $conn->query($sqlInsert);

		if($resultInsert === true) {
			echo "Vas status je uspesno evidentiran";
		} else {
			echo "Imate gresku u konekciji ".$conn->error;
		}
	}

 // kod za ubacivanje slika ( ubacuje sliku u folder)
    
	  if(isset($_FILES['image'])){
	    $errors = array();
	    $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_tmp = $_FILES['image']['tmp_name'];
	    $file_type = $_FILES['image']['type'];
	    $tmp = explode('.',$_FILES['image']['name']);
	    $file_ext = end($tmp);
	    $extensions = array("jpeg","jpg","png","gif");
	    $uploads_dir ='images/';
	    
	  if(in_array($file_ext,$extensions)=== false){
	    $errors[]="Extension not allowed, please chose a JPEG, JPG, PNG or GIF file.";
	  }
	    
	  if($file_size > 3145728){
	    $errors[]='File size must be excately 3 MB';
	  }
	    
	  if(empty($errors)== true){
	    $img_dir = $uploads_dir.$file_name;
	    
	    move_uploaded_file($file_tmp,$uploads_dir.$file_name);
	    echo "Success";
	    header("Location: listArticles.php");
	  }else{
	    print_r($errors);
	  }
	  }
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Article</title>
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

	<!-- article write form -->
	<div>
		<section>
			<div class="container well">
			<form action="createArticle.php" method="post" enctype="multipart/form-data">
				<div class="row">
			<div class="col-sm-12">
			<pre><textarea type="text" name="articletext" placeholder="What's on your mind?"/></textarea></pre>
			</div>
			</div><br/><br/>
			<div class="col-sm-8">
			<input type="file" name="image" value="select image" required/>
			</div><br/><br/>
			<div class="col-sm-8">
			<input type="submit" value="OBJAVI" name="submit" class="btn btn-success">
			</div>
			</form>

			</div>
		</section>
	</div>
</body>
</html>
