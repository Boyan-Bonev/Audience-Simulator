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
        include '../header/header.php';
    ?> 

	<form id="eventForm" action="addEvent.php" method="post" enctype="multipart/form-data">
	   <label for="eventName">Event name:</label>
	   <input type="text" id="eventName" name="eventName"><br><br>

	   <label for="eventImg">Select image:</label>
	   <input type="file" id="eventImg" name="eventsImg" accept="image/*"><br><br>

	   <label for="rowNum">Number of rows:</label>
	   <input type="number" id="rowNum" name="rowNum" min="1" max="50"><br><br>

	   <label for="colNum">Number of columns:</label>
	   <input type="number" id="colNum" name="colNum" min="1" max="50"><br><br>

	   <label for="eventDesc">Description:</label>
	   <input type="text" id="eventDesc" name="eventDesc"><br><br>

	   <input id="submitEvent" type="submit" value="Create event">
	</form>

</body>
</html>