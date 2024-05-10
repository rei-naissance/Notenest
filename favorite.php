<?php
include 'connect.php';

    /*
    $noteId = $_POST['noteId'];
    if (isset($_POST['setFav'])) {
        $sql = "UPDATE tblnote SET isFavorite = 1 WHERE noteid = ?";
    } elseif (isset($_POST['unsetFav'])) {
        $sql = "UPDATE tblnote SET isFavorite = 0 WHERE noteid = ?";
    }
    $statement = $connection->prepare($sql);
    $statement->bind_param("i", $noteId);
    $statement->execute();
    header("Location: notedatabase.php");
    exit();
    */

    $noteId = $_POST['noteId'];
    if (isset($_POST['setFav'])) {
        $sql = "UPDATE tblnote SET isFavorite = 1 WHERE noteid = '$noteId'";
    } elseif (isset($_POST['unsetFav'])) {
        $sql = "UPDATE tblnote SET isFavorite = 0 WHERE noteid = '$noteId'";
    }
    $statement = $connection->prepare($sql);
    $statement->execute();
    header("Location: notedatabase.php");
    exit();
?>
