<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="qrcode.js"></script>
    <title>QR Code Generator</title>
    <link rel="shortcut icon" type="x-icon" href="letter-s.png">
    <link rel="stylesheet" href="Stylesheet.css" />
</head>
<body>
<?php
require 'includes/navlink.inludes.php';
?>
<div class="container mt-2">
    <h2>QR Code Generator</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            ?>
        </div>
    <?php endif; ?>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#qrFormModalLong">
    Generte Qr-Code
</button>

<!-- Modal -->
<div class="modal fade" id="qrFormModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="generateForm">
            <div class="form-group">
                <input type="text" name="fName" id="fName" placeholder="Enter First Name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="lName" id="lName" placeholder="Enter Last Name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="mi" id="mi" placeholder="Enter Middle Initial" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="plateNumber" id="plateNumber" placeholder="Enter Plate Number" class="form-control" required>
            </div>
            <div class="form-group">
                <select name="type" id="vehicleType" class="form-control" required>
                    <option value="">Select Vehicle Type</option>
                    <option value="Car">Car</option>
                    <option value="Motorcycle">Motorcycle</option>
                    <option value="Tricycle">Tricycle</option>
                    <option value="Truck">Truck</option>
                    <option value="Bus">Bus</option>
                    <option value="Bicycle">Bicycle</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="address" id="address" placeholder="Enter Address" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="contactNumber" id="contactNumber" placeholder="Enter Contact Number" class="form-control" required>
            </div>
            <div class="form-group">
                    <input type="checkbox" id="orcr" name="hasORCR" value="1" > &nbsp Has ORCR
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>



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

<!-- <script> console.log("First Name:", fName);
console.log("Last Name:", lName);
console.log("Middle Initial:", mi);
console.log("Plate Number:", plateNumber);
console.log("Vehicle Type:", vehicleType);
console.log("Address:", address);
console.log("Contact Number:", contactNumber);
</script> -->

<div class="cotainer mt-5">
<div class="container">
<table class="table table-bordered mt-1 " style="border-width:4px">
        <thead>
            <tr>
                <td>ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Middle Initial</td>
                <td>Plate Number</td>
                <td>Vehicle Type</td>
                <td>Address</td>
                <td>Contact Number </td>
            </tr>
        </thead>
        <tbody>
        <?php

          require_once 'Classes/Dbh.php';

          try {
            $db = new Dbh();
            $conn = $db->connect();
          } catch (PDOException $e) {
            die(json_encode(['error' => 'Connection Failed: ' , $e->getMessage()]));
          }

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];
            $mi= $_POST['mi'];
            $plateNumber= $_POST['plateNumber'];
            $vehicleType= $_POST['vehicleType'];
            $address= $_POST['address'];
            $contactNumber= $_POST['contactNumber'];
            $orcr= $_POST['orcr'];
          }
                   $counter=1;
            // $conn = new mysqli($server, $username, $password, $database);
            //      if ($conn->connect_error) {
            // die("Connection Failed" . $conn->error);
            // }

            $sql = "SELECT id, fName, lName, mi, plateNumber, vehicleType, address, contactNumber FROM table_scan ORDER BY id DESC";
     
            $stmt = $conn->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                ?>
                    <tr>
                        <td><?php  echo $counter;   ?></td>
                        <td><?php echo $row['fName']; ?></td>
                        <td><?php echo $row['lName']; ?></td>
                        <td><?php echo $row['mi']; ?></td>
                        <td><?php echo $row['plateNumber']; ?></td>
                        <td><?php echo $row['vehicleType']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['contactNumber']; ?></td>
                    </tr>
                <?php
                $counter++;
                }
            ?>
        </tbody>
    </table>
</div>
</div>

<script src="qrcode.js"></script>
<script>
document.getElementById('generateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let fName = document.getElementById('fName').value;
    let lName = document.getElementById('lName').value;
    let mi = document.getElementById('mi').value;
    let plateNumber = document.getElementById('plateNumber').value;
    let type = document.getElementById('vehicleType').value;
    let address = document.getElementById('address').value;
    let contactNumber = document.getElementById('contactNumber').value;
    let orcr = document.getElementById('orcr').checked ? 1:0;

    if (fName && lName && mi && plateNumber && type && address && contactNumber ) {
      
        let qrData = JSON.stringify({ fName:fName, lName:lName, mi:mi, plateNumber: plateNumber, type: type, address:address, contactNumber:contactNumber });

        // how to change this as id instead of making the qrcode as the whole name XD and the logic relies on id and query
        let qrCanvas = document.getElementById('qrCanvas');
        qrCanvas.innerHTML = ""; //cleared first to put new data
        let qrCode = new QRCode(qrCanvas, { //qrCanavas as holder of the code
            text: qrData,
            width: 128,
            height: 128
        });

   function saveqr() {
        setTimeout(function() {
            let canvas = qrCanvas.querySelector('canvas');
            let imageData = canvas.toDataURL("image/png"); 
                let qrImage = document.getElementById('qrImage');
                qrImage.src = imageData;
                qrImage.innerHTML = ''; 
                qrImage.style.display = 'block'; 
                document.getElementById('downloadLink').href = imageData; 
        },1000);    
    }

        saveqr();
        $('#qrCodeModal').modal('show');

        $.ajax({
            url: 'save_qr_data.php',
            type: 'POST',
            data: { fName:fName, lName:lName, mi:mi, plateNumber: plateNumber, type: type, address:address, contactNumber:contactNumber, orcr:orcr},
            success: function(response) {
                console.log('Data saved successfully');
           
            },
            error: function(error) {
                alert('Failed to save data. Please try again.');
            }
        });
    } else {
        alert('Please fill all fields');
    }
});

</script>

</body>
</html>
