<?php
require_once '../Database.php';
require_once '../Student.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $age = isset($_POST['age']) ? trim($_POST['age']) : '';
    $grade = isset($_POST['grade']) ? trim($_POST['grade']) : '';
    try {
        $student = new Student();
        $pdo = new Database();
        $pdo = $pdo->connect();
        $student->addUser($name,$age,$grade);

    } catch (PDOException $e) {
        die('Database connection error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
</head>
<body>
    <h2>Add New Student</h2>
    <form action="" method="post">
        <label>Name</label>
        <input type="text" name="name" required>
        <br><br>
        <label>Age</label>
        <input type="text" name="age">
        <br><br>
        <label>GPA</label>
        <input type="text" name="grade">
        <br><br>
        <button type="submit">Submit</button>
        <br><br>
        <a href="../dashboard.php">Dashboard</a>
    </form>
</body>
</html>
