<?php
    session_start();
    if(!isset($_SESSION["user"]))
    {
        header("Location: login.php");
    }
    require_once "database.php";
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
    <title>Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        
        <div class="logout-btn">
            <a href="logout.php" class="btn btn-warning">Logout</a>
        </div> 
        
    </div>
</body>
</html>