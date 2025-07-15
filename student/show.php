<?php
require_once '../Database.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $db = new Database();
    $pdo = $db->connect();

    // Search filters
    $name = $_GET['name'] ?? '';
    $minGrade = $_GET['min_grade'] ?? '';
    $maxGrade = $_GET['max_grade'] ?? '';

    $sql = "SELECT * FROM students WHERE 1=1";
    $params = [];

    if (!empty($name)) {
        $sql .= " AND name LIKE :name";
        $params[':name'] = '%' . $name . '%';
    }

    if (!empty($minGrade)) {
        $sql .= " AND grade >= :min_grade";
        $params[':min_grade'] = $minGrade;
    }

    if (!empty($maxGrade)) {
        $sql .= " AND grade <= :max_grade";
        $params[':max_grade'] = $maxGrade;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Database connection error: ' . $e->getMessage());
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
            width: 60%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Student List</h2>

<form method="GET" action="">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

    <label>Grade From:</label>
    <input type="number" name="min_grade" step="0.01" value="<?= htmlspecialchars($minGrade) ?>">

    <label>To:</label>
    <input type="number" name="max_grade" step="0.01" value="<?= htmlspecialchars($maxGrade) ?>">

    <button type="submit">Apply Filters</button>
</form>

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
    <?php if (count($students) > 0): ?>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= $student['age'] ?></td>
                <td><?= $student['grade'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No students found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<br>
<a href="../dashboard.php">Back to Dashboard</a>

</body>
</html>