
<?php
include("config/db.php");

if(isset($_POST['send_message']))
{
    $name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    mysqli_query($conn,"
    INSERT INTO contact_messages
    (full_name,email,subject,message)
    VALUES
    ('$name','$email','$subject','$message')
    ");

    $success = "Your message has been sent successfully. We will contact you soon.";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Contact Us - Dream Gadget Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.contact-section{
    padding:60px 0;
}

.contact-card{
    background:white;
    border-radius:25px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.hero-box{
    background:rgba(255,255,255,0.12);
    color:white;
    border-radius:25px;
    padding:40px;
    text-align:center;
    margin-bottom:30px;
}

.info-box{
    background:#f8fafc;
    border-radius:15px;
    padding:20px;
    margin-bottom:20px;
    transition:0.3s;
}

.info-box:hover{
    transform:translateY(-5px);
}

.btn-send{
    background:#2563eb;
    border:none;
    padding:12px 30px;
    font-weight:bold;
    border-radius:10px;
}

.btn-send:hover{
    background:#1d4ed8;
}

.form-control{
    border-radius:10px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container contact-section">

<div class="hero-box">

<h1>📞 Contact Us</h1>

<p class="lead">
We would love to hear from you. Send us a message anytime.
</p>

</div>

<div class="contact-card">

<?php
if(isset($success))
{
    echo "<div class='alert alert-success'>$success</div>";
}
?>

<div class="row">

<div class="col-md-5">

<div class="info-box">
<h5>📧 Email</h5>
<p>support@dreamgadgetstore.com</p>
</div>

<div class="info-box">
<h5>📱 Phone</h5>
<p>+971 52 536 2738</p>
</div>

<div class="info-box">
<h5>📍 Address</h5>
<p>Kigali, Rwanda</p>
</div>

<div class="info-box">
<h5>🕒 Business Hours</h5>
<p>Monday - Saturday<br>8:00 AM - 6:00 PM</p>
</div>

</div>

<div class="col-md-7">

<form method="POST">

<div class="mb-3">
<label>Your Name</label>
<input
type="text"
name="full_name"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Email Address</label>
<input
type="email"
name="email"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Subject</label>
<input
type="text"
name="subject"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Message</label>
<textarea
name="message"
class="form-control"
rows="5"
required></textarea>
</div>

<button
type="submit"
name="send_message"
class="btn btn-send text-white">
Send Message
</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>
