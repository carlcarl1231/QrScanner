<?php 
require_once 'Classes/Dbh.php'; 


try { 
$db = new Dbh();
$conn = $db->connect();
} catch (PDOException $e) {
    die("Connection Failed:" . $e->getMessage());
}


$sql = "SELECT id, fName, lName, mi, plateNumber, vehicleType, address, contactNumber FROM table_scan";  

if (isset($_GET['search'])) {     
    $search = htmlspecialchars(trim($_GET['search']));

    if (!empty($search)) {
        $sql .= " WHERE fName LIKE '%$search%' OR lName LIKE '%$search%' OR mi LIKE '%$search%' OR plateNumber LIKE '%$search%' OR vehicleType LIKE '%$search%' OR address LIKE '%$search%' OR contactNumber LIKE '%$search%'";
    }
}  

$results = $conn->query($sql);  
$rows = $results->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['success'])) {     
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';     
    unset($_SESSION['success']); 
} elseif (isset($_SESSION['error'])) {     
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';     
    unset($_SESSION['error']); 
} 
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="qrcode.js"></script>
    <title>Management</title>
    <link rel="shortcut icon" type="x-icon" href="letter-s.png">
    <link rel="stylesheet" href="Stylesheet.css" />      

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to change this record? This record will be deleted and will prompt you to make a new record...")) {
                window.location.href = 'delete_and_redirect.php?id=' + id;
            }
        }

 async function generateCode(qrData) {
  const encoder = new TextEncoder();
    const data = encoder.encode(qrData);

    // Hash it using SHA-256
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    // Shorten it (like substr in PHP)
    const shortHash = hashHex.substring(0, 10);
        let qrCanvas = document.getElementById('qrCanvas');
        qrCanvas.innerHTML = ""; // clear old QR if any
        new QRCode(qrCanvas, {
            text: shortHash,
            width: 128,
            height: 128
        });

        saveqr();
        $('#qrCodeModal').modal('show');
    }


function saveqr() {
    setTimeout(function() {
        let qrCanvas = document.getElementById('qrCanvas');
        let canvas = qrCanvas.querySelector('canvas');
        if (!canvas) return; // safety check

        let imageData = canvas.toDataURL("image/png");
        let qrImage = document.getElementById('qrImage');
        qrImage.src = imageData;
        qrImage.style.display = 'block';
        document.getElementById('downloadLink').href = imageData;
    }, 1000);
}

    </script>
</head>
<body>

<?php
require 'includes/navlink.inludes.php';
require 'Classes/Generator.php';
?>

<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">Generated QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <canvas id="qrCanvas"></canvas> 
                <img id="qrImage" style="display: none; max-width: 100%;" />
                <br><a id="downloadLink" href="#" download="qrcode.png">Download QR Code</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="container mt-2">
    <div class="row">
        <div class="col-md-6">
            <h2>Management</h2>
        </div>
        <div class="col-md-6 text-right">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <div class="input-group-append">
                        &nbsp&nbsp <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered mt-2">
        <thead>
            <tr class="text-center">
                <th>First <br> Name</th>
                <th>Last Name</th>
                <th>Middle Initial</th>
                <th>Plate Number</th>
                <th>Vehicle Type</th>
                <th class="align-middle">Address</th>
                <th>Contact Number</th>
                <th class="align-middle">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php             
            if (count($rows) > 0) {
                foreach ($rows as $row ) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['fName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['plateNumber']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vehicleType']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                    echo '<td><button onclick="confirmDelete(' . $row['id'] . ')" class="btn btn-warning">Update</button>&nbsp<button onclick="generateCode(' . $row['id'] . ')" class="btn btn-warning">Re-Generate Code</button> </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No records found.</td></tr>";
            }
            ?>         
        </tbody>
    </table>
</div>
</body>
</html>

<?php 
$conn=null; 
?>
