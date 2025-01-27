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

$stmt = $conn->prepare("SELECT name, photo FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); 

if (!$user) {
    $profileName = "User Not Found";
    $profilePicture = "default_profile.jpg";
} else {
    $profileName = htmlspecialchars($user['name']);
    $profilePicture = htmlspecialchars($user['photo']);
    if ($profilePicture === null || $profilePicture === "") {
        $profilePicture = "default_profile.jpg";
    }
}

$profileData = [
    'name' => $profileName,
    'picture' => $profilePicture,
];

return $profileData;

?>