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
        $newnest = $_POST["nestgroup"] == "" ? NULL : $_POST["nestgroup"];
        $lastEdit = date('Y-m-d H:i:s');
        $newcateg = $_POST["note-categ"];

        $updatesql = $connection->prepare(
            "UPDATE tblnote SET noteContent = ?, notecategory = ?, nest_id = IFNULL(?, nest_id), noteTitle = ?, lastmodified = ? WHERE noteid = ? AND acct_id = ?"
        );
        $updatesql->bind_param("ssissii", $newtext, $newcateg, $newnest, $newtitle, $lastEdit, $id, $acc);

        if($updatesql->execute()){
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
                        <input type="text" class="form-control mb-3" name="note" id="note" placeholder="Title for note goes here." value="<?php echo (isset($title))?$title:'';?>">
                        <label for="note-categ" class="form-label">Note Category</label>
                        <input type="text" class="form-control mb-3" name="note-categ" id="note-categ" placeholder="Category for notes goes here." value="<?php echo (isset($categ))?$categ:'';?>">
                        <label for="nestgroup" class="form-label">Nest</label>
                        <select class="form-select mb-3" name="nestgroup" id="nestgroup">
                            <option value="" disabled selected>Select...</option>
                            <?php

                                $acc = $_SESSION['acctid'];
                                $id = $_GET['id'];

                                // getting nest
                                $note_query = "SELECT nest_id FROM tblnote WHERE noteid = '$id' AND acct_id = '$acc'";
                                $note_result = mysqli_query($connection, $note_query);
                                $current_nest_id = 0; // Default value

                                if ($note_result && mysqli_num_rows($note_result) > 0) {
                                    $note_row = mysqli_fetch_assoc($note_result);
                                    $current_nest_id = $note_row['nest_id'];
                                }

                                $nest_query = "SELECT nestid, nestname FROM tblnest WHERE acct_id = '$acc' AND neststatus = 0";
                                $nest_result = mysqli_query($connection, $nest_query);

                                $noNestValue = NULL;
                                echo '<option value="' . $noNestValue . '"' . ($current_nest_id === $noNestValue ? ' selected' : '') . '>No Nest</option>';
                                if ($nest_result && mysqli_num_rows($nest_result) > 0) {
                                    while ($nest_row = mysqli_fetch_assoc($nest_result)) {
                                        $selected = ($nest_row['nestid'] == $current_nest_id) ? 'selected' : '';
                                        echo '<option value="' . $nest_row['nestid'] . '" ' . $selected . '>' . $nest_row['nestname'] . '</option>';
                                    }
                                }

                                $nestNames = array();
                                if ($nest_result && mysqli_num_rows($nest_result) > 0) {
                                    while ($nest_row = mysqli_fetch_assoc($nest_result)) {
                                        $nestNames[$nest_row['nestid']] = $nest_row['nestname'];
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
                    <button type="submit" class="btn btn-primary" name="submit" onclick="return submitConfirm()">Save</button>
                    <button type="submit" class="btn btn-primary" name="delete" onclick="return confirm('Are you sure you want to delete this note?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="js/confirmation.js"></script>

</body>
</html>