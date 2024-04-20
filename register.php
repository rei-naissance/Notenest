<?php
    include 'connect.php';

    if(isset($_POST['submit'])) {

        //variables to hold error text
        $isError = false;
        $indicateError = '';

        //retrieve data from form and save the value to a variable

        //for tbluserprofile
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];

        $gen = $_POST['gender'];

        $bdate = $_POST['birthdate'];

        //for tbluseraccount
        $type = 'USER';
        $uname = $_POST['username'];
        $email = $_POST['email'];
        $pword = $_POST['password'];
        $confirm = $_POST['confirm'];


        //Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
        if (!empty($email) and !empty($pword) and !empty($confirm)) {
            // IMPLEMENTED - Make every field unique from user to user.
            $sqlAccount = "Select * from tbluseraccount where username='$uname' or emailadd = '$email'";
            $sqlProfile = "Select * from tbluserprofile where firstname = '$fname' and lastname = '$lname'";
            $resultAccount = mysqli_query($connection, $sqlAccount);
            $resultProfile = mysqli_query($connection, $sqlProfile);
            $countAccount = mysqli_fetch_array($resultAccount, MYSQLI_ASSOC);
            $countProfile = mysqli_fetch_array($resultProfile, MYSQLI_ASSOC);
            if ($countAccount == 0 && $countProfile == 0) {
                //save data to tbluserprofile and tbluseraccount
                if ($confirm == $pword) {
                    $sql1 = "Insert into tbluserprofile(firstname,lastname,gender,birthdate) values('" . $fname . "','" . $lname . "','" . $gen . "','" . $bdate . "')";
                    mysqli_query($connection, $sql1);
                    $hash = password_hash($pword, PASSWORD_DEFAULT);
                    $sql = "Insert into tbluseraccount(emailadd,username,password,usertype) values('" . $email . "','" . $uname . "','" . $hash . "','" . $type . "')";
                    mysqli_query($connection, $sql);
                    echo "<script language='javascript'>
                            window.sessionStorage.setItem('accountCreated', 'true');
                            window.location.replace('login.php');
                      </script>";
                    exit();
                } else {
                    $isError = true;
                    $indicateError = 'Password mismatch.';
                }
            } else {
                $isError = true;
                $indicateError = 'Records of your input details already exist in our database.';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login-register.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Sign Up</title>
</head>
<body>
    <div class="display-container">
        <div class="form-container">

            <div class="register-display-image"></div>

            <div class="register-form">
                <form action="register.php" method="POST" id="registerForm">
                    <?php if(isset($isError)): ?>
                        <div class="mb-3 bg-danger text-white p-2 rounded-3"> <?= $indicateError ?></div>
                    <?php endif; ?>

                    <div class="row my-2">
                        <div class="col">
                            <label for="firstname" class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="John" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : ''; ?>" aria-describedby="firstnameHelp" required>
                        </div>
                        <div class="col">
                            <label for="lastname" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Doe" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : ''; ?>" aria-describedby="lastnameHelp" required>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" name="username" id="username" placeholder="jdoe-12" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" aria-describedby="usernameHelp" required>
                        </div>
                        <div class="col">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="form">
                                <select class="form-select" name="gender" id="gender" aria-label="genderHelp" required>
                                    <option selected disabled>Gender</option>
                                    <option value="male" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'male') echo 'selected="selected"'; ?>>Male</option>
                                    <option value="female" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'female') echo 'selected="selected"'; ?>>Female</option>
                                    <option value="other" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'other') echo 'selected="selected"'; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="fg-margin-top form-group">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" name="birthdate" id="birthdate"  value="<?php echo isset($_POST["birthdate"]) ? $_POST["birthdate"] : ''; ?>" aria-describedby="birthdateHelp" required>
                    </div>

                    <div class="fg-margin-top form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="john.doe@cit.edu" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text email-disclaimer fg-margin-top">Your email will not be shared. User privacy is part of our policy.</div>
                    </div>

                    <div class="row my-2">
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required />
                        </div>
                        <div class="col">
                            <label for="confirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm" id="confirm" value="<?php echo isset($_POST["confirm"]) ? $_POST["confirm"] : ''; ?>" required />
                        </div>
                        <p class="fg-margin-top">Already have an account? <a href="login.php">Sign in</a></p>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>