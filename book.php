<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'collaborator' => htmlspecialchars($_POST['collaborator']),
        'name' => htmlspecialchars($_POST['name']),
        'email' => htmlspecialchars($_POST['email']),
        'date' => htmlspecialchars($_POST['date']),
        'time' => htmlspecialchars($_POST['time']),
        'purpose' => htmlspecialchars($_POST['purpose']),
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Create folder if it doesn't exist
    if (!is_dir('appointments')) {
        mkdir('appointments', 0777, true);
    }

    $filename = 'appointments/booking_' . time() . '.txt';

    // Save booking details to file
    file_put_contents($filename, json_encode($data));

    // Now send email
    $to = "manilukka143@gmail.com"; // <-- Corrected to your Gmail
    $subject = "New Collaboration Booking Request";
    $message = "
        <h2>New Booking Received</h2>
        <p><strong>Collaborator:</strong> {$data['collaborator']}</p>
        <p><strong>Name:</strong> {$data['name']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <p><strong>Date:</strong> {$data['date']}</p>
        <p><strong>Time:</strong> {$data['time']}</p>
        <p><strong>Purpose:</strong> {$data['purpose']}</p>
        <p><strong>Timestamp:</strong> {$data['timestamp']}</p>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: manilukka143@gmail.com" . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo '
        <style>
            body {
                margin: 0;
                padding: 0;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
                font-family: "Poppins", sans-serif;
            }
            .booking-success {
                background: #fff;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                text-align: center;
                animation: popUp 0.6s ease;
            }
            .booking-success h2 {
                color: #4CAF50;
                margin-bottom: 20px;
                font-size: 2rem;
            }
            .booking-success p {
                color: #333;
                font-size: 1.2rem;
            }
            @keyframes popUp {
                0% {
                    transform: scale(0.5);
                    opacity: 0;
                }
                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        </style>

        <div class="booking-success">
            <h2>Booking Successful!</h2>
            <p>We\'ve received your request for ' . $data['date'] . ' at ' . $data['time'] . '</p>
        </div>';
    } else {
        echo "<p>Booking saved, but email sending failed. Please check your server mail settings.</p>";
    }
}
?>
