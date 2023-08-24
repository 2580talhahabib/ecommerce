<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");


if (isset($_POST['submit'])) {
    $username = get_safe_value($conn, $_POST['username']);
    $user_pass = get_safe_value($conn, $_POST['user_pass']);

    // prepare database query
    $sql_query = "SELECT * FROM admin_users WHERE username ='$username' AND user_pass = '$user_pass' ";
    $query_result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($query_result) === 1) {
        alert_message("success", "Login Successful");

        $_SESSION['ADMIN_LOGIN'] = 'yes';
        $_SESSION['username'] = $username;
?>
        <script>
            setTimeout(() => {
                window.location = "categories.php";
            }, 2000);
        </script>
<?php

    } else {
        alert_message("danger", "Enter Correct Credentials");
    }
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header text-white bg-primary">
                    Login Form
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label" for="">Username</label>
                            <input class="form-control" type="text" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Password</label>
                            <input class="form-control" type="password" name="user_pass" required>
                        </div>
         <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit" name="submit">Submit</button>
                        </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>







<?php
include("./includes/footer.php");
?>