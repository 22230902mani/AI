<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => htmlspecialchars($_POST['name']),
        'email' => htmlspecialchars($_POST['email']),
        'subject' => htmlspecialchars($_POST['subject']),
        'message' => htmlspecialchars($_POST['message']),
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Save message to file
    if (!is_dir('messages')) {
        mkdir('messages', 0777, true);
    }
    $filename = 'messages/contact_' . time() . '.txt';
    file_put_contents($filename, json_encode($data));

    // Email details
    $to = "manilukka143@gmail.com"; // your email
    $subjectMail = "New Contact Form Message: " . $data['subject'];
    $message = "
        <h2>New Contact Message</h2>
        <p><strong>Name:</strong> {$data['name']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <p><strong>Subject:</strong> {$data['subject']}</p>
        <p><strong>Message:</strong><br>" . nl2br($data['message']) . "</p>
        <p><strong>Received At:</strong> {$data['timestamp']}</p>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: manilukka143@gmail.com" . "\r\n"; // your domain mail or any

    // Send email
    if (mail($to, $subjectMail, $message, $headers)) {
        echo '
        <style>
            body {
                margin: 0;
                padding: 0;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background: linear-gradient(135deg, #e0f7fa, #80deea);
                font-family: "Poppins", sans-serif;
            }
            .message-success {
                background: #fff;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                text-align: center;
                animation: fadeIn 0.6s ease;
            }
            .message-success h2 {
                color: #2196F3;
                margin-bottom: 20px;
                font-size: 2rem;
            }
            .message-success p {
                color: #333;
                font-size: 1.2rem;
            }
            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: scale(0.8);
                }
                100% {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>

        <div class="message-success">
            <h2>Message Sent!</h2>
            <p>Thank you for contacting us. We\'ll respond within 24 hours.</p>
        </div>';
    } else {
        echo "<p>Message saved, but email sending failed. Please check your server settings.</p>";
    }
}
?>
