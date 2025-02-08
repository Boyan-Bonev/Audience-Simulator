<?php
$profileData = include '../dashboard/profileData.php'; 

if ($profileData === false) {
    die("Error including profile data.");
}

$profileName = $profileData['name'];
$profilePicture = $profileData['picture'];
$profilePicture = "../userPhotos/$profilePicture";
?>

<header>
    <section id="profileInfo">
        <img id="profilePicture" src="<?php echo $profilePicture; ?>" alt="<?php echo $profileName; ?>">
        <p id="profileName"><?php echo $profileName; ?></p>
    </section>
    <nav id="topNav">
        <ul>
            <?php include 'changeButtonVisibility.php' ?>
            <li><a href="../profile/profile.php" id="profile">Profile</a></li>
            <li><a href="../login/logout.php" id="logout" class="btn btn-warning">Log out</a></li>
        </ul>
    </nav>
</header>

<script src="addStylization.js">
    addStylization("headerStyles");
</script>