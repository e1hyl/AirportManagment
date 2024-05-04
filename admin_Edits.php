<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleAdminLogin.css">
    <title>Admin Edits</title>
</head>
<body>
    <div class="container">
    <h1>Edit Airport Data</h1>
    <form action="admin_Edits.php" method="post">
        <label for="air_name">Airport Name:</label>
        <input type="text" id="air_name" name="air_name" required>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        <label for="terminals">Terminals:</label>
        <input type="number" id="terminals" name="terminals" required>
        <input type="submit" value="Add Airport">
    </form>
</div>

<?php
// Connect to the database (you'll need to provide your own credentials)
$db = new mysqli("localhost", "root", "", "airport_managment");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $air_name = $_POST["air_name"];
    $location = $_POST["location"];
    $terminals = $_POST["terminals"];

    // Check if the airport name already exists
    $check_query = "SELECT * FROM airport WHERE air_name = '$air_name'";
    $result = $db->query($check_query);

    if ($result->num_rows > 0) {
        echo "<script>alert('Airport name already exists. Please choose a different name.');</script>";
    }

    // Insert data into the airport table
    $insert_query = "INSERT INTO airport (air_name, location, terminals) VALUES ('$air_name', '$location', $terminals)";
    if ($db->query($insert_query) === TRUE) {
        echo "<script>alert('Airport added successfully!');</script>";
    } else {
        echo "Error: " . $insert_query . "<br>" . $db->error;
    }
}

$db->close();
?>


</body>

<a href="index.php" class="button">Go Back</a> 
</html>
