<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]); 
    $password = htmlspecialchars($_POST["password"]);

    require '../Classes/Dbh.php';
    require '../Classes/Login.php';

    
    };

?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Log In
</button>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Log In 
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="name">Username</label>
                    <input type="text" name="name" id="name" placeholder="Username">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="password">
                </div>
                 <div class="modal-footer">
        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?> ">
      </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div>
            <form action="" method="POST">
                <div class="">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="">
                </div>
                <div class="">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="">
                </div>
            </form>
        </div>
    </div>