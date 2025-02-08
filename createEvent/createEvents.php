<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="createEventStyle.css">
</head>
<body>
    <?php
    $profileData = include '../profile/getInfo.php'; 

    if ($profileData === false) {
        die("Error including profile data.");
    }

    $profileName = $profileData['name'];
    $profilePicture = $profileData['picture'];
    $profilePicture = "../userPhotos/$profilePicture";
	
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
                <li><a href="../profile/profile.php" id="profile">Profile</a></li>
                <li><a href="../login/logout.php" id="logout" class="btn btn-warning">Log out</a></li>
            </ul>
        </nav>
    </header>
	
	<form action="createEvent.php" method="post">
	   <label for="eventName">Event name:</label>
	   <input type="text" id="eventName" name="eventName"><br><br>
	   <label for="eventImg">Select image:</label>
	   <input type="file" id="eventImg" name="eventImg" accept="image/*"><br><br>
	   <label for="usersNum">Event capacity:</label>
	   <input type="number" id="usersNum" name="usersNum" min="1" max="32"><br><br>
	   <label for="eventDesc">Description:</label>
	   <input type="text" id="eventDesc" name="eventDesc"><br><br>
	   <input type="submit">
	</form>

    

</body>
</html>