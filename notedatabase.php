<?php
    include 'connect.php';

    session_start();

    $acc = $_SESSION['acctid'];

    $noteview = $connection->query("SELECT * from tblnote WHERE acct_id = '$acc' AND notestatus = '0' AND nest_id IS NULL ORDER BY isFavorite DESC, lastmodified DESC");
    $nestview = $connection->query("SELECT * from tblnest WHERE acct_id = '$acc' AND neststatus = '0' ORDER BY isFavorite DESC, lastmodified DESC");

    $nest_rows = $nestview->fetch_all(MYSQLI_ASSOC);
    $note_rows = $noteview->fetch_all(MYSQLI_ASSOC);

    $nest_url = '';
    $note_url = '';

    if (!empty($nest_rows)) {
        $nest_url = "nestedit.php?id=" . $nest_rows[0]['nestid'];
    }

    if (!empty($note_rows)) {
        $note_url = "noteedit.php?id=" . $note_rows[0]['noteid'];
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
    <title>Notes</title>
</head>
<body>

<?php
    include ("includes/header.php");
?>

<section class="min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col">
                <a class="btn btn-dark mb-3" href="nest.php">Add a nest</a>
                <?php foreach ($nest_rows as $nestResult): ?>
                    <div class="card clickable-div nest" data-id="<?php echo $nestResult['nestid']; ?>">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="note-header">
                                    <h5 class="card-title"><?php echo $nestResult['nestname']?></h5>
                                    <form method="post" action="favorite.php" class="fav-button">
                                        <input type="hidden" name="nestId" value="<?php echo $nestResult['nestid']; ?>">
                                        <?php if ($nestResult['isFavorite'] == 0): ?>
                                            <button type="submit" name="setNestFav" class="btn rounder">&#9734;</button>
                                        <?php else: ?>
                                            <button type="submit" name="unsetNestFav" class="btn rounder">&#9733;</button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <p class="card-text"><?php echo $nestResult['nestdescription']?></p>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
            <div class="col">
                <a class="btn btn-dark mb-3" href="note.php">Add a note</a>
                <?php foreach ($note_rows as $result): ?>
                    <div class="card clickable-div note" data-id="<?php echo $result['noteid']; ?>">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="note-header">
                                    <h5 class="card-title"><?php echo $result['noteTitle']?></h5>
                                    <form method="post" action="favorite.php" class="fav-button">
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
            </div>
        </div>
    </div>
</section>

    <script src="js/loader.js"></script>
</body>
</html>