<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="adminSettingsStyles.css">
</head>
<body>
    <script src="adminSettingsOnLoad.js"></script>
    
    <?php
        include '../header/header.php'
    ?>

    <section class="container">
        <form id="setRole">
            <h2>Set Role</h2>
            <label for="user" id="userLabel">User:</label>
            <select id="user" name="user"></select>

            <label for="role" id="roleLabel">Role:</label>
            <select id="role" name="role">
                <option value="normal">Normal User</option>
                <option value="creator">Event Creator</option>
                <option value="admin">Head Admin</option>
            </select>

            <button type="button" onclick="setRole()">Set</button>
            <pre id="message"></pre>
        </form>

        <script src="setRole.js"></script>

        <section id="events">
            <h2 id="eventsTitle">Events</h2>
            <form id="filter">
                <input type="text" id="filterBy" placeholder="Search for events">
                <input type="button" value="Search" onclick="filterEvents()">
            </form>
            <ul id="eventsList"></ul>
        </section>

        <script src="filterEvents.js"></script>
    </section>

</body>
</html>