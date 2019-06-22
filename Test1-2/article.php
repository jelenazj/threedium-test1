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

		$sqlInsert = "INSERT INTO articles(articleid, articletext, articledate, userid, image) VALUES (null, '".$articleText."', now(), '".$userid."', '".$image."')";
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
	  }else{
	    print_r($errors);
	  }
	  }
?>
<html>
<head>
	<title>Article</title>
</head>
<body>
	<header>
		<p><?php echo("Welcome ".$_SESSION['user']); ?></p>
	<a href = "logout.php"><button>LOG OUT</button></a>
	</header>

	<!-- article write form -->
	<div>
		<section>
			<form action="article.php" method="post" enctype="multipart/form-data">
			<input type="text" name="articletext" placeholder="What's on your mind?"/>
			<input type="file" name="image" value="select image" required/>
			<input type="submit" value="OBJAVI" name="submit">
			</form>
		</section>
	</div>

	<!-- publish article -->
	<div>
		<?php 
			$userid = $_SESSION['userid'];
			$sql1 = "SELECT  articles.articleid,
							articles.articletext,
							articles.articledate,
							articles.image,
							users.userid,
							users.username
							FROM articles INNER JOIN users 
							ON articles.userid = users.userid
							ORDER BY articles.articleid DESC";
			$res = $conn->query($sql1);
			//$postrows = [];
			if($res->num_rows > 0) {
				while($row = $res->fetch_assoc()) {
					//$postrows[] = $row;
					$user = $row['username'];
					$text = $row['articletext'];
					$date = $row['articledate'];
echo
<<<HTML
<div>
	<div>
		<p>$user</p>
		<p>$text</p>
		<p>$date</p>
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