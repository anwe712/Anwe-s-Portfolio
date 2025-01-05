<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Please fill out all fields correctly."]);
        exit();
    }

    // Sanitize inputs
    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject']));
    $message = strip_tags(trim($_POST['message']));

    // Recipient email
    $to = "ghoshanwesha272@gmail.com";

    // Subject for the email
    $email_subject = "Contact Form: $subject";

    // Message body
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Here are the details:\n\n" .
                  "Name: $name\n" .
                  "Email: $email\n" .
                  "Subject: $subject\n" .
                  "Message:\n$message";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        http_response_code(200); // Success
        echo json_encode(["message" => "Your message has been sent successfully."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "An error occurred while sending the email. Please try again later."]);
    }
} else {
    // If the request method is not POST
    http_response_code(403); // Forbidden
    echo json_encode(["message" => "Invalid request. Only POST requests are allowed."]);
}
?>
