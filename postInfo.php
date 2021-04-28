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
	$sql =<<<EOF
		INSERT INTO Posts (User,PostNumber,Time,Likes,Data)
		VALUES ($_SESSION["usrName"], $_SESSION["postCount"], $_SESSION["postTime"], $_SESSION["postLikes"], $_SESSION["postData"]);
	EOF;
	$ret = $dbhandle->exec($sql);
    if(!$ret) {
       echo($dbhandle->lastErrorMsg());
    } else {
       echo"Records created successfully");
   }
   $dbhandle->close();
   $_SESSION["usrName"] = $_POST['receiver_name'];
   $_SESSION["PostCount"] = $_POST['receiver_name'];
   $_SESSION["postTime"] = $_POST['receiver_name'];
   $_SESSION["postLikes"] = $_POST['receiver_name'];
   $_SESSION["postData"] = $_POST['receiver_name'];
   
}
else if ($verb === "GET"){
    $query = "SELECT User FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;"
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $usrName = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$query = "SELECT PostNumber FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;"
	$statement = $dbhandle->prepare($query);
    $statement->execute();
    $postNum = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$query = "SELECT Time FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;"
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $pstTime = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$query = "SELECT Likes FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;"
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $pstLikes = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$query = "SELECT Data FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;"
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $pstData = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    $dbSigning_array = array($usrName,$postNum,$pstTime,$pstLikes,$pstData);
    echo json_encode($dbSigning_array);
}
?>
