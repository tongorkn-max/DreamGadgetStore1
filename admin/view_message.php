<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE contact_messages
SET status='Read'
WHERE id='$id'
");

if(isset($_POST['save_reply']))
{
    $reply = mysqli_real_escape_string(
        $conn,
        $_POST['admin_reply']
    );

    mysqli_query($conn,"
    UPDATE contact_messages
    SET
        admin_reply='$reply',
        reply_status='Unread'
    WHERE id='$id'
    ");

    $success = "Reply saved successfully.";
}

$message = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT *
FROM contact_messages
WHERE id='$id'
")
);
?>

<!DOCTYPE html>
<html>

<head>

<title>View Message</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#eef2f7,#dbeafe);
    min-height:100vh;
    padding:20px;
}

.container-box{
    max-width:1000px;
    margin:auto;
    margin-top:20px;
    margin-bottom:20px;
}

.message-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    background:white;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
}

.card-header{
    background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb) !important;
    color:white;
    padding:25px;
}

.card-header h3{
    margin:0;
    font-weight:700;
}

.card-body{
    padding:35px !important;
}

.customer-info{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:15px;
    padding:20px;
    margin-bottom:25px;
}

.customer-info p{
    margin-bottom:12px;
}

.section-title{
    color:#1e3a8a;
    font-weight:700;
    margin-bottom:15px;
}

.message-box{
    background:#f8fafc;
    border-left:5px solid #2563eb;
    border-radius:15px;
    padding:20px;
    margin-bottom:25px;
}

textarea{
    border-radius:15px !important;
    border:2px solid #dbeafe !important;
    padding:15px !important;
}

textarea:focus{
    border-color:#2563eb !important;
    box-shadow:0 0 12px rgba(37,99,235,0.20) !important;
}

.btn-success{
    border:none;
    border-radius:12px;
    padding:10px 20px;
    font-weight:600;
}

.btn-secondary{
    border:none;
    border-radius:12px;
    padding:10px 20px;
    font-weight:600;
}

.info-box{
    background:#eff6ff;
    border-left:5px solid #2563eb;
    border-radius:15px;
    padding:20px;
    margin-top:25px;
}

.info-box strong{
    color:#1e3a8a;
}

.alert-success{
    border-radius:12px;
}

</style>

</head>

<body>

<div class="container container-box">

<div class="card message-card">

<div class="card-header">

<h3>📩 Customer Message & Reply</h3>

</div>

<div class="card-body">

<?php
if(isset($success))
{
    echo "<div class='alert alert-success'>$success</div>";
}
?>

<div class="customer-info">

<p>
<strong>👤 Customer:</strong>
<?php echo $message['full_name']; ?>
</p>

<p>
<strong>📧 Email:</strong>
<?php echo $message['email']; ?>
</p>

<p>
<strong>📝 Subject:</strong>
<?php echo $message['subject']; ?>
</p>

<p>
<strong>📅 Date:</strong>
<?php echo $message['created_at']; ?>
</p>

</div>

<h5 class="section-title">📨 Customer Message</h5>

<div class="message-box">

<?php echo nl2br($message['message']); ?>

</div>

<h5 class="section-title">✍️ Admin Reply</h5>

<form method="POST">

<textarea
name="admin_reply"
class="form-control mb-3"
rows="7"
placeholder="Write your reply here..."><?php echo $message['admin_reply']; ?></textarea>

<button
type="submit"
name="save_reply"
class="btn btn-success">
💾 Save Reply
</button>

<a href="messages.php"
class="btn btn-secondary">
← Back To Messages
</a>

</form>

<?php
if(!empty($message['admin_reply']))
{
?>

<div class="info-box">

<strong>Current Saved Reply:</strong>

<hr>

<?php echo nl2br($message['admin_reply']); ?>

</div>

<?php } ?>

</div>

</div>

</div>

</body>

</html>