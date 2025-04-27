<?php
require_once 'db_connection.php';
include 'header.php';

$searchMessage = '';
$studentInfo = null;
$enrollments = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search_student_id'])) {
    $student_id = $conn->real_escape_string($_POST['search_student_id']);
    
    // Get student information
    $studentQuery = "SELECT name, student_id, department FROM students WHERE student_id = '$student_id'";
    $studentResult = $conn->query($studentQuery);
    
    if ($studentResult->num_rows > 0) {
        $studentInfo = $studentResult->fetch_assoc();
        
        // Get enrollment history
        $enrollmentQuery = "SELECT e.course_code, c.course_title, e.semester, e.grade 
                           FROM enrollments e 
                           JOIN courses c ON e.course_code = c.course_code 
                           WHERE e.student_id = '$student_id' 
                           ORDER BY e.semester, e.course_code";
        $enrollments = $conn->query($enrollmentQuery);
    } else {
        $searchMessage = "No student found with ID: $student_id";
    }
}
?>

<div class="container">
    <div class="main-content">
        <h2>Enrollment History</h2>
        
        <div class="search-box">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="search_student_id">Enter Student ID:</label>
                <input type="text" id="search_student_id" name="search_student_id" placeholder="e.g., DIU20230001" required>
                <button type="submit">Search</button>
            </form>
        </div>
        
        <?php if(!empty($searchMessage)): ?>
            <div class="info-message"><?php echo $searchMessage; ?></div>
        <?php endif; ?>
        
        <?php if($studentInfo): ?>
            <div class="student-info">
                <h3>Student Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($studentInfo['name']); ?></p>
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($studentInfo['student_id']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($studentInfo['department']); ?></p>
            </div>
            
            <h3>Enrollment History</h3>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Semester</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($enrollments && $enrollments->num_rows > 0): ?>
                            <?php while($row = $enrollments->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['course_title']); ?></td>
                                <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                <td><?php echo $row['grade'] ? htmlspecialchars($row['grade']) : 'Not available'; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-data">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>