<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';   
require 'dboperation.php';       

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname   = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password   = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPwd = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';

    // Basic validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPwd)) {
        $message = "❌ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email address.";
    } elseif ($password !== $confirmPwd) {
        $message = "❌ Passwords do not match.";
    } else {
       
        

        if (strpos($result, "✅") !== false) {
           
            $verifyLink = "http://localhost/TaskApp/verify.php?email=" . urlencode($email);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'reynold.righa@strathmore.edu';    
                $mail->Password   = 'xxtr bwwu ukin zale';     
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('reynold.righa@strathmore.edu', 'BBIT 2.2');
                $mail->addAddress($email, $fullname);

                $mail->isHTML(true);
                $mail->Subject = "Welcome to ICS 2.2! Account Verification";
                $mail->Body    = "
                    <p>Hello <b>" . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') . "</b>,</p>
                    <p>Thank you for signing up on <b>ICS 2.2</b>.</p>
                    <p>To activate your account, please click the link below:</p>
                    <p><a href='" . htmlspecialchars($verifyLink, ENT_QUOTES, 'UTF-8') . "'>Verify My Account</a></p>
                    <br>
                    <p>Regards,<br>Systems Admin<br>ICS 2.2</p>
                ";

                $mail->send();
                $message = "✅ Registration successful! A verification email has been sent to <b>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</b>.";
            } catch (Exception $e) {
                $message = "⚠ User saved but email could not be sent. Error: " . htmlspecialchars($mail->ErrorInfo, ENT_QUOTES, 'UTF-8');
            }
        } else {
            $message = $result; // DB error message
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up Result</title>
  <link rel="stylesheet" href="style.css">
    <p style="text-align:center; color: 
       <?php echo strpos($message, '✅') !== false ? 'green' : 'red'; ?>;">
       <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <p style="text-align:center; color: 
       <?php echo strpos($message, '✅') !== false ? 'green' : 'red'; ?>;">
       <?php echo $message; ?>
    </p>
    <a href="index.html">⬅ Back to Sign Up</a>
  </div>
</body>
</html>