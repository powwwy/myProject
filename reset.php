<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Reset Password</h2>
     <div class="form-container">
    <form action="reset.php" class="signup-form"  method="post">
        <div class = "form-group">
        <label for="email">Email Address:</label><br>
        <input type="email" id="email" class="inputter" name="email" required><br><br>
</div>
<div class = "form-group">
        <label for="reset_code">Reset Code:</label><br>
        <input type="text" id="reset_code" class="inputter" name="reset_code" required><br><br>
    </div>
        <div class = "form-group">
        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" class="inputter" name="new_password" required><br><br>
    </div>
        <div class = "form-group">
        <label for="confirm_password">Confirm New Password:</label><br>
        <input type="password" id="confirm_password" class="inputter" name="confirm_password" required><br><br>
        </div>
        <button type="submit"> Reset Password</button>
    </form>
    </div>
</body>
</html>