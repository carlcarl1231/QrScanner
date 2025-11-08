<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "scandb";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
    date_default_timezone_set('Asia/Manila');
    $text = $_POST['text'];
    $date = date('Y-m-d');
    $time = date('H:i');
    
    $data = json_decode($text, true);
   
// if ($data === null || !isset($data['fName']) || !isset($data['lName']) || !isset($data['mi']) || !isset($data['plateNumber']) || !isset($data['type']) || !isset($data['address']) || !isset($data['contactNumber'])) { $_SESSION['error'] = "Invalid QR code data."; //     die($_SESSION['error']); // }

    $fName = $conn->real_escape_string($data['fName']);
    $lName = $conn->real_escape_string($data['lName']);
    $mi = $conn->real_escape_string($data['mi']);
    $plateNumber = $conn->real_escape_string($data['plateNumber']);
    $vehicleType = $conn->real_escape_string($data['type']);


    $stmt = $conn->prepare("SELECT ID FROM table_scan WHERE fName = ? AND lName = ? AND mi = ? AND plateNumber = ? AND vehicleType = ? AND address = ? AND contactNumber = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('sssssss', $fName, $lName, $mi, $plateNumber, $vehicleType, $data['address'], $data['contactNumber']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $IDIndex = isset($row['ID']) ? $row['ID'] : null;
    $stmt->close();

    if ($IDIndex) {
      
        $stmt = $conn->prepare("SELECT * FROM table_scan2 WHERE IDIndex = ? AND logDate = ? AND status = '0'");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('is', $IDIndex, $date);
        $stmt->execute();
        $query = $stmt->get_result();

        if ($query->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE table_scan2 SET timeOut = ?, status = '1' WHERE IDIndex = ? AND logDate = ? AND status = '0'");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param('sis', $time, $IDIndex, $date);
            if ($stmt->execute()) {
                $_SESSION['success'] = 'Logged Out Successfully';
            } else {
                $_SESSION['error'] = "Error updating record: " . $stmt->error;
                die($_SESSION['error']); 
            }
            $stmt->close();

        } else {

            $stmt = $conn->prepare("INSERT INTO table_scan2 (timeIn, logDate, status, IDIndex) VALUES (?, ?, '0', ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param('ssi', $time, $date, $IDIndex);
            if ($stmt->execute()) {
                $_SESSION['success'] = 'Checked In Successfully';
            } else {
                $_SESSION['error'] = "Error inserting record: " . $stmt->error;
                setTimeout(function() {
                    alert($_SESSION['error']);
                    header("Location:scanner.php");

                },1000);
            }
            $stmt->close();
        }
    } else {
        $_SESSION['error'] = "No matching record found in table_scan.";
        die($_SESSION['error']); 
    }

    header("Location: scanner.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Instascan.js"></script>
    <title>QR Code Scanner</title>
    <link rel="shortcut icon" type="x-icon" href="letter-s.png">
    <link rel="stylesheet" href="Stylesheet.css" />
</head>
<body>

<?php
require 'includes/navlink.inludes.php';
?>

<div class="container mt-2 section align-items-middle"  id="scanner">
    <div class="row">
        <div class="col-md-6 ">
            <video id="preview" width="100%" ></video> 
            <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
            ?>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                   Scan Qr Code
                </div>
                    <div class="card-body">
                     <h5>Instructions</h5>
                            <ul>
                                <li>Hold the QR code steadily in front of the camera.</li>
                                <li>Ensure the QR code is well-lit and unobstructed.</li>
                                <li>Once the code is scanned, it will automatically check you in or out.</li>
                            </ul>
                    </div>
            </div>
        </div>
    </div>  
        <div class="col-md-12">
            <form action="scanner.php" method="POST" class="form-horizontal">
                <input type="text" name="text" id="text" readonly="" placeholder="QR Code Data" class="form-control  align-items-center">
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Middle Initial</td>
                        <td>Plate Number</td>
                        <td>Vehicle Type</td>
                        <td>Time In</td>
                        <td>Time Out</td>
                        <td>Log Date</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   
                    $conn = new mysqli($server, $username, $password, $dbname);
                   $counter =1;
                   $result = $conn->query("
                   SELECT 
                       table_scan2.id2, 
                       table_scan.fName, 
                       table_scan.lName, 
                       table_scan.mi,  
                       table_scan.plateNumber,  
                       table_scan.vehicleType,  
                       table_scan2.timeIn,  
                       table_scan2.timeOut, 
                       table_scan2.logDate,  
                       table_scan2.status 
                   FROM 
                       table_scan2 
                   INNER JOIN 
                       table_scan 
                   ON 
                       table_scan2.IDIndex = table_scan.ID 
                   ORDER BY id2 DESC
               ");
                if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row['fName'] . "</td>";
                            echo "<td>" . $row['lName'] . "</td>";
                            echo "<td>" . $row['mi'] . "</td>";
                            echo "<td>" . $row['plateNumber'] . "</td>";
                            echo "<td>" . $row['vehicleType'] . "</td>";
                            echo "<td>" . $row['timeIn'] . "</td>";
                            echo "<td>" . $row['timeOut'] . "</td>";
                            echo "<td>" . $row['logDate'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
        document.getElementById("text").value = content;
        document.forms[0].submit();
    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });
</script>
</body>
</html>
