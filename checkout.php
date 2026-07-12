<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dream Gadget Store - Checkout</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.checkout-wrapper{
    background:white;
    border-radius:25px;
    padding:40px;
    margin-top:40px;
    margin-bottom:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.checkout-title{
    font-size:48px;
    font-weight:bold;
    color:#071a52;
}

.checkout-subtitle{
    color:#6c757d;
    margin-bottom:30px;
}

.customer-box{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    border-radius:20px;
    padding:20px;
    margin-bottom:30px;
}

.customer-box h5{
    margin:0;
}

.form-label{
    font-weight:600;
    color:#071a52;
}

.form-control{
    height:55px;
    border-radius:12px;
    border:1px solid #ced4da;
}

textarea.form-control{
    height:auto;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 10px rgba(37,99,235,0.3);
}

.checkout-card{
    background:#f8fafc;
    border-radius:20px;
    padding:30px;
}

.btn-place{
    background:#16a34a;
    border:none;
    padding:12px 30px;
    border-radius:12px;
    font-weight:bold;
}

.btn-place:hover{
    background:#15803d;
}

.btn-back{
    background:#475569;
    border:none;
    padding:12px 30px;
    border-radius:12px;
    font-weight:bold;
}

.btn-back:hover{
    background:#334155;
}

.icon-box{
    font-size:55px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container">

<div class="checkout-wrapper">

<div class="text-center mb-4">

<div class="icon-box">💳</div>

<h1 class="checkout-title">Checkout</h1>

<p class="checkout-subtitle">
Complete your order and delivery information.
</p>

</div>

<div class="customer-box">

<h5>
👤 Logged in as:
<strong><?php echo $_SESSION['user_name']; ?></strong>
</h5>

</div>

<div class="checkout-card">

<form action="place_order.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Full Name
</label>

<input
type="text"
name="full_name"
class="form-control"
placeholder="Enter Full Name"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Email Address
</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter Email Address"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Phone Number
</label>

<input
type="text"
name="phone"
class="form-control"
placeholder="Enter Phone Number"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Delivery Location
</label>

<input
type="text"
name="location"
class="form-control"
placeholder="City / Area"
>

</div>

</div>

<div class="mb-4">

<label class="form-label">
Delivery Address
</label>

<textarea
name="address"
class="form-control"
rows="5"
placeholder="Enter Full Delivery Address"
required></textarea>

</div>

<button
type="submit"
class="btn btn-place text-white">
<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Payment Method
</label>

<select
name="payment_method"
class="form-control"
required>

<option value="">
Select Payment Method
</option>

<option value="MTN MoMo">
MTN MoMo
</option>

<option value="Airtel Money">
Airtel Money
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Mobile Money Number
</label>

<input
type="text"
name="payment_phone"
class="form-control"
placeholder="07XXXXXXXX"
required>

</div>

</div>

<div class="mb-4">

</div>
✓ Place Order
</button>

<a
href="cart.php"
class="btn btn-back text-white">
← Back To Cart
</a>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>