<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['admin_id'])) {

  if ($_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "data/admin.php";

    $id = $_GET['admin_id'];
    if (removeAdmin($id, $conn)) {
    $sm = "Successfully deleted!";
    header("Location: adm.php?success=$sm");
    exit;
    }else {
    $em = "Unknown error occurred";
    header("Location: adm.php?error=$em");
    exit;
    }

  }else {
    header("Location: adm.php");
    exit;
  } 
}else {
	header("Location: adm.php");
	exit;
} 