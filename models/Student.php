<?php

class Student
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // READ ONE STUDENT
    public function getStudentById($id)
    {
        $sql = "SELECT * FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // LOGIN
    public function getStudentByNric($nric)
    {
        $sql = "SELECT * FROM students WHERE nric = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nric]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ ALL
    public function getAllStudents()
    {
        $sql = "SELECT * FROM students ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function addStudent($name, $nric, $program, $marks, $password)
    {
        $sql = "INSERT INTO students
                (name, nric, program, marks, password)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $name,
            $nric,
            $program,
            $marks,
            $password
        ]);
    }

    // UPDATE
    public function updateStudent(
        $id,
        $name,
        $nric,
        $program,
        $marks
    ) {
        $sql = "UPDATE students
                SET name = ?,
                    nric = ?,
                    program = ?,
                    marks = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $name,
            $nric,
            $program,
            $marks,
            $id
        ]);
    }

    // DELETE
    public function deleteStudent($id)
    {
        $sql = "DELETE FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }

    // UPDATE PASSWORD
    public function updatePassword($id, $password)
    {
        $sql = "UPDATE students
                SET password = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $password,
            $id
        ]);
    }

    // UPDATE PROFILE PICTURE (TAMBAHAN UNTUK MINI PROJECT 2)
    public function updateProfilePic($id, $profile_pic)
    {
        $sql = "UPDATE students
                SET profile_pic = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $profile_pic,
            $id
        ]);
    }
}

?>