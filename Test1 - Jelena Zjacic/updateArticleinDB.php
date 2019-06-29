<?php
session_start();
include('config.php');

if(!empty($_POST['editPost'])) {
$text = $_POST['articletext'];
$articleid = $_POST['articleid'];	

// create connection
$conn = new mysqli(SERVER, USER, PASS, DB);
// check connection
if ($conn->connect_error) {
	die("Connection failed: " .$conn->connect_error);
}

if(!empty($_POST['editPost'])){
			$text = $_POST['articletext'];
			$articleid = $_POST['articleid'];
			$artinput = mysqli_real_escape_string($conn, $text);
			$sqlUpdate = "UPDATE articles
				SET articletext = '".$artinput."'
				WHERE articleid =".$articleid;

$result = $conn->query($sqlUpdate);

if($result) {
    echo "uspesno";
    header("Location: listArticles.php");
} else {
	echo "greska".var_dump($sqlUpdate);
}
}
}
$conn->close();

?>