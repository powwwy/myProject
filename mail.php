<?php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 465);
define('SMTP_USERNAME', 'maxwell.muthumbi@strathmore.edu');
define('SMTP_PASSWORD', 'klhz jlpi srnl jtof'); // Use app password, not your regular password
define('SMTP_ENCRYPTION', 'ssl');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Use PHPMailer for more reliable email delivery
require 'vendor/autoload.php'; // You'll need to install PHPMailer via Composer
session_start();

$name = $_SESSION['name'] ?? '';

function sendEmail($to, $type, $name, $token = null) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_USERNAME, 'OZB Project');
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(true);
        
        if ($type === 'signup') {
            $mail->Subject = 'Welcome to the OZB Project!';
            $mail->Body    = getSignupTemplate($to, $name);
        } 
        
        $mail->AltBody = strip_tags($mail->Body); // Plain text version
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function getSignupTemplate($email, $name) {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Our Service</title>
        <style>
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                background: linear-gradient(135deg, #7fdbff 0%, #ff7fff 100%);
                padding: 30px;
                text-align: center;
                border-radius: 10px 10px 0 0;
            }
            .header h1 {
                color: white;
                margin: 0;
                font-size: 28px;
            }
            .content {
                background-color: #f9f9f9;
                padding: 30px;
                border-radius: 0 0 10px 10px;
            }
            .button {
                display: inline-block;
                padding: 12px 30px;
                background: linear-gradient(90deg, #7fdbff 0%, #b47fff 50%, #ff7fff 100%);
                color: white;
                text-decoration: none;
                border-radius: 30px;
                font-weight: bold;
                margin: 20px 0;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                font-size: 12px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Welcome Aboard!</h1>
        </div>
        <div class="content">
            <h2>Hello! ' .$name.'</h2>
            <p>Thank you for signing up for our project. We\'re excited to have you on board.</p>
            <p>Your account has been successfully created with the email: <strong>'.$email.'</strong></p>
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>Best regards,<br>The Team</p>
        </div>
        <div class="footer">
            <p>© '.date('Y').' OZB Project. All rights reserved.</p>
            <p>If you did not sign up for this account, please ignore this email.</p>
        </div>
    </body>
    </html>';
}
?>