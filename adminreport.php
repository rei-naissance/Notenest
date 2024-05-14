<?php
    include 'connect.php';

    $sql1 = "SELECT ua.acctid, up.firstname, up.lastname, up.gender, up.birthdate
             FROM tbluseraccount ua
             JOIN tbluserprofile up ON ua.acctid = up.userid";
    $result1 = $connection->query($sql1);

    $sql2 = "SELECT ua.acctid, ua.emailadd, ua.username, COUNT(n.noteid) AS note_count
             FROM tbluseraccount ua
             LEFT JOIN tblnote n ON ua.acctid = n.acct_id
             GROUP BY ua.acctid, ua.emailadd, ua.username";
    $result2 = $connection->query($sql2);

    $sql3 = "SELECT ua.username, COUNT(n.noteid) AS note_count
             FROM tbluseraccount ua
             LEFT JOIN tblnote n ON ua.acctid = n.acct_id
             GROUP BY ua.username
             HAVING note_count >= 5
             ORDER BY note_count DESC";
    $result3 = $connection->query($sql3);

    $sql4 = "SELECT n.acct_id, COUNT(n.noteid) AS total_notes 
             FROM tblnote n";
    $result4 = $connection->query($sql4);

    $sql5 = "SELECT n.acct_id, COUNT(n.nestid) AS total_nests
             FROM tblnest n";
    $result5 = $connection->query($sql5);

    $sql6 = "SELECT ua.acctid, COUNT(ua.acctid) AS total_accounts
             FROM tbluseraccount ua";
    $result6 = $connection->query($sql6);

    $sql7 = "SELECT n.nest_id, CEIL(AVG(n.noteid)) AS average_notes_nest
             FROM tblnote n";
    $result7 = $connection->query($sql7);

    $sql8 = "SELECT n.acct_id, CEIL(AVG(n.noteid)) AS average_notes_account
             FROM tblnote n";
    $result8 = $connection->query($sql8);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Present User Information</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Account ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birthdate</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result1->fetch_assoc()) {
                echo "<tr>
                                <td>{$row['acctid']}</td>
                                <td>{$row['firstname']}</td>
                                <td>{$row['lastname']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['birthdate']}</td>
                              </tr>";
            }
        ?>
        </tbody>
    </table>

    <h2>Account Details</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Account ID</th>
            <th>Email</th>
            <th>Username</th>
            <th>Notes</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result2->fetch_assoc()) {
                echo "<tr>
                                <td>{$row['acctid']}</td>
                                <td>{$row['emailadd']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['note_count']}</td>
                              </tr>";
            }
        ?>
        </tbody>
    </table>

    <h2>Accounts with more than 5 notes</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Username</th>
            <th>Notes</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result3->fetch_assoc()) {
                echo "<tr>
                                <td>{$row['username']}</td>
                                <td>{$row['note_count']}</td>
                              </tr>";
            }
        ?>
        </tbody>
    </table>

    <h2>Statistics</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Total Accounts</th>
        </tr>
        <?php
            while($row = $result6->fetch_assoc()) {
                echo"<tr><td>{$row['total_accounts']}</td></tr>";
            }
        ?>
        </thead>
        <tbody>
        <tr>
            <th>Total Notes</th>
        </tr>
        <?php
            while($row = $result4->fetch_assoc()) {
                echo "<tr>
                                <td>{$row['total_notes']}</td>
                              </tr>";
                }
        ?>
        <tr>
            <th>Total Nests</th>
        </tr>
        <?php
            while($row = $result5->fetch_assoc()) {
                echo"<tr><td>{$row['total_nests']}</td></tr>";
            }
        ?>
        <tr>
            <th>Average notes within a nest</th>
        </tr>
        <?php
            while($row = $result7->fetch_assoc()) {
                echo"<tr><td>{$row['average_notes_nest']}</td></tr>";
            }
        ?>

        <tr>
            <th>Average notes within an account</th>
        </tr>
        <?php
        while($row = $result8->fetch_assoc()) {
            echo"<tr><td>{$row['average_notes_account']}</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <div>
        <h2>Chart</h2>
        <img src="images/meta-chart.png">
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>