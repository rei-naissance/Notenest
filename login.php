<?php
    include 'connect.php';

    if(isset($_POST['submit'])) {

        $isError = false;
        $indicateError = '';

        $username = $_POST['username'];
        $pword = $_POST['password'];

        $sql = "select * from tbluseraccount where username = '$username' or emailadd = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row) {
            $hash = $row['password'];
            if (password_verify($pword, $hash)) {
                echo "<script language='javascript'>
                        window.location.href = 'index.php';
                     </script>";
                exit();
            } else {
                $isError = true;
                $indicateError = 'Invalid password detected.';
            }
        } else {
            $isError = true;
            $indicateError = 'Invalid user detected.';
        }
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
    <link rel="stylesheet" href="css/login-register.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Sign In</title>


</head>
<body>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
    </svg>

    <div class="alert alert-success align-items-center alert-dismissible fade show" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="16" height="16" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <strong>Welcome to NoteNest!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


    <script>
        const accountCreated = window.sessionStorage.getItem('accountCreated');

        if (accountCreated === 'true') {
            document.querySelector('.alert').style.display = 'block';
            window.sessionStorage.removeItem('accountCreated');
        }
    </script>

    <div class="display-container">
        <div class="form-container">
            <div class="register-display-image"></div>
            <div class="register-form">
                <form action="login.php" method="POST" id="loginForm">
                    <?php if(isset($isError)): ?>
                        <div class="mb-3 bg-danger text-white p-2 rounded-3"> <?= $indicateError ?></div>
                    <?php endif; ?>
                    <div class="fg-margin-top form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" class="form-control" name="username" id="username" placeholder="Enter username or email" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" aria-describedby="usernameHelp" required>
                    </div>

                    <div class="fg-margin-top form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required />
                    </div>
                    <div><p class="fg-margin-top">Don't have an account? <a href="register.php">Sign Up</a></p></div>

                    <button type="submit" class="btn btn-primary" name="submit">Log In</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>
</html>