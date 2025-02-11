<?php
  
  $st = $conn->prepare("SELECT id FROM registration_form.users WHERE email = ?");
  $st->bindparam("s",$_SESSION["user"]);
  $res = $st->execute();
  $r = mysqli_fetch_assoc($res);
  $id = $r['id'];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	$command = $_POST["command"];
	
	

    $inp = $conn->prepare(
        "UPDATE registration_form.users SET points = points +1 WHERE roomid IN (SELECT id FROM events.meetings WHERE creatorid = ?) AND EXISTS (SELECT * FROM events.actions
		 WHERE userid=id AND action_name=?)");
    $inp->bind_param("is", $id,$command);
    $inp->execute();
	$conn->exec("DELETE FROM events.actions");
    $inp->close();
	
	
}
?>