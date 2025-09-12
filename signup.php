<?php
// Handle form submission
include 'connect.php';
include 'mail.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT userID FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<p style='color: red;'>Email is already registered. Please use a different email.</p>";
        $stmt->close();
        $conn->close();
        exit;
    }
    $errors = [];
    if ($name === '') $errors[] = "Name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if ($password === '') $errors[] = "Password is required.";

    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
           $_SESSION['name'] = $name;
            sendEmail($email, 'signup', $name);
            header('Location: login.php');
            
            exit;
        } else {
            echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>" . htmlspecialchars($error) . "</p>";
        }
    }
}
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OZB Signup</title>
    <link rel="stylesheet" href="style.css">
<body>
    <div class="form-container">
        <h2>Create Account</h2>
        <form class="signup-form" action="signup.php" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name = "name" class="inputter" placeholder="Enter your name">
                <div class="focus-border"></div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name = "email" class="inputter" placeholder="Enter your email">
                <div class="focus-border"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name = "password" class="inputter" placeholder="Create a password">
                <div class="focus-border"></div>
            </div>
            
            <button type="submit">Sign Up</button>
            <div class="divider">
                <span>Already have an Account?</span>
            </div>
            <div class="login-link">
                <a href="login.php">Log In</a>
            </div>
            
        </form>
    </div>
    
    <footer>
        <p>© 2025 Wells. All rights reserved.</p>
    </footer>
</body>
</html>