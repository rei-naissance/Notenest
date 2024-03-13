<?php
    include 'connect.php';

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $pword = $_POST['password'];

        $sql = "select * from tbluseraccount where username = '$username' or emailadd = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row) {
            $hash = $row['password'];
            if (password_verify($pword, $hash)) {
//                header("Location:index.php");
                echo "<script language='javascript'>
                        alert('Login successful, welcome back!');
                        window.location.href = 'index.php';
                     </script>";
                exit();
            } else {
                echo "<script language = 'javascript'>
                         alert('Invalid username or password.');
                         window.location.href = 'login.php';
                      </script>";
            }
        }
//        } else {
//            echo '<script>
//                     window.location.href="login.php";
//                     alert("Invalid username or email.");
//                  </script>';
//        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/loginstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Login Page</title>


</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">NoteNest</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php">Log-in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container pad">
    <div class="card">
        <div class="card-header">
            <h5>Login</h5>
        </div>
        <div class="card-body">
            <form action = "login.php" method = "POST" id="loginForm">
                <!-- Unfinished, lacking forms-->
                <div class="mb-3">
                    <label for="username" class="form-label">Username </label>
                    <input type="username" class="form-control" name="username" id="username" aria-describedby="usernameHelp" required>
                    <div id="usernameHelp" class="form-text">Your username will not be shared. User privacy is part of our policy.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"  required/>
                    <a href="register.php">Don't have an account?</a>
                </div>
                <div class="mb-3">
                    <span id="error-message" style="color: red"></span>
                </div>
                <button type="submit" class="btn btn-primary" name = "submit">Login</button>
            </form>
        </div>
    </div>
</div>

<div id="footer">
    <p> Philippe Andrei S. Dael <br> BSCS - 2 </p>
</div>

<script>
    //Test
    // Blabl ablabalabl
    //This was a random attempt at using jquery (from StackOverflow)

    // $(document).ready(function() {
    //     //References the id of the form
    //     $("#loginForm").submit(function (event) {
    //         // Prevent the default form submission from reloading
    //         event.preventDefault();
    //
    //         // Serialize form data
    //         var formData = $(this).serialize();
    //
    //         // Helps with retaining the previous inputs of the user when the form resets due to errors
    //         // let lastInputUser = $("#username").val(formData.username);
    //         // let lastInputPassword = $("#password").val(formData.password);
    //
    //         // Send form data using AJAX
    //         // $.post($(this).attr("action"), formData, function (response) {
    //         //     // Handle response from the server
    //         //     if (response === "success") {
    //         //         // Redirect to success page or perform other actions upon successful submission
    //         //         return true;
    //         //     }
    //         //     else {
    //         //         // Display error message
    //         //
    //         //         // $("#username").val(lastInputUser);
    //         //         // $("#password").val(lastInputPassword);
    //         //     }
    //         // });

    // Tried a different approach I saw in StackOverflow
    //         $.ajax({
    //             type: 'POST',
    //             url: 'index.php',
    //             dataType: "json",
    //             data: formData,
    //             success: function(data) {
    //                 if (data.status === 'success') {
    //                     window.location.href = "index.php";
    //                 } else if (data.status === 'error') {
    //                     $("#error-message").text("The username or password is incorrect. Please try again.");
    //                 }
    //             },
    //             error: function(data) {
    //                 $("#error-message").text("Client side error.");
    //             }
    //         });
    //
    //     });
    // });

    // Tried something I saw in StackOverflow
    $("#registerForm").submit(function(e){
        e.preventDefault();
        $.post($(this).attr("action"), $(this).serialize());
        return true;
    });
</script>

</body>
</html>