<?php
    include 'connect.php';

    session_start();

    if(isset($_GET['id'])){

        $text = "";
        $title = "";

        $acc = $_SESSION['acctid'];
        $id = $_GET['id'];

        $sql = "SELECT * FROM tblnest WHERE nestid = '$id' AND acct_id = '$acc'";
        $result = $connection->query($sql);

        if($result -> num_rows > 0){
            while($row = $result->fetch_assoc()){
                $text=$row["nestdescription"];
                $title=$row["nestname"];
            }
        }

        if(isset($_POST["submit"])){
            $newtitle = $_POST["nest"];
            $newtext = $_POST["nest-text"];
            $lastEdit = date('Y-m-d H:i:s');

            $updatesql ="UPDATE tblnest SET nestdescription = '$newtext', nestname = '$newtitle', lastmodified = '$lastEdit' WHERE nestid = '$id' AND acct_id = '$acc'";
            if(mysqli_query($connection, $updatesql)){
                echo "<script language='javascript'>
                    window.location.href = 'notedatabase.php';
                </script>";
                exit();
            }
        }

        if(isset($_POST["delete"])){
            $deletesql = "UPDATE tblnest SET neststatus = 1 WHERE nestid = '$id' AND acct_id = '$acc'";
            if(mysqli_query($connection, $deletesql)){
                echo "<script language='javascript'>
                    window.location.href = 'notedatabase.php';
                </script>";
                exit();
            }
        }

        $noteview = $connection->query("SELECT * from tblnote WHERE acct_id = '$acc' AND notestatus = '0' AND nest_id = '$id' ORDER BY isFavorite DESC, lastmodified DESC");
        $note_rows = $noteview->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href = "css/notedisplay.css">
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
                        <input type="text" class="form-control" name="nest" id="nest" placeholder="Title for nest goes here." value="<?php echo (isset($title))?$title:'';?>">
                        <label for="nest-text" class="form-label"></label>
                        <textarea class="form-control" name="nest-text" id="nest-text" rows="3"><?php echo (isset($text))?$text:''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <a class="btn btn-dark mt-3" href="notedatabase.php">Back</a>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" onclick="return submitNestConfirm()">Save</button>
                    <button type="submit" class="btn btn-primary" name="delete" onclick="return confirm('Are you sure you want to delete this nest?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <?php if (empty($note_rows)): ?>
                <div class="card-body">
                    <p>No notes inside nest.</p>
                </div>
            <?php else: ?>
                <?php foreach ($note_rows as $result): ?>
                    <div class="card clickable-div note" data-id="<?php echo $result['noteid']; ?>">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="note-header">
                                    <h5 class="card-title"><?php echo $result['noteTitle']?></h5>
                                    <form method="post" action="inner_favorite.php" class="fav-button">
                                        <input type="hidden" name="noteId" value="<?php echo $result['noteid']; ?>">
                                        <?php if ($result['isFavorite'] == 0): ?>
                                            <button type="submit" name="setFav" class="btn rounder">&#9734;</button>
                                        <?php else: ?>
                                            <button type="submit" name="unsetFav" class="btn rounder">&#9733;</button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <p class="card-text"><?php echo $result['noteContent']?></p>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="js/loader.js"></script>
<script src="js/confirmation.js"></script>
</body>
</html>