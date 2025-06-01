<?php 
include 'conection.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (isset($_POST['submit-btn'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $number = htmlspecialchars($_POST['number']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = '';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@gmail.com';         // ✅ your Gmail
        $mail->Password   = 'your-app-password';            // ✅ Gmail App Password (not regular password)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('piyunilthashani4@gmail.com');    // ✅ your receiving email

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Contact Message from Green Cactus Website';
        $mail->Body    = "You received a message:\n\nName: $name\nEmail: $email\nPhone Number: $number\n\nMessage:\n$message";

        $mail->send();
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal('Success!', 'Your message has been sent!', 'success');
            });
        </script>";
    } catch (Exception $e) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal('Error!', 'Message could not be sent. {$mail->ErrorInfo}', 'error');
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cactus - Contact Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style><?php include 'style.css'; ?></style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Contact Us</h1>
    </div>
    <div class="title2">
        <a href="home.php">Home</a><span> / Contact</span>
    </div>

    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="img/icon2.png">
                <div class="detail">
                    <h3>Great Savings</h3>
                    <p>Save big every order</p>
                </div>
            </div>
            <div class="box">
                <img src="img/icon1.png">
                <div class="detail">
                    <h3>24*7 Support</h3>
                    <p>One-on-one support</p>
                </div>
            </div>
            <div class="box">
                <img src="img/icon0.png">
                <div class="detail">
                    <h3>Gift Vouchers</h3>
                    <p>Vouchers on every festival</p>
                </div>
            </div>
            <div class="box">
                <img src="img/icon.png">
                <div class="detail">
                    <h3>Worldwide Delivery</h3>
                    <p>Dropship worldwide</p>
                </div>
            </div>
        </div>
    </section>

    <div class="form-container">
        <form method="post">
            <div class="title">
                <img src="img/logo.png" class="logo">
                <h1>Leave a Message</h1>
            </div>
            <div class="input-field">
                <p>Your Name <sub>*</sub></p>
                <input type="text" name="name" required>
            </div>
            <div class="input-field">
                <p>Your Email <sub>*</sub></p>
                <input type="email" name="email" required>
            </div>
            <div class="input-field">
                <p>Your Number <sub>*</sub></p>
                <input type="number" name="number" required>
            </div>
            <div class="input-field">
                <p>Your Message <sub>*</sub></p>
                <textarea name="message" required></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn">Send Message</button>
        </form>
    </div>

    <div class="address">
        <div class="title">
            <img src="img/logo.png" class="logo">
            <h1>Contact Details</h1>
            <p>Contact us for this</p>
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-pin"></i>
                <div>
                    <h4>Address</h4>
                    <p>1092 Buttala, Uva-Pelwatta</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Phone Number</h4>
                    <p>0783740204</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <p>piyunilthashani4@gmail.com</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?> 
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'alert.php'; ?>

</body>
</html>
