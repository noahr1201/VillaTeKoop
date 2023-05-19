<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if (empty($name) || empty($email) || empty($message)) {
    echo "Please fill in all required fields.";
    exit;
}

$to = "88906@glr.nl";
$subject = "New Contact Form Submission";
$headers = "From: $name <$email>" . "\r\n" .
           "Reply-To: $email" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

$emailContent = "Name: $name\n";
$emailContent .= "Email: $email\n";
$emailContent .= "Message: $message\n";

if (mail($to, $subject, $emailContent, $headers)) {
    echo "Email sent successfully.";
    header("Location: ../index.html");
    exit;
} else {
    echo "Failed to send email. Please try again later.";
}
?>
