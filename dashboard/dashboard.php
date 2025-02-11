<?php
    session_start();
    if(!isset($_SESSION["user"]))
    {
        header("Location: ../login/login.php");
    }
    require_once "../login/database.php";
    $email = $_SESSION["user"];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
    
    <?php
        include '../header/header.php';
        include 'displayEvents.php';
    ?>

    <section id="bottomSection">
        <form id = "eventConnectForm">
            <label for="eventName">Insert link</label>
            <input type="text" id="eventName" name="eventName">
            <input type="submit" value="Submit">
        </form>
    </section>

    <script src="connectByEventName.js"></script>
    <script src="connectEventToLink.js"></script>
</body>
</html>