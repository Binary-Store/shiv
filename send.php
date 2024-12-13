<?php

include ('smtp/PHPMailerAutoload.php');

$data = json_decode(file_get_contents("php://input"), true);

// Validate and sanitize data (add more validation as needed)
$name = isset($data['name']) ? htmlspecialchars(trim($data['name'])) : '';
$number = isset($data['number']) ? htmlspecialchars(trim($data['number'])) : '';
$email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : '';
$message = isset($data['message']) ? htmlspecialchars(trim($data['message'])) : '';

// Create the HTML content with styling
$html = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #2C334B; margin: 0; padding: 0; }
        .email-container { background-color: #ffffff; padding: 10px; border-radius: 8px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto; }
        .email-header { background-color: #2C334B; color: white; padding: 5px; text-align: center; border-radius: 8px 8px 0 0; }
        .email-body { padding: 5px; line-height: 1.6; }
        .email-body h3 { color: #2C334B; }
        .contact-info { background-color: #f9f9f9; padding: 5px; border-radius: 8px; border: 1px solid #ddd; }
        .contact-info p { margin: 8px 0; }
        .footer { text-align: center; font-size: 12px; color: #888; margin-top: 20px; }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            <h1>New Contact Form Submission</h1>
        </div>
        <div class='email-body'>
            <h3>Hello Admin,</h3>
            <p>You have received a new contact form submission. Below are the details:</p>

            <div class='contact-info'>
                <p><strong>Name:</strong> " . ($name ? $name : 'N/A') . "</p>
                <p><strong>Mobile No:</strong> " . ($number ? "<a href='tel:$number' style='text-decoration:none; color:#2C334B;'>$number</a>" : 'N/A') . "</p>
                <p><strong>Email :</strong> " . ($email ? $email : 'N/A') . "</p>
                <p><strong>Message:</strong> " . ($message ? $message : 'No message provided') . "</p>
            </div>

            <div class='footer'>
                <p>Thank you for using our contact form.</p>
                <p>&copy; 2024 Your Company Name</p>
            </div>
        </div>
    </div>
</body>
</html>
";

// Call the function to send the email
echo smtp_mailer('superwax9@gmail.com', 'New Contact Form Submission', $html);

function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "harshil9915vasoya@gmail.com";
    $mail->Password = "fiummkhswgxudiso";
    $mail->SetFrom("harshil9915vasoya@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        )
    );

    if (!$mail->Send()) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Error sending email']);
    } else {
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    }
}
?>