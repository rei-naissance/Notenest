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

    <table class="table">
        <tr>
            <th colspan="3" scope="col">Existing Accounts</th>
        </tr>
        <tr>
            <th scope="col">Account ID</th>
            <th scope="col">Email</th>
            <th scope="col">Username</th>
        </tr>

        <?php
            $userview = $connection->query("SELECT acctid, emailadd, username from tbluseraccount");
            while($row = $userview->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['acctid'] . "</td>";
                echo "<td>" . $row['emailadd'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>

    <table class="table">
        <tr>
            <th scope="col" colspan="4">Notes Within Database</th>
        </tr>

        <tr>
            <th scope="col">Note ID</th>
            <th scope="col">Date</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
        </tr>
        <tr>
            <?php
            $userview = $connection->query("SELECT noteid, notedate, noteTitle, noteContent from tblnote");
            while($row = $userview->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['noteid'] . "</td>";
                echo "<td>" . $row['notedate'] . "</td>";
                echo "<td>" . $row['noteTitle'] . "</td>";
                echo "<td>" . $row['noteContent'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tr>
    </table>

</body>
</html>