<?php
    include 'connect.php';

    $sql1 = "SELECT ua.acctid, up.firstname, up.lastname, up.gender, up.birthdate
             FROM tbluseraccount ua
             JOIN tbluserprofile up ON ua.acctid = up.userid";
    $result1 = $connection->query($sql1);

    $sql2 = "SELECT ua.acctid, ua.emailadd, ua.username, COUNT(CASE WHEN n.noteid IS NOT NULL THEN 1 END) AS note_count
             FROM tbluseraccount ua
             LEFT JOIN tblnote n ON ua.acctid = n.acct_id AND n.notestatus = 0
             GROUP BY ua.acctid, ua.emailadd, ua.username";
    $result2 = $connection->query($sql2);

    $sql3 = "SELECT ua.username, COUNT(n.noteid) AS note_count
             FROM tbluseraccount ua
             LEFT JOIN tblnote n ON ua.acctid = n.acct_id
             WHERE n.notestatus = 0
             GROUP BY ua.username
             HAVING note_count >= 5
             ORDER BY note_count ASC";
    $result3 = $connection->query($sql3);

$sql4 = "SELECT n.acct_id, COUNT(n.noteid) AS total_notes 
         FROM tblnote n
         WHERE n.notestatus = 0";
    $result4 = $connection->query($sql4);

    $sql5 = "SELECT n.acct_id, COUNT(n.nestid) AS total_nests
             FROM tblnest n";
    $result5 = $connection->query($sql5);

    $sql6 = "SELECT ua.acctid, COUNT(ua.acctid) AS total_accounts
             FROM tbluseraccount ua";
    $result6 = $connection->query($sql6);

    $sql7 = "SELECT AVG(NumberofNotes) AS avgNotesPerNest
             FROM (
             SELECT nest_id, COUNT(*) AS NumberofNotes
             FROM tblnote WHERE nest_id IS NOT NULL
             GROUP BY nest_id
             ) AS notesPerNest";
    $result7 = $connection->query($sql7);
    $data = $result7->fetch_assoc();
    $averageNotesPerNest = $data['avgNotesPerNest'];

    $sql8 = "SELECT AVG(NumberofNotes) AS avgNotesPerAccount
             FROM (
             SELECT acct_id, COUNT(*) AS NumberofNotes
             FROM tblnote
             GROUP BY acct_id
             ) AS notesPerAccount";
    $result8 = $connection->query($sql8);
    $data = $result8->fetch_assoc();
    $averageNotesPerAccount = $data['avgNotesPerAccount'];
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
            <th>Email</th>
            <th>Username</th>
            <th>Notes</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result2->fetch_assoc()) {
                echo "<tr>
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
            echo "<tr><td>{$averageNotesPerNest}</td></tr>"
        ?>

        <tr>
            <th>Average notes within an account</th>
        </tr>
        <?php
            echo"<tr><td>{$averageNotesPerAccount}</td></tr>"
        ?>
        </tbody>
    </table>
    <div>
        <h2>Chart</h2>
        <img src="images/meta-chart-new.png">
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>