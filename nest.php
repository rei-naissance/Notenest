<?php
    include 'connect.php';

    session_start();

    if(isset($_POST['submit'])) {
        $acc = $_SESSION['acctid'];
        $name = $_POST['nest'];
        $desc = $_POST['nest-text'];
        $date = date('Y-m-d H:i:s');
        $lastEdit = date('Y-m-d H:i:s');

        $nest = "Insert into tblnest(acct_id, nestname, nestdescription, datemade, lastmodified) values('". $acc ."' , '". $name ."' , '". $desc ."' , '". $date ."' , '". $lastEdit ."')";
        if(mysqli_query($connection, $nest)){
            echo "<script language='javascript'>
                    window.location.href = 'notedatabase.php';
                </script>";
            exit();
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
    <link rel="stylesheet" href = "css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Notenest</title>
</head>
<body>

<?php
include ("includes/header.php");
?>

<section class="min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="nestForm">
                    <div class="mb-3">
                        <label for="nest" class="form-label">Nest Name</label>
                        <input type="text" class="form-control" name="nest" id="nest" placeholder="Title for nest goes here.">
                        <label for="nest-text" class="form-label"></label>
                        <textarea class="form-control" name="nest-text" id="nest-text" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <a class="btn btn-dark mt-3" href="notedatabase.php">View All Notes</a>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>