<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profileStyle.css">
</head>
<body>
 <?php
    $profileData = include 'getInfo.php'; 

    if ($profileData === false) {
        die("Error including profile data.");
    }

    $profileName = $profileData['name'];
    $profilePicture = $profileData['picture'];
    $profilePicture = "../userPhotos/$profilePicture";
	$profilePoints = $profileData['points'];
	$profileRole = $profileData['role'];
    ?>

    <header>
        <section id="profileInfo">
            <img id="profilePicture" src="<?php echo $profilePicture; ?>" alt="<?php echo $profileName; ?>">
            <p id="profileName"><?php echo $profileName; ?></p>
        </section>
        <nav id="topNav">
            <ul>
                <?php include '../dashboard/changeButtonVisibility.php' ?>
                <li><a href="profile.php" id="profile">Profile</a></li>
                <li><a href="../login/logout.php" id="logout" class="btn btn-warning">Log out</a></li>
            </ul>
        </nav>
    </header>
 <section id="picSpace">
  <img id="profPic" src="<?php echo $profilePicture; ?>" alt="<?php echo $profileName; ?>">    
 </section>
 

 <section id="info">
 <h2 id="username"><?php echo $profileName; ?></h2>
 <hr/>
  <ul id="profData">
   <li id="pointsLi"><?php echo $profilePoints; ?></li>
   <li id="otherLi"><?php echo $profileRole; ?></li>   
  </ul>
 </section>
</body>