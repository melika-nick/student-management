<?php
require_once '../Database.php';
require_once '../Student.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
$message = '';
$id = $_POST['id'] ?? '';

if (isset($_POST['delete'])) {
    if ($id) {
        $pdo = new Database();
        $pdo = $pdo->connect();

        // Check if student exists
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // Delete
            $student = new Student();
            $student->deleteUser($id);
            $message = "Student has been deleted.";
        } else {
            $message = "No student found with this ID.";
        }
    } else {
        $message = "Please enter the ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Student</title>
</head>
<body>
<h2>Delete Student</h2>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="post">
    <label>Student ID:</label>
    <input type="number" name="id" value="<?= htmlspecialchars($id) ?>" required>
    <button type="submit" name="delete">Delete</button>
    <br><br>
    <a href="../dashboard.php">Dashboard</a>
</form>
</body>
</html>
