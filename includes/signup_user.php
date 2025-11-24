<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
session_start();

require 'helpers.php';
require '../Classes/Dbh.php';
require '../Classes/Users.php';

$csrf = new CSRF();

$signupAlert = "";
$loginAlert = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
   
    if (isset($_POST['save'])) {
        // CSRF check
        if (!$csrf->verify($_POST['csrf_token_hash'])) {
            die("CSRF validation failed");
        }
        $csrf->refresh();

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $confirm  = htmlspecialchars($_POST['password2']);
        $status   = $_POST['status'] ?? null;

        if ($password !== $confirm) {
            $signupAlert = "<div class='alert alert-danger'>Passwords do not match!</div>";
            echo "<script>  
                    const modal = new bootstrap.Modal(document.getElementById('signupModal'));
                    modal.show(); 
                  </script>";

        } else {
            $login = new Login($username, $password, $status);
            if ($login->insertUser()) {
                $signupAlert = "<div class='alert alert-success'>User registered successfully! Redirecting...</div>";
                echo "<script>
                        setTimeout(function(){
                            window.location.href = '../generator.php';
                        }, 2000);
                      </script>";
            } else {
                $signupAlert = "<div class='alert alert-danger'>Failed to register user.</div>";
            }
        }
    }

    if (isset($_POST['logSave'])) {
        // CSRF check
        if (!$csrf->verify($_POST['csrf_token_hash'])) {
            die("CSRF validation failed");
        }
        $csrf->refresh();

        $logusername = htmlspecialchars($_POST['logusername']);
        $logpassword = htmlspecialchars($_POST['logpassword']);

        $login = new Login($logusername, $logpassword);
        if ($login->loginUser()) {
            $loginAlert = "<div class='alert alert-success'>Login successful! Redirecting...</div>";
            echo "<script>
                    setTimeout(function(){
                        window.location.href = '../dashboard.php';
                    }, 2000);
                  </script>";
        } else {
            $loginAlert = "<div class='alert alert-danger'>Invalid username or password.</div>";
        }
    }
}
?>

<!-- Buttons to open modals -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">
    Sign Up
</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
    Log In
</button>

<!-- Signup Modal -->
<div class="modal" id="signupModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Sign Up</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $csrf->input(); ?>
                    <input type="hidden" name="status" value="admin">

                    <?php echo $signupAlert; ?>

                    <label for="signupUsername">Username</label>
                    <input type="text" name="username" id="signupUsername" placeholder="Username" class="form-control" required>

                    <label for="signupPassword" class="mt-2">Password</label>
                    <input type="password" name="password" id="signupPassword" class="form-control" placeholder="Password" required>

                    <label for="signupPassword2" class="mt-2">Repeat Password</label>
                    <input type="password" name="password2" id="signupPassword2" class="form-control" placeholder="Repeat Password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Log In</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $csrf->input(); ?>
                    <?php echo $loginAlert; ?>

                    <label for="loginUsername">Username</label>
                    <input type="text" name="logusername" id="loginUsername" placeholder="Username" class="form-control" required>

                    <label for="loginPassword" class="mt-2">Password</label>
                    <input type="password" name="logpassword" id="loginPassword" placeholder="Password" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="logSave" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
