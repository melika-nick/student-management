<?php
require_once 'Database.php';
class Student
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database)->connect();
    }

    public function addUser($name,$age,$grade)
    {
        $sql = "INSERT INTO students (name,age, grade) VALUES (:name,:age,:grade)";
        $stmt =$this->pdo->prepare($sql);
        $stmt->execute([
            'name'=>$name,
            'age'=>$age,
            'grade'=>$grade
        ]);

    }
    public function updateUser($id, $name,$age,$grade)
    {
        $sql ="UPDATE students SET (name,age,grade) VALUES (:name,:age,:grade) WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id'=>$id,
            'name'=>$name,
            'age'=>$age,
            'grade'=>$grade
        ]);
    }
    public function deleteUser($id)
    {
        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id'=>$id]);
    }
    public function showUsers()
    {
        $sql = "SELECT * FROM students ORDER BY id ASC ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}