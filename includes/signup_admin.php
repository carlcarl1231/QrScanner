<?php
session_start();

require "helpers.php";
require '../Classes/Dbh.php';
require '../Classes/Users.php';

$csrf = new CSRF();

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $csrf->refresh();

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirm= htmlspecialchars($_POST["password2"]);
    $status  = $_POST['status'];
    // Create Login object
    $login = new Login($username, $password, $status);

    // Run insert / authentication here
    if (!$csrf->verify($_POST['csrf_token_hash'])) {
        die("CSRF validation failed");
    }

    $login->insertUser();

    echo "Form received successfully!";
}
?>


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Log In
</button>

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
                    <input type="hidden" name="status" value="admin">

                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" class="form-control" required>

                    <label for="password" class="mt-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>

                    <label for="password2" class="mt-2">Repeat Password</label>
                    <input type="password" name="password2" placeholder="Repeat Password" id="password2" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save" class="btn btn-primary">Login</button>
                </div>

            </form>

        </div>
    </div>
</div>
