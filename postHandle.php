<?php
session_start();

$dbhandle = new PDO("sqlite:posts.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);

    $count = 1;
    $binaryVar = decbin($count);
    $receiver = $_GET['receiver'];
    $rack = $receiver;
    $sizeOfRack = strlen($rack);
    $finalRackArray= array();

$verb = $_SERVER["REQUEST_METHOD"];

if ($verb === "POST"){
	$_SESSION["usrName"] = $_POST['receiver_name'];
   	$_SESSION["PostCount"] = $_POST['receiver_name'];
   	$_SESSION["postTime"] = $_POST['receiver_name'];
   	$_SESSION["postLikes"] = $_POST['receiver_name'];
   	$_SESSION["postData"] = $_POST['receiver_name'];
	$sql =<<<EOF
		INSERT INTO Posts (User,PostNumber,Time,Likes,Data) VALUES ($_SESSION["usrName"], $_SESSION["postCount"], $_SESSION["postTime"], $_SESSION["postLikes"], $_SESSION["postData"]);
	EOF;
	$ret = $dbhandle->exec($sql);

}
else if ($verb === "GET"){
    $postResults=array();
    $stmt = $dbhandle->query("SELECT * FROM posts LIMIT 0, 1")->fetch();
    if($stmt == array()){}
    else{
	array_push($postResults,$stmt['number']);
	array_push($postResults,$stmt['user']);
	array_push($postResults,$stmt['data']);
	header('HTTP/1.1 200 OK');
    	header('Content-Type: application/json');
	echo json_encode($postResults);
    }
}
?>
