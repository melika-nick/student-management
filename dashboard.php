<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
    <form action="check_login.php" method="post">
        <a href="./student/show.php">View Student List</a>
        <br><br>
        <a href="./student/create.php">Add New Student</a>
        <br><br>
        <a href="./student/update.php">Edit Student Information</a>
        <br><br>
        <a href="./student/delete.php">Delete Student from System</a>
        <br><br>
        <a href ="./report.php">Student Report</a>
        <br><br><br><br>
        <a href="./profile.php">change my password</a>
        <br><br><br><br>
        <a href="./logout.php">log out</a>

    </form>
</body>
</html>
