<?php
if (session_id() == "") {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: ../login/login.php");
    exit;
}

require_once "../login/database.php";

$email = $_SESSION["user"];

$stmt = $conn->prepare("SELECT name, photo,role,points FROM registration_form.users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); 

if (!$user) {
    $profileName = "User Not Found";
    $profilePicture = "n/a";
	$profilePoints = -1;
	$profileRole = "User";
	
} else {
    $profileName = htmlspecialchars($user['name']);
    $profilePicture = htmlspecialchars($user['photo']);
    if ($profilePicture === null || $profilePicture === "") {
        $profilePicture = "default_profile.jpg";
    }
	$profilePoints = $user['points'];
	$profileRole = ucfirst($user['role']);
	if ($profileRole === null ) {
		$profileRole = "Guest";
	}
}

$profileData = [
    'name' => $profileName,
    'picture' => $profilePicture,
	'points' => $profilePoints,
	'role' => $profileRole,
];
$stmt->close();
return $profileData;

?>