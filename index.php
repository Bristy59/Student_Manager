<?php
require_once 'db_connection.php';
include 'header.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email'])) {
        $error = "Name and Email are required fields";
    } else {
        // Sanitize inputs
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $student_id = $conn->real_escape_string($_POST['student_id']);
        $department = $conn->real_escape_string($_POST['department']);
        $major = $conn->real_escape_string($_POST['major']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $address = $conn->real_escape_string($_POST['address']);
        
        // Generate a student ID if not provided
        if (empty($student_id)) {
            $student_id = 'DIU' . date('Y') . rand(1000, 9999);
        }
        
        // Check if email already exists
        $check_email = $conn->query("SELECT * FROM students WHERE email = '$email'");
        
        if ($check_email->num_rows > 0) {
            $error = "Email already exists. Please use a different email.";
        } else {
            // Insert data into database
            $sql = "INSERT INTO students (student_id, name, email, department, major, date_of_birth, address) 
                    VALUES ('$student_id', '$name', '$email', '$department', '$major', '$dob', '$address')";
            
            if ($conn->query($sql) === TRUE) {
                $message = "Student registered successfully!";
                // Clear form data on successful submission
                $_POST = array();
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
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
        <h2>Register New Student</h2>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter student name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="department">Department:</label>
                <select id="department" name="department">
                    <option value="">Select department</option>
                    <option value="Computer Science & Engineering" <?php if(isset($_POST['department']) && $_POST['department'] == 'Computer Science & Engineering') echo 'selected'; ?>>Computer Science & Engineering</option>
                    <option value="Electrical & Electronic Engineering" <?php if(isset($_POST['department']) && $_POST['department'] == 'Electrical & Electronic Engineering') echo 'selected'; ?>>Electrical & Electronic Engineering</option>
                    <option value="Business Administration" <?php if(isset($_POST['department']) && $_POST['department'] == 'Business Administration') echo 'selected'; ?>>Business Administration</option>
                    <option value="Civil Engineering" <?php if(isset($_POST['department']) && $_POST['department'] == 'Civil Engineering') echo 'selected'; ?>>Civil Engineering</option>
                    <option value="English" <?php if(isset($_POST['department']) && $_POST['department'] == 'English') echo 'selected'; ?>>English</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="major">Major:</label>
                <select id="major" name="major">
                    <option value="">Select major</option>
                    <option value="Software Engineering" <?php if(isset($_POST['major']) && $_POST['major'] == 'Software Engineering') echo 'selected'; ?>>Software Engineering</option>
                    <option value="Networking" <?php if(isset($_POST['major']) && $_POST['major'] == 'Networking') echo 'selected'; ?>>Networking</option>
                    <option value="Database" <?php if(isset($_POST['major']) && $_POST['major'] == 'Database') echo 'selected'; ?>>Database</option>
                    <option value="Artificial Intelligence" <?php if(isset($_POST['major']) && $_POST['major'] == 'Artificial Intelligence') echo 'selected'; ?>>Artificial Intelligence</option>
                    <option value="Other" <?php if(isset($_POST['major']) && $_POST['major'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" placeholder="YYYY-MM-DD" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" placeholder="Enter address"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

</body>
</html>