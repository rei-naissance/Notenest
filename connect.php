<?php
$connection = new mysqli('localhost', 'root','','dbdaelf3');

if (!$connection){
    die (mysqli_error($connection));
}

?>