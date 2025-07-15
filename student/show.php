<?php
require_once '../Database.php';
require_once '../Student.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
try{
    $student = new Student();
    $pdo = new Database();
    $pdo = $pdo->connect();
    $students = $student->showUsers();

}catch (PDOException $e){
    die('Database connection error: '.$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
<h2>Student List</h2>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Grade</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= $student['age'] ?></td>
            <td><?= $student['grade'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="../dashboard.php">Dashboard</a>
</body>
</html>
