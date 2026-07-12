<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../config/db.php");

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn,"
UPDATE orders
SET payment_status='$status'
WHERE id='$id'
");

header("Location: view_order.php?id=".$id);
exit();
?>