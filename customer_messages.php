<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

include("config/db.php");

$email = $_SESSION['user_email'];

/* Mark customer replies as read when page is opened */
mysqli_query($conn,"
UPDATE contact_messages
SET reply_status='Read'
WHERE email='$email'
");

$messages = mysqli_query($conn,"
SELECT *
FROM contact_messages
WHERE email='$email'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Support Messages</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.page-box{
    background:white;
    border-radius:20px;
    padding:30px;
    margin-top:40px;
    margin-bottom:40px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.message-card{
    border:none;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.message-header{
    background:linear-gradient(90deg,#1e3a8a,#2563eb);
    color:white;
    font-weight:bold;
}

.reply-box{
    background:#f8fafc;
    padding:15px;
    border-left:5px solid #2563eb;
    border-radius:10px;
}

.no-reply{
    color:#dc3545;
    font-weight:600;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container">

<div class="page-box">

<h2>📩 My Support Messages</h2>

<p class="text-muted">
View your messages and replies from Dream Gadget Store Support.
</p>

<hr>

<?php while($row=mysqli_fetch_assoc($messages)){ ?>

<div class="card message-card mb-4">

<div class="card-header message-header">

<?php echo $row['subject']; ?>

</div>

<div class="card-body">

<h6 class="text-primary">My Message</h6>

<p>
<?php echo nl2br($row['message']); ?>
</p>

<hr>

<h6 class="text-success">Admin Reply</h6>

<div class="reply-box">

<?php

if(!empty($row['admin_reply']))
{
    echo nl2br($row['admin_reply']);
}
else
{
    echo "<span class='no-reply'>No reply yet.</span>";
}

?>

</div>

<p class="mt-3 text-muted">
Sent:
<?php echo $row['created_at']; ?>
</p>

</div>

</div>

<?php } ?>

</div>

</div>

</body>

</html>