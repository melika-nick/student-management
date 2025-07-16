<?php
require_once './Database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

try {
    $db = new Database();
    $pdo = $db->connect();

    // total students : 
    $stmt1 = $pdo->query("SELECT COUNT(*) AS total FROM students");
    $totalStudents = $stmt1->fetch()['total'];

    // average grade :
    $stmt2 = $pdo->query("SELECT AVG(grade) AS avg_grade FROM students");
    $avgGrade = round($stmt2->fetch()['avg_grade'], 2);

    // age groups :
    $stmt3 = $pdo->query("
        SELECT 
            SUM(CASE WHEN age < 15 THEN 1 ELSE 0 END) AS under_15,
            SUM(CASE WHEN age BETWEEN 15 AND 18 THEN 1 ELSE 0 END) AS between_15_18,
            SUM(CASE WHEN age > 18 THEN 1 ELSE 0 END) AS over_18
        FROM students
    ");
    $ageGroups = $stmt3->fetch();

} catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Reports</title>
</head>
<body>
    <h2> Student Statistics Report</h2>

    <ul>
        <li><strong>Total students:</strong> <?= $totalStudents ?></li>
        <li><strong>Average grade:</strong> <?= $avgGrade ?></li>
    </ul>

    <h3>Age Groups:</h3>
    <ul>
        <li>Under 15: <?= $ageGroups['under_15'] ?></li>
        <li>Between 15 and 18: <?= $ageGroups['between_15_18'] ?></li>
        <li>Over 18: <?= $ageGroups['over_18'] ?></li>
    </ul>

    <a href="./dashboard.php"> Back to dashboard</a>
</body>
</html>
