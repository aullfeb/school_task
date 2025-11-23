<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
      include "../DB_connection.php";
      include "data/teacher.php";
      include "data/subject.php";
      include "data/grade.php";
      include "data/section.php";
      include "data/class.php";

      if(isset($_GET['teacher_id'])){
      $teacher_id = $_GET['teacher_id'];
      $teacher = getTeacherById($teacher_id,$conn);    
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Teachers</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/teacher.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo2.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php 
    include "inc/navbar.php";
    if ($teacher != 0) {
  ?>
  <div class="container mt-5">
    <div class="teacher-card shadow p-4">
      <div class="teacher-info">
        <h3 class="mb-3"><?= $teacher['fname']." ".$teacher['lname']; ?></h3>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><b>Username:</b> <?= $teacher['username']?></li>
          <li class="list-group-item"><b>Employee number:</b> <?= $teacher['employee_number']?></li>
          <li class="list-group-item"><b>Address:</b> <?= $teacher['address']?></li>
          <li class="list-group-item"><b>Date of birth:</b> <?= $teacher['date_of_birth']?></li>
          <li class="list-group-item"><b>Phone number:</b> <?= $teacher['phone_number']?></li>
          <li class="list-group-item"><b>Qualification:</b> <?= $teacher['qualification']?></li>
          <li class="list-group-item"><b>Email address:</b> <?= $teacher['email_address']?></li>
          <li class="list-group-item"><b>Gender:</b> <?= $teacher['gender']?></li>
          <li class="list-group-item"><b>Date of joined:</b> <?= $teacher['date_of_joined']?></li>
          <li class="list-group-item"><b>Subject:</b> 
            <?php 
              $s = '';
              $subjects = str_split(trim($teacher['subjects']));
              foreach ($subjects as $subject) {
                $s_temp = getSubjectById($subject, $conn);
                if ($s_temp != 0) 
                  $s .=$s_temp['subject_code'].', ';
              }
              echo rtrim($s, ', ');
            ?>
          </li>
          <li class="list-group-item"><b>Grade & Class:</b> 
            <?php 
              $c = '';
              $classes = str_split(trim($teacher['class']));
              foreach ($classes as $class_id) {
                $class = getClassById($class_id, $conn);
                $c_temp = getGradeById($class['grade'], $conn);
                $section = getSectioById($class['section'], $conn);
                if ($c_temp != 0) 
                  $c .=$c_temp['grade_code'].'-'.$c_temp['grade'].$section['section'].', ';
              }
              echo rtrim($c, ', ');
            ?>
          </li>
        </ul>
        <div class="mt-3 d-flex justify-content-end">
          <a href="teacher.php" class="btn btn-secondary">Go Back</a>
        </div>
      </div>

      <div class="teacher-photo text-center">
        <img src="../img/teacher-<?=$teacher['gender']?>.png" alt="Teacher" class="rounded-circle mb-2">
        <h5>@<?=$teacher['username']?></h5>
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
      $("#navLinks li:nth-child(2) a").addClass('active');
    });
  </script>
</body>
</html>

<?php 
  }else {
    header("Location: teacher.php");
    exit;
  } 

  }else {
    header("Location: ../login.php");
    exit;
  } 
} else {
    header("Location: ../login.php");
    exit;
  }

?>
