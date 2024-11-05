<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $response['message'] = "Please complete all fields.";
        echo json_encode($response);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format.";
        echo json_encode($response);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2; // Set to 2 for more debugging output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wing2goaway@gmail.com'; // Your Gmail address
        $mail->Password = 'bowukvnifyyrwzyc'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('wing2goaway@gmail.com', 'Wing2 Test');
        $mail->addAddress('emmanuelampatin19@gmail.com'); // Recipient email for testing

        $mail->Subject = $subject;
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $mail->isHTML(false); // Use plain text format

        if ($mail->send()) {
            $response['status'] = 'success';
            $response['message'] = 'Your message has been sent. Thank you!';
        }
    } catch (Exception $e) {
        $response['message'] = "Mailer Error: " . $e->getMessage();
    }
}

echo json_encode($response);
?>
