
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
DELETE FROM contact_messages
WHERE id='$id'
");

header("Location: messages.php");
exit();
?>
