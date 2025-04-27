<?php
// Get current page filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentManager - Student Registration System</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome for the graduation cap icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="navbar clearfix">
        <div class="logo">
            <i class="fas fa-graduation-cap icon"></i> StudentManager
        </div>
        <div class="nav-links">
            <a href="index.php" <?php if($currentPage == 'index.php') echo 'style="background-color: #222;"'; ?>>Add Student</a>
            <a href="student_list.php" <?php if($currentPage == 'student_list.php') echo 'style="background-color: #222;"'; ?>>Student List</a>
            <a href="course_enrollment.php" <?php if($currentPage == 'course_enrollment.php') echo 'style="background-color: #222;"'; ?>>Enroll in Course</a>
            <a href="enrollment_history.php" <?php if($currentPage == 'enrollment_history.php') echo 'style="background-color: #222;"'; ?>>Enrollment History</a>
        </div>
    </div>