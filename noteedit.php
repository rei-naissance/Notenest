<?php
include 'connect.php';
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
                    <div>
                        <label for="note" class="form-label">Enter note id: </label>
                        <button type="submit" class="btn btn-primary" name="edit" style="margin-left: 1110px; margin-bottom: 5px">Edit</button>
                        <input type="text" class="form-control" name="note" id="note" placeholder="Nest id number.">
                        <?php
                            $text = "";
                            $title = "";
                            $noteID = "";
                            if(isset($_POST["edit"])){
                                $noteID = $_POST["note"];
                                $sql = "SELECT * FROM tblnote WHERE noteid = '$noteID'";
                                $result = $connection->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        $title=$row["noteTitle"];
                                        $text=$row["noteContent"];
                                    }
                                }
                            }

                            if(isset($_POST["submit"])){
                                $noteID = $_POST["noteID"];
                                $title = $_POST["title"];
                                $text = $_POST["note-text"];
                                $sql = "UPDATE tblnote SET noteTitle = '$title', noteContent = '$text' WHERE noteid = '$noteID'";
                                if(mysqli_query($connection, $sql)){
                                    echo "<script>window.location.href='notedatabase.php'</script>";
                                }
                            }
                        ?>
                    </div>
                    <label for="title" class="form-label">Note Title</label>
                    <input type="hidden" name="noteID" value="<?php echo $noteID; ?>">
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo isset($title)?$title:'';?>"/>
                    <label for="note-text" class="form-label"></label>
                    <textarea class="form-control" name="note-text" id="note-text" rows="3"><?php echo isset($text)?$text:'';?></textarea>
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
has context menu