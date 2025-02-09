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

    include '../header/header.php'
    ?>

 <section id="picSpace">
  <img id="profPic" src="<?php echo $profilePicture; ?>" alt="<?php echo $profileName; ?>">    
 </section>
 

 <section id="info">
 <h2 id="username"><?php echo "Hey ".$profileName.", how's it going?"; ?></h2>
 <hr/>
  <ul id="profData">
   <li id="pointsLi"><?php echo "You have ".$profilePoints." points."; ?></li>
   <li id="otherLi"><?php echo "Your role on this fine website: ".$profileRole; ?></li>   
  </ul>
 </section>
</body>