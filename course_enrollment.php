<?php
require_once 'db_connection.php';
include 'header.php';

$message = '';
$error = '';

// Fetch all available courses for dropdown
$coursesQuery = "SELECT course_code, course_title FROM courses ORDER BY course_code";
$coursesResult = $conn->query($coursesQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['student_id']) || empty($_POST['course_code'])) {
        $error = "Student ID and Course Code are required fields";
    } else {
        // Sanitize inputs
        $student_id = $conn->real_escape_string($_POST['student_id']);
        $course_code = $conn->real_escape_string($_POST['course_code']);
        $course_title = $conn->real_escape_string($_POST['course_title']);
        $semester = $conn->real_escape_string($_POST['semester']);
        
        // Check if student exists
        $check_student = $conn->query("SELECT * FROM students WHERE student_id = '$student_id'");
        
        if ($check_student->num_rows == 0) {
            $error = "Student ID does not exist. Please enter a valid Student ID.";
        } else {
            // Check if course exists
            $check_course = $conn->query("SELECT * FROM courses WHERE course_code = '$course_code'");
            
            if ($check_course->num_rows == 0) {
                $error = "Course Code does not exist. Please enter a valid Course Code.";
            } else {
                // Check if student is already enrolled in this course for this semester
                $check_enrollment = $conn->query("SELECT * FROM enrollments WHERE student_id = '$student_id' AND course_code = '$course_code' AND semester = '$semester'");
                
                if ($check_enrollment->num_rows > 0) {
                    $error = "Student is already enrolled in this course for the selected semester.";
                } else {
                    // Insert enrollment data
                    $sql = "INSERT INTO enrollments (student_id, course_code, semester) VALUES ('$student_id', '$course_code', '$semester')";
                    
                    if ($conn->query($sql) === TRUE) {
                        $message = "Student enrolled successfully!";
                        // Clear form data on successful submission
                        $_POST = array();
                    } else {
                        $error = "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }
    }
}
?>

<div class="container">
    <?php if(!empty($message)): ?>
        <div class="success-message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if(!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="form-panel">
        <h2>Enroll in a Course</h2>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter Student ID" value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="course_code">Course Code:</label>
                <input type="text" id="course_code" name="course_code" placeholder="Enter Course Code" value="<?php echo isset($_POST['course_code']) ? htmlspecialchars($_POST['course_code']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="course_title">Course Title:</label>
                <input type="text" id="course_title" name="course_title" placeholder="Enter Course Title" value="<?php echo isset($_POST['course_title']) ? htmlspecialchars($_POST['course_title']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select id="semester" name="semester">
                    <option value="">Select Semester</option>
                    <option value="Spring 2025" <?php if(isset($_POST['semester']) && $_POST['semester'] == 'Spring 2025') echo 'selected'; ?>>Spring 2025</option>
                    <option value="Summer 2025" <?php if(isset($_POST['semester']) && $_POST['semester'] == 'Summer 2025') echo 'selected'; ?>>Summer 2025</option>
                    <option value="Fall 2025" <?php if(isset($_POST['semester']) && $_POST['semester'] == 'Fall 2025') echo 'selected'; ?>>Fall 2025</option>
                    <option value="Spring 2026" <?php if(isset($_POST['semester']) && $_POST['semester'] == 'Spring 2026') echo 'selected'; ?>>Spring 2026</option>
                </select>
            </div>
            
            <button type="submit">Enroll</button>
        </form>
    </div>
</div>

</body>
</html>