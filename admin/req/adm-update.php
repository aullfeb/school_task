<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "../../DB_connection.php";

        $admin_id = $_POST['admin_id'];
        $fname    = $_POST['fname'];
        $lname    = $_POST['lname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($fname) || empty($username)) {
            header("Location: ../adm-edit.php?admin_id=$admin_id&error=All fields except password are required");
            exit();
        }

        // Cek duplikat username kecuali dirinya sendiri
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND admin_id!=?");
        $stmt->execute([$username, $admin_id]);
        if ($stmt->rowCount() > 0) {
            header("Location: ../adm-edit.php?admin_id=$admin_id&error=Username already taken");
            exit();
        }

        if (!empty($password)) {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET fname=?, lname=?, username=?, password=? WHERE admin_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fname, $lname, $username, $hashedPass, $admin_id]);
        } else {
            $sql = "UPDATE admin SET fname=?, lname=?, username=? WHERE admin_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fname, $lname, $username, $admin_id]);
        }

        header("Location: ../adm.php?success=Admin updated successfully");
        exit();
    }
} else {
    header("Location: ../../login.php");
    exit();
}
?>
