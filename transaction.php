<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>
</head>
<body>

    <h2>Transaction Form</h2>

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
$sql = "CREATE TABLE IF NOT EXISTS `trans` (
    `transId` INT(6) NOT NULL,
    `dateTran` DATE NOT NULL,
    `location` VARCHAR(20) NOT NULL,
    `amount` DECIMAL(10, 2) NOT NULL,
    `status` BOOLEAN NOT NULL,
    `plate` VARCHAR(20) NOT NULL
)";

// Execute the query and check for errors
if ($conn->query($sql) === TRUE) {
    echo "Table records created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

    // Function to generate a unique transId
    function generateUniqueTransId($conn) {
        $transId = substr(uniqid(), 0, 6);

        return $transId;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $plate = mysqli_real_escape_string($conn, $_POST["plate"]);
        $date = mysqli_real_escape_string($conn, $_POST["date"]);
        $location = mysqli_real_escape_string($conn, $_POST["location"]);
        $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);

        // Generate a unique transId
        $transId = generateUniqueTransId($conn);

        // Insert data into the 'trans' table
        $insertSql = "INSERT INTO `trans` (`transId`, `dateTran`, `location`, `amount`, `status`, `plate`) 
                      VALUES ('$transId', '$date', '$location', '$amount', '$status', '$plate')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Transaction recorded successfully";
        } else {
            echo "Error recording transaction: " . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
    ?>

    <form method="post" action="/TC/trans.php">
        <label for="plate">Number Plate:</label>
        <input type="text" name="plate" required>
        <br>

        <label for="date">Date:</label>
        <input type="date" name="date" required>
        <br>

        <label for="location">Location:</label>
        <input type="text" name="location" required>
        <br>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" required>
        <br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="1">Success</option>
            <option value="0">Failure</option>
        </select>
        <br>

        <input type="submit" value="Submit">
    </form>

</body>
</html>
