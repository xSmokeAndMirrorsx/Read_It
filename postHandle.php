<?php
session_start();

$dbhandle = new PDO("sqlite:posts.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);

$verb = $_SERVER["REQUEST_METHOD"];

if ($verb === "POST"){

}
else if ($verb === "GET"){
    $postResults=array();
    $postNumber=$_GET["postNum"];
    $prepper = $dbhandle->prepare("SELECT * FROM posts ORDER BY number DESC LIMIT ?, 1");
    $prepper->execute([$postNumber]);
    $stmt = $prepper->fetch();
    //$stmt = $dbhandle->query("SELECT * FROM posts LIMIT 0, 1")->fetch();
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
