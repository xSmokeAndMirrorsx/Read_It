<?php
session_start();

$dbhandle = new PDO("sqlite:posts.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);

$verb = $_SERVER["REQUEST_METHOD"];

if ($verb === "POST"){
    $postName = $_POST["postName"];
    console.log($postName);
    $postText = $_POST["postText"];
    console.log($postText);
    $stmt = $dbhandle->query("SELECT * FROM posts ORDER BY number DESC LIMIT 0, 1")->fetch();
    $postNum = ($stmt['number'] + 1);
    console.log($postNum);
	
    $qry = $dbhandle->prepare("INSERT INTO posts (user, number, likes, data) VALUES (?, ?, 0, ?)");
    $qry->bindParam(1, $postName);
    $qry->bindParam(2, $postNum);
    $qry->bindParam(3, $postText);
    $qry->execute();
    console.log("Insert Attempted");
    //$qry->execute(array(strval($postName), intval($postNum), strval($postText)));
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
	    array_push($postResults,$row['likes']);
	    array_push($postResults,$row['data']);
	}
	header('HTTP/1.1 200 OK');
    	header('Content-Type: application/json');
	echo json_encode($postResults);
    }
}
else if ($verb === "PUT"){
    $postNum = $_PUT["postId"];
    $prepper = $dbhandle->prepare("SELECT * FROM posts WHERE number = ?")
    $prepper->bindParam(1, $postNum);
    $prepper->execute();
    $stmt = $prepper->fetch();
    $likeCount = $stmt['likes'];
    $likeCount++;
	
    $qry = $dbhandle->prepare("UPDATE posts SET likes = ? WHERE number = ?");
    $qry->bindParam(1, $postNum);
    $qry->bindParam(2, $likeCount);
    $qry->execute();
}
?>
