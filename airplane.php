<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airplane and Hangar Table</title>
    <link rel="stylesheet" href="style_Airport_Airplane.css">

</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airport_managment"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$selectedAirline = $_GET['airline'];


$sql_airplanes = "SELECT a.*, c.CoName
                  FROM airplane a
                  LEFT JOIN cooperation c ON a.a_id = c.Aid
                  WHERE c.CoName = ?";


$stmt_airplanes = $conn->prepare($sql_airplanes);

if ($stmt_airplanes === false) {
    die('Error preparing airplane statement: ' . $conn->error);
}

// Bind the parameter to the statement
$stmt_airplanes->bind_param('s', $selectedAirline); // 's' indicates a string parameter

// Execute the statement
$stmt_airplanes->execute();

// Get result set for airplanes
$result_airplanes = $stmt_airplanes->get_result();


if ($result_airplanes->num_rows > 0) {
    echo "<h2>Airplanes:</h2>";
    echo "<table>";
    echo "<tr><th>Airport</th><th>Airplane Model</th><th>Capacity</th><th>Weight</th></tr>";
    while ($row_airplane = $result_airplanes->fetch_assoc()) {
        
        echo "<tr>";
        echo "<td>" . $row_airplane['airName'] . "</td>";
        echo "<td>" . $row_airplane['model'] . "</td>";
        echo "<td>" . $row_airplane['capacity'] . "</td>";
        echo "<td>" . $row_airplane['weight'] . "</td>";
        
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No airplanes found for this airline.</p>";
}

// Close the airplane statement
$stmt_airplanes->close();


$sql_hangars = "SELECT h.H_id, h.capacity
FROM hangar h
LEFT JOIN cooperation c ON h.Aid = c.Aid
WHERE c.CoName = ?";

$stmt_hangars = $conn->prepare($sql_hangars);

if ($stmt_hangars === false) {
    die('Error preparing hangar statement: ' . $conn->error);
}


$stmt_hangars->bind_param('s', $selectedAirline); 


$stmt_hangars->execute();


$result_hangars = $stmt_hangars->get_result();


if ($result_hangars->num_rows > 0) {
    echo "<h2>Hangars:</h2>";
    echo "<table>";
    echo "<tr><th>Hangar ID</th><th>Capacity</th></tr>";
    while ($row_hangar = $result_hangars->fetch_assoc()) {
        
        echo "<tr>";
        echo "<td>" . $row_hangar['H_id'] . "</td>";
        echo "<td>" . $row_hangar['capacity'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hangars found for this airline.</p>";
}

$stmt_hangars->close();
$conn->close();
?>

</body>
</html>
