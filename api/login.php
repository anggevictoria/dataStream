<?php
session_start();
require_once '../dB/conn.php'; // Include your database connection file.

class User {
    private $conn;
    private $table_name = "member"; // Adjusted to match your table name

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to fetch user by username and password
    public function getUserByUsernameAndPassword($username, $password) {
        try {
            $sql = "SELECT * FROM $this->table_name WHERE username=? AND password=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $password]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error retrieving user: " . $e->getMessage());
        }
    }
}

// Process login form submission
if (isset($_POST['login'])) {
    // Check if both username and password are provided
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Create a User instance with the database connection
        $user = new User($pdo); // Pass the $pdo connection here

        // Fetch user data based on username and password
        $userData = $user->getUserByUsernameAndPassword($username, $password);

        if ($userData) {
            // If user data is retrieved successfully, set session and redirect
            $_SESSION['user_id'] = $userData['mem_id'];
            $_SESSION['loggedin'] = true; // Set the logged in session variable
            header("Location: ../frontend/home.html");
            exit();
        } else {
            // If no user data found, display error and redirect back to login page
            echo "<script>alert('Invalid username or password'); window.location.href='../index.html';</script>";
            exit();
        }
    } else {
        // If either username or password is empty, show error message and redirect
        echo "<script>alert('Please complete the required fields'); window.location.href='../index.html';</script>";
        exit();
    }
}
?>
