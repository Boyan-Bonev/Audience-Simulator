<?php
  
  session_start();
  
   
  require_once "../connectToEvents.php";
  $st = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $st->bind_param("s",$_SESSION["user"]);
  $st->execute();
  $result = $st->get_result();
  $r = $result->fetch_assoc();
  $id = $r['id'];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	$command = json_decode(file_get_contents('php://input'), true)['command'];
	
	

    $inp = $conn->prepare(
        "UPDATE users SET points = points +1 WHERE roomid IN (SELECT id FROM events.meetings WHERE creatorid = ?) AND EXISTS (SELECT * FROM events.actions
		 WHERE userid=id AND action_name=?)");
    $inp->bind_param("is", $id,$command);
    $inp->execute();
	$inp = $conn->prepare("DELETE FROM actions");
	$inp->execute();
	
    $inp->close();
	
	
}
?>