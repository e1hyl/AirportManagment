    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style_Airport_Airplane.css">
        <title>Flight Information</title>
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

    $selectedAirport = $_GET['airport'];

    $sql_airports = "SELECT f.flightNo, f.destination, f.ttime, f.airName, a.air_Name
                    FROM flight f
                    LEFT JOIN airport a ON f.airName = a.air_Name
                    WHERE a.air_Name = ?";

    $stmt = $conn->prepare($sql_airports);
    $stmt->bind_param("s", $selectedAirport);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Flight Information for Airport: $selectedAirport</h2>";
        echo "<table>";
        echo "<tr><th>Flight Number</th><th>Destination</th><th>Time</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['flightNo'] . "</td>";
            echo "<td>" . $row['destination'] . "</td>";
            echo "<td>" . $row['ttime'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No flights found for this airport.";
    }

    $sql_employees = "SELECT e.emp_id, e.e_name, e.age, e.airName, a.air_Name
                    from employees e
                    LEFT JOIN airport a ON e.airName = a.air_Name
                    WHERE a.air_Name = ?"; 
    $stmt = $conn->prepare($sql_employees);
    $stmt->bind_param("s", $selectedAirport);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        echo "<h2>Employees Information</h2>";
        echo "<table>";
        echo "<tr><th>Employee ID</th><th>Name</th><th>Age</th></tr>";
        
        // echo "<td>" . $row['airName'] . "</td>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['emp_id'] . "</td>";
            echo "<td>" . $row['e_name'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No flights found for this airport.";
    }
   
    ?>
    <div class="booking-form">
    <h2>Booking Menu</h2>
    <form action="airport.php" method="GET">
        <label for="airport">Select Destination:</label>
        <select name="airport" id="airport">
            <?php
            
            $sql_destination = "SELECT f.destination 
                                    FROM flight f
                                    LEFT JOIN airport a ON f.airName = a.air_Name
                                    WHERE a.air_Name = ? AND f.bookable = 1";

            $stmt = $conn->prepare($sql_destination);
            $stmt->bind_param("s", $selectedAirport);
            $stmt->execute();
            $result_airports_dropdown = $stmt->get_result();
            
 
            if ($result_airports_dropdown->num_rows > 0) {
                while ($row_airport_dropdown = $result_airports_dropdown->fetch_assoc()) {
                    echo "<option value='" . $row_airport_dropdown['destination'] . "'>" . $row_airport_dropdown['destination'] . "</option>";
                }
            }
            

            ?>
            
            
        </form>  

        </select><br><br>
        <label for="passanger_name">Passenger Name:</label>
        <input type="text" id="passanger_name" name="passanger_name"><br><br>
        <label for="passanger_age">Passenger Age:</label>
        <input type="number" id="passanger_age" name="passanger_age"><br><br>
        <input type="submit" value="Submit">
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if(isset($_GET['passanger_name']) && isset($_GET['passanger_age'])) {
                $passenger_name = $_GET['passanger_name'];
                $passenger_age = $_GET['passanger_age'];
                
                $sql_insert_passenger = "INSERT INTO passangers (passanger_name, passanger_age, destination) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql_insert_passenger);
                $stmt->bind_param("sis", $passenger_name, $passenger_age, $selectedAirport);
                
                if ($stmt->execute() === TRUE) {
                    echo "Passenger information inserted successfully!";
                } else {
                    echo "Error: " . $sql_insert_passenger . "<br>" . $conn->error;
                }
                $stmt->close();
                //var_dump($passanger_age);   
            }
        }
    
        ?>

    </body>
    <a href="index.php" class="button">Go Back</a> 
    </html>
<!-- 
    $sql_destination = "SELECT f.destination 
                                    FROM flight f
                                    LEFT JOIN airport a ON f.airName = a.air_Name
                                    WHERE a.air_Name = ?"; -->
