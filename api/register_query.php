<?php
session_start();
require_once '../dB/conn.php';

class User {
    private $conn;
    private $table_name = "member"; // Adjusted to match your table name

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to insert a new user into the database
    public function registerUser($firstname, $lastname, $username, $password) {
        try {
            $sql = "INSERT INTO $this->table_name (firstname, lastname, username, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$firstname, $lastname, $username, $password]);
            return true; // Return true if insertion was successful
        } catch(PDOException $e) {
            die("Error creating user: " . $e->getMessage());
        }
    }
}

// Process registration form submission
if (isset($_POST['register'])) {
    // Check if all required fields are filled
    if (!empty($_POST['firstname']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Create a User instance with the database connection
        $user = new User($pdo); // Pass the $pdo connection here

        // Register the user
        if ($user->registerUser($firstname, $lastname, $username, $password)) {
            $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");
            header('Location: ../index.html');
            exit();
        } else {
            echo "<script>alert('Failed to register user')</script>";
            echo "<script>window.location = 'registration.html'</script>";
            exit();
        }
    } else {
        // If any required field is empty, show error message and redirect
        echo "<script>alert('Please fill up all required fields')</script>";
        echo "<script>window.location = 'registration.html'</script>";
        exit();
    }
}
?>
