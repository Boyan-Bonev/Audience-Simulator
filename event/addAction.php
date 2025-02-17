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
        $action = json_decode(file_get_contents('php://input'), true)['action'];
        
        $inp = $conn->prepare("DELETE FROM actions WHERE userid=?");
        $inp->bind_param('i',$id);
        $inp->execute();
        $inp = $conn->prepare("INSERT INTO actions (userid,action_name) VALUES(?,?)");
        $inp->bind_param("is", $id,$action);    	
        $inp->execute();
        $inp->close();
    }

?>