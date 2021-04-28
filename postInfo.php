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
    if(!$ret) {
       echo($dbhandle->lastErrorMsg());
    } else {
       echo"Records created successfully");
   }
   #$dbhandle->close();
   
}
else if ($verb === "GET"){
    $retrun_arr = array();
    $query = sqlite_query($dbhandle, "SELECT * FROM Posts ORDER BY PostNumber DESC LIMIT 0, 1;");
    while ($entry = sqlite_fetch_array($query, SQLITE_ASSOC)) {
        $usrName = $entry['User']
	
        $postNum = $entry['PostNumber']

        $pstTime = $entry['PostTime']

        $pstLikes = $entry['Likes']

        $pstData = $entry['Data']
		
	$return_arr[] = array('User' => $usrName,
                    'PostNumber' => $postNum,
                    'PostTime' => $pstTime,
                    'Likes' => $pstLikes
		    'Data' => $pstData);
}
	header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    #$dbSigning_array = array($usrName,$postNum,$pstTime,$pstLikes,$pstData);
    echo json_encode($return_arr);
}
?>
