<?php
include 'connect.php';
$noteview = $connection->query("SELECT * from tblnote");
$nestview = $connection->query("SELECT * from tblnest");
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
    <title>Notes</title>
</head>
<body>

<?php
include ("includes/header.php");
?>

<section class="min-vh-100 d-flex align-items-center">
    <div class="container">
        <a class="btn btn-dark mb-3" href="nest.php">Add a nest</a>
        <a class="btn btn-dark mb-3" href="nestedit.php">Edit a nest</a>
        <?php while($nestResult = $nestview->fetch_assoc()):?>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="card-id"><?php echo $nestResult['nestid']?></p>
                        <h5 class="card-title"><?php echo $nestResult['nestname']?></h5>
                        <h6 class="card-text"><?php echo $nestResult['presentcategory']?></h6>
                        <p class="card-text"><?php echo $nestResult['nestdescription']?></p>
                    </div>
                </div>
            </div>
            <br>
        <?php endwhile;?>
    </div>
    <div class="container">
        <a class="btn btn-dark mb-3" href="note.php">Add a note</a>
        <a class="btn btn-dark mb-3" href="noteedit.php">Edit a note</a>
        <?php while($result = $noteview->fetch_assoc()):?>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="card-id"><?php echo $result['noteid']?></p>
                        <h5 class="card-title"><?php echo $result['noteTitle']?></h5>
                        <p class="card-text"><?php echo $result['noteContent']?></p>
                    </div>
                </div>
            </div>
            <br>
        <?php endwhile;?>
    </div>
</section>
</body>
</html>