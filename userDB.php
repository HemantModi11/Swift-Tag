<?php

// Replace these variables with your own database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "records";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table
$sql = "CREATE TABLE IF NOT EXISTS `records` (
    `userId` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `Pno` VARCHAR(20) NOT NULL,
    `Charge` DECIMAL(10, 2) NOT NULL,
    `Fine` DECIMAL(10, 2) NOT NULL
)";

// Execute the query and check for errors
if ($conn->query($sql) === TRUE) {
    echo "Table records created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Check if a number plate is submitted by the user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the number plate from the form
    $plate = $_POST["plate"];
    
    echo $plate;

    // Check if the plate already exists in the database
    $checkSql = "SELECT * FROM `records` WHERE Pno = '$plate'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // Plate exists, perform deduction and addition operations
        $updateSql = "UPDATE `records` SET Charge = CASE WHEN Charge >= 100 THEN Charge - 100 ELSE Charge END, 
        Fine = CASE WHEN Charge < 100 THEN Fine + 500 ELSE Fine END WHERE Pno = '$plate'";
        
        if ($conn->query($updateSql) === TRUE) {
            echo "Charge updated successfully";
        } else {
            echo "Error updating Charge: " . $conn->error;
        }
    } 
}

// Close the connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Plate Input</title>
</head>
<body>
    <h2>Enter Number Plate:</h2>
    <form method="post" action="/TC/yu.php">
        <label for="plate">Number Plate:</label>
        <input type="text" name="plate" required>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
