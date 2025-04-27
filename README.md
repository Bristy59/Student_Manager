# Student Registration System

## Overview
This project is a web-based Student Registration System that allows users to manage student information, enroll students in courses, and view enrollment history. It is built using PHP, MySQL, HTML, CSS, and JavaScript.

## Features
- **Add Student**: Register new students with details such as name, email, department, and more.
- **Student List**: View a list of all registered students.
- **Enroll in Course**: Enroll students in courses for specific semesters.
- **Enrollment History**: View the enrollment history of a student, including course details and grades.

## Project Structure
```
Lab Eval/
├── course_enrollment.php       # Handles course enrollment functionality
├── db_connection.php          # Database connection setup
├── enrollment_history.php     # Displays enrollment history for a student
├── header.php                 # Common header for all pages
├── index.php                  # Handles student registration
├── student_list.php           # Displays a list of all students
├── styles.css                 # Stylesheet for the project
├── database/
│   └── setup.sql              # SQL script to set up the database
```

## Setup Instructions
1. Clone the repository or download the project files.
2. Import the database:
   - Open a MySQL client or phpMyAdmin.
   - Run the SQL script located at `database/setup.sql` to create the database and tables.
3. Configure the database connection:
   - Open `db_connection.php`.
   - Update the `$servername`, `$username`, `$password`, and `$dbname` variables with your database credentials.
4. Start a local server:
   - Use tools like XAMPP, WAMP, or a built-in PHP server.
   - Place the project files in the server's root directory (e.g., `htdocs` for XAMPP).
5. Access the application:
   - Open a web browser and navigate to `http://localhost:8000/index.php`.

## Usage
- Navigate through the application using the navigation bar.
- Use the forms to add students, enroll them in courses, and search for enrollment history.

## Dependencies
- PHP 7.4 or higher
- MySQL 5.7 or higher
- A web server (e.g., Apache, Nginx)

## Screenshots
Include screenshots of the application here to showcase its features.

## License
This project is licensed under the MIT License. Feel free to use and modify it as needed.

## Author
- **Name**: Prathona Rani Bristy
- **ID**: 212-15-14759
