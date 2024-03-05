<!DOCTYPE html>
<html>
<head>
 <title>Reset Password</title>
 <link rel="stylesheet" type="text/css" href="style/resetstyle.css">
 
 <style>
   .custom-button {
        width: 150px;
        margin: 0 auto;
        display: block;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top:3%;
    }
    
    .custom-button:hover {
        background-color: #0056b3;
    }

 </style>
</head>
<body>
    <div id="imgback">

        <form id="reset-password-form">
            <table>
                
                <h1>Reset Password</h1>
                <div class="input-container">
                    <tr>
                        
                        <td>
                            <label for="email"><strong>Email</strong></label>
                        </td> 
                
              <td>
                  
                  <input style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;" type="email" id="email" name="email" required>
                </td> 
            </tr>
    </div>
    <div class="input-container">
        <tr>
            <td>
                
                <label for="password"><strong>New Password</strong></label>
            </td>   
            <td>
                
                <input style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;" type="password" id="password" name="password" required>
            </td>  
        </tr>
    </div>
    <div class="input-container">
        <tr>
            <td>
                
                <label for="confirm-password"><strong>Confirm New Password</strong></label>
            </td>
            <td>
                
                <input style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;" type="password" id="confirm-password" name="confirm-password" required>
            </td>
        </tr>
    </div>
    <tr>
        <td >
            
        </td>
    </tr>
</table>

            <button class="custom-button" type="submit">Reset Password</button>

</form>
</div>
<?php
session_start();

require 'functions.php';
// require 'PHPMailer/PHPMailer.php'; // Include PHPMailer


// $email = $_POST['email'];

// $stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email = ?");
// $stmt->bind_param('s', $email);
// $stmt->execute();
// $stmt->store_result();

// if ($stmt->num_rows > 0) {
//     // Generate a unique token
//     $token = bin2hex(openssl_random_pseudo_bytes(32));

//     // Insert the token into the database
//     $stmt = $mysqli->prepare("INSERT INTO password_reset_tokens (user_id, token) VALUES (?, ?)");
//     $stmt->bind_param('is', $user_id, $token);

//     $stmt->execute();

//     // Send an email to the user with a link to reset their password
 
// // Create a new PHPMailer instance
//     $mail = new PHPMailer(true);

// try {
    
//      $mail = new PHPMailer\PHPMailer\PHPMailer();
//         $mail->isSMTP();  // Set mailer to use SMTP
//         $mail->Host = 'smtp.gmail.com';  // Your SMTP server address
//         $mail->SMTPAuth = true; // Enable SMTP authentication
//         $mail->Username = 'am8396280@gmail.com'; // Your email address
//         $mail->Password = 'ylny wims dqot kbsz'; // Your email password
//         $mail->SMTPSecure = 'tls';  // Enable TLS encryption
//         $mail->Port = 587; // SMTP port

//         // Sender email address
//     $mail->setFrom('am8396280@gmail.com', 'Ali Mrad');

//         // Recipient email address
//         $mail->addAddress($email);

//         // Email subject
//         $mail->Subject = 'Password Reset';

//         // Email message with the password reset link
//         $resetLink = 'https://example.com/reset-password.php?token=' . $token;
//         $mail->Body = "Click the following link to reset your password: $resetLink";

//         // Send the email
//         if ($mail->send()) {
//             echo 'Password reset email sent successfully!';
//         } else {
//             echo 'Error sending email: ' . $mail->ErrorInfo;
//         }
//     } catch (Exception $e) {
//         echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
//     }
//         // ...
// } else {
//     echo "No account exists with that email address.";
    
// }
// ...
?>


</body>
</html>