<?php
session_start();

$dbhandle = new PDO("sqlite:posts.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);

$verb = $_SERVER["REQUEST_METHOD"];

if ($verb === "POST"){
    $postName = $_POST["postName"];
    $postText = $_POST["postText"];
    $stmt = $dbhandle->query("SELECT * FROM posts ORDER BY number DESC LIMIT 0, 1")->fetch();
    $postNum = ($stmt['number'] + 1);
	
    $qry = $dbhandle->prepare("INSERT INTO posts (user, number, data) VALUES (?, ?, ?)");
    $qry->execute(array(strval($postName), intval($postNum), strval($postText)));
}
else if ($verb === "GET"){
    $postResults=array();
    $postNumber=$_GET["postNum"];
    //$prepper = $dbhandle->prepare("SELECT * FROM posts ORDER BY number DESC LIMIT 0, 5");
    //$prepper->execute([intval($postNumber)]);
    //$stmt = $prepper->fetchAll();
    $stmt = $dbhandle->query("SELECT * FROM posts ORDER BY number DESC LIMIT 0, 5")->fetchAll();
    if($stmt == array()){}
    else{
	foreach ($stmt as $row){
	    array_push($postResults,$row['number']);
	    array_push($postResults,$row['user']);
	    array_push($postResults,$row['data']);
	}
	header('HTTP/1.1 200 OK');
    	header('Content-Type: application/json');
	echo json_encode($postResults);
    }
}
?>
