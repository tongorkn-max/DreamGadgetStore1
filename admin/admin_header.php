<?php
session_start();

include("../config/db.php");

/*
|--------------------------------------------------------------------------
| Check Admin Login
|--------------------------------------------------------------------------
*/

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dream Gadget Store - Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#eef3f8;
font-family:Segoe UI,Tahoma,sans-serif;
overflow-x:hidden;
}

.page-content{
margin-left:250px;
padding:30px;
min-height:100vh;
}

.card{
border:none;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.btn{
border-radius:10px;
}

.table{
vertical-align:middle;
}

.admin-topbar{
background:#ffffff;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
margin-bottom:25px;
}

.admin-topbar h4{
margin:0;
font-weight:700;
color:#1e3a8a;
}

.admin-user{
font-weight:600;
color:#444;
}

@media(max-width:992px){

.page-content{
margin-left:0;
padding:20px;
}

}

</style>

</head>

<body>