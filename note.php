<?php
    include 'connect.php';

    session_start();

    if(isset($_POST['submit'])) {
        $acc = $_SESSION['acctid'];
        $nest = $_POST['nestgroup'];
        $noteTitle = $_POST['title'];
        $noteText = $_POST['note-text'];
        $status = 0;
        $favorite = 0;
        $noteCategory = $_POST['categ'];
        $date = date('Y-m-d H:i:s');
        $lastEdit = date('Y-m-d H:i:s');

        $note = "Insert into tblnote(acct_id, nest_id, notedate, isFavorite, notecategory, notestatus, lastmodified, noteContent, noteTitle) values('". $acc ."' , '". $nest ."' , '". $date ."' , '". $favorite ."' , '". $noteCategory ."' , '". $status ."' , '". $lastEdit ."' , '". $noteText ."' , '". $noteTitle ."')";
        if(mysqli_query($connection, $note)) {

//            $nest_query = "SELECT presentcategory FROM tblnest WHERE nestid = '$nest'";
//            $nest_result = mysqli_query($connection, $nest_query);
//            $nest_row = mysqli_fetch_assoc($nest_result);
//            $present_category = $nest_row['presentcategory'];
//
//            // Append the new category to the presentcategory
//            if (!empty($present_category)) {
//                $present_category .= ', ' . $noteCategory;
//            } else {
//                $present_category = $noteCategory;
//            }
//
//            // Update tblnest with the updated presentcategory
//            $update_nest = "UPDATE tblnest SET presentcategory = '$present_category' WHERE nestid = '$nest'";
//            mysqli_query($connection, $update_nest);

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
                <form method="POST" id="noteForm">
                    <div class="mb-3">
                        <label for="categ" class="form-label">Note Category</label>
                        <input type="text" class="form-control" name="categ" id="categ" placeholder="Category">
                    </div>
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
//                                $selected = ($row['nestid'] == $id) ? 'selected' : '';
                                echo '<option value="' . $row['nestid'] . '" ' . $selected.'>' . $row['nestname'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <div class="mb-3">
                        <label for="title" class="form-label">Note Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title goes here">
                        <label for="note-text" class="form-label"></label>
                        <textarea class="form-control" name="note-text" id="note-text" rows="3"></textarea>
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