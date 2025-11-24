
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
session_start();

require 'helpers.php';
require '../Classes/Dbh.php';
require '../Classes/Login.php';

$csrf = new CSRF();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save'])) {

    // CSRF check
    if (!$csrf->verify($_POST['csrf_token_hash'])) {
        die("CSRF validation failed");
    }
    $csrf->refresh();

    // Get form values
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $status = $_POST['status'] ?? null; // admin or null

    // Create login object and insert
    $login = new Login($username, $password, $status);
    $login->insertUser();

    echo "<div class='alert alert-success'>User inserted successfully!</div>";
}
?>

<!-- Modal Trigger -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Log In
</button>

<!-- Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Log In</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $csrf->input(); ?>

                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>

                    <label for="password" class="mt-2">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

