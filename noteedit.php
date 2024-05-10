<?php
include 'connect.php';

session_start();


if(isset($_GET['id'])){

    $text = "";
    $title = "";
    $categ = "";

    $acc = $_SESSION['acctid'];
    $id = $_GET['id'];

    $sql = "SELECT * FROM tblnote WHERE noteid = '$id' AND acct_id = '$acc'";
    $result = $connection->query($sql);

    if($result -> num_rows > 0){
        while($row = $result->fetch_assoc()){
            $text=$row["noteContent"];
            $title=$row["noteTitle"];
            $categ=$row["notecategory"];
        }
    }

    if(isset($_POST["submit"])){
        $newtitle = $_POST["note"];
        $newtext = $_POST["note-text"];
        $newnest = $_POST["nestgroup"];
        $newcateg = $_POST["note-categ"];
        $updatesql ="UPDATE tblnote SET noteContent = '$newtext', notecategory = '$newcateg', nest_id = '$newnest', noteTitle = '$newtitle' WHERE noteid = '$id' AND acct_id = '$acc'";
        if(mysqli_query($connection, $updatesql)){
            echo "<script language='javascript'>
                    window.location.href = 'notedatabase.php';
                </script>";
            exit();
        }
    }

    if(isset($_POST["delete"])){
        $deletesql = "UPDATE tblnote SET notestatus = 1 WHERE noteid = '$id' AND acct_id = '$acc'";
        if(mysqli_query($connection, $deletesql)){
            echo "<script language='javascript'>
                    window.location.href = 'notedatabase.php';
                </script>";
            exit();
        }
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
                <form method="POST" id="noteForm">
                    <div class="mb-3">
                        <label for="note" class="form-label">Note Title</label>
                        <input type="text" class="form-control" name="note" id="note" placeholder="Title for note goes here." value="<?php echo (isset($title))?$title:'';?>">
                        <label for="note-categ" class="form-label">Note Category</label>
                        <input type="text" class="form-control" name="note-categ" id="note-categ" placeholder="Category for notes goes here." value="<?php echo (isset($categ))?$categ:'';?>">
                        <label for="nestgroup" class="form-label">Nest</label>
                        <select name="nestgroup" id="nestgroup">
                            <option value="" disabled selected>Select...</option>
                            <?php

                                $acc = $_SESSION['acctid'];
                                $id = $_GET['id'];

                                $query = "SELECT nestid, nestname FROM tblnest WHERE acct_id = '$acc'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['nestid'] == $id) ? 'selected' : '';
                                        echo '<option value="' . $row['nestid'] . '" ' . $selected.'>' . $row['nestname'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <label for="note-text" class="form-label"></label>
                        <textarea class="form-control" name="note-text" id="note-text" rows="3"><?php echo (isset($text))?$text:''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <a class="btn btn-dark mt-3" href="notedatabase.php">Back</a>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" onclick="return confirm('Are you sure you want to proceed with these changes?')">Save</button>
                    <button type="submit" class="btn btn-primary" name="delete" onclick="return confirm('Are you sure you want to delete this note?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>