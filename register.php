<?php
    include 'connect.php'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/registerstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Register</title>
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
                        <a class="nav-link active" aria-current="page" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log-in</a>
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
            <h5>Register</h5>
        </div>
        <div class="card-body">
            <form action="register.php" method="POST" id="registerForm">

                <div class="mb-3">
                    <label for="firstname" class="form-label">First name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="firstnameHelp" required>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="lastnameHelp" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" name="username" id="username" aria-describedby="usernameHelp" required>
                </div>


                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" aria-describedby="birthdateHelp" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">Your email will not be shared. User privacy is part of our policy.</div>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <select class="form-select" name="gender" id="gender" aria-label="genderHelp" required>
                            <option selected disabled>Please select a gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <label for="gender">Gender</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"  required />
                </div>
                <div class="mb-3">
                    <label for="confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm" id="confirm"  required />
                    <p>Already a member? <a href="login.php">Sign in</a></p>
                </div>
                <button type="submit" class="btn btn-primary" name= "submit">Register</button>
            </form>
        </div>
    </div>
</div>

<div id="footer">
    <p> Philippe Andrei S. Dael <br> BSCS - 2 </p>
</div>

<script>
    // $("#registerForm").submit(function(){
    //     $.post($(this).attr("action"), $(this).serialize());
    //     return true;
    // });
    $(document).ready(function() {
        $("#registerForm").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize form data
            var formData = $(this).serialize();

            // Send form data using AJAX
            $.post($(this).attr("action"), formData, function(response) {
                // Handle response from the server
                if (response === "success") {
                    // Redirect to success page or perform other actions upon successful submission
                    window.location.href = "success.php";
                } else {
                    // Display error message
                    $("#error-message").text(response);
                    // Optionally, retain input values
                    $("#username").val(formData.username);
                    $("#password").val(formData.password);
                }
            });
        });
    });
</script>

</body>
</html>

<?php
if(isset($_POST['submit'])){
    //retrieve data from form and save the value to a variable
    //for tbluserprofile
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $gender=$_POST['gender'];
    $bdate=$_POST['birthdate'];

    //for tbluseraccount
    $email=$_POST['email'];
    $uname=$_POST['username'];
    $pword=$_POST['password'];

    $confirm=$_POST['confirm'];

    //save data to tbluserprofile
    $sql1 = "Insert into tbluserprofile(firstname,lastname,gender,birthdate) values('".$fname."','".$lname."','".$gender."','".$bdate."')";
    mysqli_query($connection,$sql1);

    //Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
    $sql2 ="Select * from tbluseraccount where username='".$uname."'";
    $result = mysqli_query($connection,$sql2);
    $row = mysqli_num_rows($result);
    if($row == 0){
        if($confirm == $pword) {
            $hash = password_hash($pword, PASSWORD_DEFAULT);
            $sql = "Insert into tbluseraccount(emailadd,username,password) values('" . $email . "','" . $uname . "','" . $hash . "')";
            mysqli_query($connection, $sql);
            echo "<script language='javascript'>
                            window.location.href = 'login.php';
                            alert('New record saved.');
                      </script>";
            //        header("location: login.php");
            exit();
        } else {
            echo "<script language='javascript'>
                        alert('Passwords do not match.');   
                 </script>";
        }
    } else {
        echo "<script language='javascript'>
						alert('Username already existing');
				  </script>";
    }


}


?>