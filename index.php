<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airport Management System</title>
    <link rel="stylesheet" href="styleIndex.css">
    
    <style>
        
        body {
        background-image: url('/cs232Project/NewnewIndex.jpg');
        background-size: 2050px; 
        background-position: center;
       }
    
            .container {
                position: relative; /* Set container to relative position */
            }
    
            .admin-button {
                position: absolute; /* Set button to absolute position */
                top: -3px; /* Adjust top position as needed */
                right: 10px; /* Adjust right position as needed */
            }
        </style>
</head>
<body>
<img src="adminLogo.webp" onclick="openAdminLoginPage()" class="admin-logo">
   
<div class="container">
        
    <h1>Airport Management System</h1>
        <!-- Button to open admin login page -->
        <div class="flex">
        <div>
            <label for="airportSelect">Select Airport</label>
            <select id="airportSelect">
                <option value="">-</option>
                <?php
              
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "airport_managment";

                
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                
                $sql = "SELECT air_name, location FROM airport";

                // Execute the query
                $result = $conn->query($sql);

                // Check if there are rows returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['air_name'] . "'>" . $row['air_name'] . " - " . $row['location'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No airports found</option>";
                }

                $conn->close();
                ?>
            </select>
            <button onclick="confirmSelection2()" >Details and Booking</button>    
        </div>
    
        <div>
            <label for="airlineSelect">Select Airline</label>
            <select id="airlineSelect">
                <option value="">-</option>
                <?php
                // Re-establishing database connection 
                $conn = new mysqli($servername, $username, $password, $dbname);

                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                
                $sql_airlines = "SELECT DISTINCT CoName, phone FROM cooperation";

                
                $result_airlines = $conn->query($sql_airlines);

                
                if ($result_airlines->num_rows > 0) {
                    
                    while ($row_airline = $result_airlines->fetch_assoc()) {
                        echo "<option value='" . $row_airline['CoName'] . "'>" . $row_airline['CoName'] . " - " . $row_airline['phone'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No airlines found</option>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </select>
            <button onclick="confirmSelection1()" >View Details</button>
        </div>
    </div>
    </div>
    
    

<script>
    
    function openAdminLoginPage() {
        window.location = "adminstrater_login.php";
    }

    function confirmSelection1() {
        var selectedAirline = document.getElementById("airlineSelect").value;
        
        if (selectedAirline) {
            window.location = "airplane.php?airline=" + encodeURIComponent(selectedAirline);
            
        } else {
            alert("Please select an airline.");
        }
    }

    function confirmSelection2() {
        var selectedAirport = document.getElementById("airportSelect").value;
        
        if (selectedAirport) {
            window.location = "airport.php?airport=" + encodeURIComponent(selectedAirport);
            
        } else {
            alert("Please select an airport.");
        }
    }
</script>

</body>
</html>
