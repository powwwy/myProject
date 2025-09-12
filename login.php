<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Simple validation
    $errors = [];
    if ($name === '') $errors[] = "Name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if ($password === '') $errors[] = "Password is required.";

    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OZB Login</title>
    <link rel="stylesheet" href="style.css">
<body>
    <div class="form-container">
        <h2>Create Account</h2>
        <form class="signup-form">
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name = "email" class="inputter" placeholder="Enter your email">
                <div class="focus-border"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name = "password" class="inputter" placeholder="Enter your password">
                <div class="focus-border"></div>
            </div>
            
            <button type="submit">Login</button>
            
            <div class="divider">
                <span>Are you a new User?</span>
            </div>
            <div class="login-link">
                <a href="signup.php">Sign Up</a>
            </div>
            <div class="login-link">
                <a href="reset.php">Forgot Password?</a>
            </div>
            
        </form>
    </div>
    
    <footer>
        <p>© 2025 Wells. All rights reserved.</p>
    </footer>
</body>
</html>