<?php
require_once '../Database.php';
require_once '../Student.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
$message = '';
$student = null;
$id = $_POST['id'] ?? null;

// If the update form is submitted:
if (isset($_POST['submit_update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $grade = trim($_POST['grade']);

    try {
        $pdo = new Database();
        $pdo = $pdo->connect();
//        $stu = new Student();
//        $stu->updateUser($id,$name,$age,$grade);
        $sql = "UPDATE students SET name = :name, age = :age, grade = :grade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'age' => $age,
            'grade' => $grade,
            'id' => $id
        ]);

        $message = "✅ Information updated successfully.";
        $student = ['id' => $id, 'name' => $name, 'age' => $age, 'grade' => $grade];
    } catch (PDOException $e) {
        $message = "❌ Error: " . $e->getMessage();
    }
}

// If only the ID form is submitted (to show the edit form)
elseif (isset($_POST['submit_id'])) {
    $id = $_POST['id'];

    try {
        $pdo = new Database();
        $pdo = $pdo->connect();

        $sql = "SELECT * FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            $message = "❌ No student found with this ID.";
        }
    } catch (PDOException $e) {
        $message = "❌ Error retrieving information: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
</head>
<body>
<h2>Edit Student</h2>

<?php if ($message): ?>
    <p style="color: <?= str_starts_with($message, '✅') ? 'green' : 'red' ?>"><?= $message ?></p>
<?php endif; ?>

<!-- Initial form to enter ID -->
<?php if (!$student): ?>
    <form method="post">
        <label>Student ID:</label>
        <input type="number" name="id" required>
        <button type="submit" name="submit_id">Search</button>
    </form>
<?php endif; ?>

<?php if ($student): ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']) ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        <br><br>

        <label>Age:</label>
        <input type="number" name="age" value="<?= htmlspecialchars($student['age']) ?>">
        <br><br>

        <label>GPA:</label>
        <input type="text" name="grade" value="<?= htmlspecialchars($student['grade']) ?>">
        <br><br>

        <button type="submit" name="submit_update">Update</button>
        <br><br>
        <a href="../dashboard.php">Dashboard</a>
    </form>
<?php endif; ?>
</body>
</html>
