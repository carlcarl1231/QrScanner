<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "scandb";


$conn = new mysqli($server, $username, $password, $dbname);


if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$results = []; //declare


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $sql = "SELECT table_scan2.id2, table_scan.fName, table_scan.lName, table_scan.mi,  table_scan.plateNumber, table_scan.vehicleType, table_scan.address, table_scan.contactNumber,  table_scan2.timeIn,  table_scan2.timeOut, table_scan2.logDate,  table_scan2.status   FROM table_scan2 INNER JOIN table_scan ON table_scan2.IDIndex = table_scan.ID  WHERE logDate BETWEEN '$startDate' AND '$endDate'";
 
    $query = $conn->query($sql);

    if ($query && $query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $results[] = $row;
        }
    } else {
        echo "<p class='alert alert-warning'>No records found for the selected date range.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>School Vehicle Monitoring System</title>
    <link rel="shortcut icon" type="image/x-icon" href="letter-s.png">
    <link rel="stylesheet" href="Stylesheet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body>

<?php
require 'includes/navlink.inludes.php';
?>



<div class="container mt-4">
  
    <div class="row mb-3 align-items-center">
        <div class="col-md-3">
            <form action="" method="POST"> <label for="startDate" class="mr-2 ">Start Date:</label>
            <input type="date" name="startDate" id="startDate" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="endDate" class="mr-2 " >End Date:</label>
            <input type="date" name="endDate" id="endDate" class="form-control" required>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100 ">Search</button>
        </div>
        <div class="col-md-3">
         
            <?php if (!empty($results)): ?>
                <button onclick="printTable()" class="btn btn-success w-100">Print Results</button>
            <?php endif; ?>
        </div></form>
           
    </div>


    <table class="table table-bordered mt-3" id="resultsTable">
        <thead>
            <tr>
                <th class="align-middle">ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Middle Initial</th>
                <th>Plate Number</th>
                <th>Vehicle Type</th>
                <th class="align-middle">Address </th>
                <th >Contact #</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Log Date</th>
             
                <th class="align-middle">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id2']); ?></td>
                        <td><?php echo htmlspecialchars($row['fName']); ?></td>
                        <td><?php echo htmlspecialchars($row['lName']); ?></td>
                        <td><?php echo htmlspecialchars($row['mi']); ?></td>
                        <td><?php echo htmlspecialchars($row['plateNumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicleType']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['contactNumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['timeIn']); ?></td>
                        <td><?php echo htmlspecialchars($row['timeOut']); ?></td>
                        <td><?php echo htmlspecialchars($row['logDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No records found for the selected date range.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


  
</div>

<script>

function printTable() {
    var printContents = document.getElementById('resultsTable').outerHTML;
    var originalContents = document.body.innerHTML;

    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print Results</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

</body>
</html>
