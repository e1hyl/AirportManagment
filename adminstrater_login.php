<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleAdminLogin.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="adminstrater_login.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <?php
// Check if form is submitted and username and password are not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['password'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "airport_managment";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch username and password from form
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Fetch username and password from database
    $sql = "SELECT * FROM adminlogin WHERE username='$entered_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($entered_password != $row['passwordd']) {
            echo "<p class='error'>Incorrect password. Please try again.</p>";
            // Redirect to admin_Edits.php if login successful
            
            exit;
        } else {
            header("Location: admin_Edits.php");
        }
    } else {
        echo "<p class='error'>User not found. Please try again.</p>";
    }

    $conn->close();
}
?>


    </div>
</body>
</html>
