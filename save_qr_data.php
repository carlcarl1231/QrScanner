<?php
session_start();


$server = "localhost";
$username = "root";
$password = "";
$dbname = "scandb";

$conn = new mysqli($server, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


function insertData($conn, $fName, $lName, $mi, $plateNumber, $vehicleType, $address, $contactNumber, $orcr) {
    $sql = "INSERT INTO table_scan (fName, lName, mi, plateNumber, vehicleType, address, contactNumber, orcr) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssi", $fName, $lName, $mi, $plateNumber, $vehicleType, $address, $contactNumber,  $orcr);

        if ($stmt->execute()) {
            echo 'Added Successfully'; 
        } else {    
            http_response_code(500);
            echo "Error: " . $stmt->error; 
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo "Error: " . $conn->error; 
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fName'], $_POST['lName'], $_POST['mi'], $_POST['plateNumber'], $_POST['type'], $_POST['address'], $_POST['contactNumber'],$_POST['orcr'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $mi = $_POST['mi'];
    $plateNumber = $_POST['plateNumber'];
    $vehicleType = $_POST['type'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
    $orcr = $_POST['orcr'] ? 1 : 0;

    insertData($conn, $fName, $lName, $mi, $plateNumber, $vehicleType, $address, $contactNumber, $orcr);
}

$conn->close();
?>
