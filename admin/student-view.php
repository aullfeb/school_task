<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
  isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "data/student.php";
    include "data/subject.php";
    include "data/grade.php";
    include "data/section.php";

    if(isset($_GET['student_id'])){

    $student_id = $_GET['student_id'];

    $student = getStudentById($student_id, $conn);    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student - Teachers</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/teacher.css">
	<link rel="icon" href="../logo2.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php 
    include "inc/navbar.php";
    if ($student != 0) {
  ?>
  <div class="container mt-5">
    <div class="teacher-card shadow p-4">
      <div class="teacher-info">
        <!-- info -->
        <h3 class="mb-3"><?= $student['fname']." ".$student['lname']; ?></h3>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">First name: <?=$student['fname']?></li>
          <li class="list-group-item">Last name: <?=$student['lname']?></li>
          <li class="list-group-item">Username: <?=$student['username']?></li>
          <li class="list-group-item">Address: <?=$student['address']?></li>
          <li class="list-group-item">Date of birth: <?=$student['date_of_birth']?></li>
          <li class="list-group-item">Email address: <?=$student['email_address']?></li>
          <li class="list-group-item">Gender: <?=$student['gender']?></li>
          <li class="list-group-item">Date of joined: <?=$student['date_of_joined']?></li>
          <li class="list-group-item">Grade: 
            <?php 
              $grade = $student['grade'];
              $g = getGradeById($grade, $conn);
              echo $g['grade_code'].'-'.$g['grade'];
            ?>
          </li>
          <li class="list-group-item">Section: 
            <?php 
              $section = $student['section'];
              $s = getSectioById($section, $conn);
              echo $s['section'];
            ?>
          </li>
          <br>
          <li class="list-group-item">Parent first name: <?=$student['parent_fname']?></li>
          <li class="list-group-item">Parent last name: <?=$student['parent_lname']?></li>
          <li class="list-group-item">Parent phone number: <?=$student['parent_phone_number']?></li>
        </ul>
        <div class="mt-3 d-flex justify-content-end">
          <a href="student.php" class="btn btn-secondary">Go Back</a>
        </div>
      </div>

      <!-- foto -->
      <div class="teacher-photo text-center">
        <img src="../img/student-<?=$student['gender']?>.png" class="rounded-circle mb-2" alt="Student">
          <h5>@<?=$student['username']?></h5>
      </div>
    </div>
  </div>

  <?php 
    }else {
      header("Location: teacher.php");
      exit;
    }
  ?>
     
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
  <script>
    $(document).ready(function(){
      $("#navLinks li:nth-child(3) a").addClass('active');
    });
  </script>

</body>
</html>

<?php 
  }else {
    header("Location: student.php");
    exit;
  }

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>