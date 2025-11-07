<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$dbname = "scandb";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "ID passed: " . htmlspecialchars($id);

    $sql = "SELECT fName, lName, mi, plateNumber, vehicleType, address, contactNumber FROM table_scan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fName, $lName, $mi, $plateNumber, $vehicleType, $address, $contactNumber);
        $stmt->fetch();
        echo "Record found: " . htmlspecialchars($fName) . " " . htmlspecialchars($lName); 

        $deleteSql = "DELETE FROM table_scan WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        if (!$deleteStmt) {
            die("Prepare failed: " . htmlspecialchars($conn->error)); 
        }

        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            $deleteStmt->close();

            header("Location: generator.php?action=new&fName=" . urlencode($fName) . "&lName=" . urlencode($lName) . "&plateNumber=" . urlencode($plateNumber) . "&vehicleType=" . urlencode($vehicleType) . "&address=" . urlencode($address) . "&contactNumber=" . urlencode($contactNumber));
            $conn->close();
            exit();
        } else {
            $_SESSION['error'] = "Error deleting the record: " . $deleteStmt->error;
            $deleteStmt->close();
            header("Location: management.php");
            exit();
        }
    } else {
        echo "No record found."; 
        $_SESSION['error'] = "Record not found.";
        header("Location: management.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: management.php");
    exit();
}

$conn->close();

?>
