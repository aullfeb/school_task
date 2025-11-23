<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {

    include "../../DB_connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = trim($_POST['fname']);
        $lname = !empty($_POST['lname']) ? trim($_POST['lname']) : null;
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (empty($fname) || empty($username) || empty($password)) {
            header("Location: ../adm-add.php?error=All fields are required");
            exit;
        }

        // cek username duplikat
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            header("Location: ../adm-add.php?error=Username already taken");
            exit;
        }

        // hash password
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admin (username, password, fname) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPass, $fname]);

        header("Location: ../adm.php?success=Admin added successfully");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>
