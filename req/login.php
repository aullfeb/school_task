<?php 
session_start();

if (isset($_POST['uname']) &&
    isset($_POST['pass']) &&
    isset($_POST['role'])) {

    include "../DB_connection.php";
    
    $uname = $_POST['uname'];
    $pass  = $_POST['pass'];
    $role_input = $_POST['role'];

    if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($role_input)) {
        $em  = "An error Occurred";
        header("Location: ../login.php?error=$em");
        exit;
    } else {

        if ($role_input == '1') {
            $sql = "SELECT * FROM admin WHERE username = ?";
            $role_name = "Admin";
        } else if ($role_input == '2') {
            $sql = "SELECT * FROM teachers WHERE username = ?";
            $role_name = "Teacher";
        } else if ($role_input == '3') {
            $sql = "SELECT * FROM students WHERE username = ?";
            $role_name = "Student";
        } else if ($role_input == '4') {
            $sql = "SELECT * FROM registrar_office WHERE username = ?";
            $role_name = "Registrar Office";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $username = $user['username'];
            $password = $user['password'];
            
            if ($username === $uname && password_verify($pass, $password)) {
                $_SESSION['role'] = $role_name;

                if ($role_name == 'Admin') {
                    $_SESSION['admin_id'] = $user['admin_id'];
                    header("Location: ../admin/index.php");
                    exit;
                } else if ($role_name == 'Teacher') {
                    $_SESSION['teacher_id'] = $user['teacher_id'];
                    header("Location: ../Teacher/index.php");
                    exit;
                } else if ($role_name == 'Student') {
                    $_SESSION['student_id'] = $user['student_id'];
                    header("Location: ../Student/index.php");
                    exit;
                } else if ($role_name == 'Registrar Office') {
                    $_SESSION['r_user_id'] = $user['r_user_id'];
                    header("Location: ../RegistrarOffice/index.php");
                    exit;
                }
            } else {
                $em  = "Incorrect Username or Password";
                header("Location: ../login.php?error=$em");
                exit;
            }
        } else {
            $em  = "Incorrect Username or Password";
            header("Location: ../login.php?error=$em");
            exit;
        }
    }
} else {
    header("Location: ../login.php");
    exit;
}
