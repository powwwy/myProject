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

function sendEmail($to, $type, $token = null) {
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
            $mail->Body    = getSignupTemplate($to);
        } else if ($type === 'reset') {
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = getResetTemplate($to, $token);
        }
        
        $mail->AltBody = strip_tags($mail->Body); // Plain text version
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function getSignupTemplate($email) {
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
            <h2>Hello!</h2>
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

function getResetTemplate($email, $token) {
    // Extract first 6 characters for the reset code (more user-friendly)
    $resetCode = substr($token, 0, 6);
    
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset</title>
        <style>
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f5f8fa;
            }
            .container {
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            .header {
                background: linear-gradient(135deg, #ff7fff 0%, #7fdbff 100%);
                padding: 30px;
                text-align: center;
            }
            .header h1 {
                color: white;
                margin: 0;
                font-size: 28px;
                font-weight: 600;
            }
            .content {
                padding: 30px;
            }
            .code-box {
                background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
                border: 2px dashed #cbd5e0;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                margin: 25px 0;
                font-family: monospace;
            }
            .reset-code {
                font-size: 32px;
                font-weight: bold;
                letter-spacing: 8px;
                color: #2d3748;
                background: #fff;
                padding: 15px 25px;
                border-radius: 6px;
                display: inline-block;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
            .instructions {
                background: #f8fafc;
                border-left: 4px solid #7fdbff;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .button {
                display: inline-block;
                padding: 12px 30px;
                background: linear-gradient(90deg, #ff7fff 0%, #7fdbff 100%);
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
                color: #718096;
                padding: 20px;
                background: #f7fafc;
                border-top: 1px solid #e2e8f0;
            }
            h2 {
                color: #2d3748;
                margin-top: 0;
            }
            p {
                color: #4a5568;
                margin-bottom: 16px;
            }
            .highlight {
                background: linear-gradient(120deg, #7fdbff20 0%, #ff7fff20 100%);
                padding: 2px 6px;
                border-radius: 4px;
                font-weight: 500;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Password Reset Request</h1>
            </div>
            <div class="content">
                <h2>Hello!</h2>
                <p>We received a request to reset your password for your account associated with <strong>'.$email.'</strong>.</p>
                
                <p>Please use the following verification code to reset your password:</p>
                
                <div class="code-box">
                    <div class="reset-code">'.$resetCode.'</div>
                </div>
                
                <div class="instructions">
                    <p><strong>How to use this code:</strong></p>
                    <ol>
                        <li>Go to the password reset page on our website</li>
                        <li>Enter your email address</li>
                        <li>Enter the verification code shown above</li>
                        <li>Create your new password</li>
                    </ol>
                </div>
                
                <p>This verification code will expire in <span class="highlight">1 hour</span> for security reasons.</p>
                
                <p>If you did not request a password reset, please ignore this email or contact our support team if you have concerns.</p>
            </div>
            <div class="footer">
                <p>© '.date('Y').' Your Company Name. All rights reserved.</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>';
}

?>