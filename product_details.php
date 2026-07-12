<?php
include("config/db.php");

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT * FROM products
WHERE id='$id'
");

$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $product['product_name']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.product-wrapper{
    padding:60px 0;
}

.product-card{
    background:white;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.product-image-box{
    background:#f8fafc;
    padding:40px;
    text-align:center;
}

.product-image{
    max-height:500px;
    object-fit:contain;
    transition:0.4s;
}

.product-image:hover{
    transform:scale(1.05);
}

.product-details{
    padding:40px;
}

.category-badge{
    display:inline-block;
    background:#dbeafe;
    color:#2563eb;
    padding:8px 15px;
    border-radius:30px;
    font-weight:bold;
    margin-bottom:15px;
}

.product-title{
    font-size:42px;
    font-weight:700;
    color:#111827;
}

.price{
    font-size:38px;
    font-weight:bold;
    color:#2563eb;
    margin:20px 0;
}

.stock-box{
    background:#f3f4f6;
    padding:15px;
    border-radius:12px;
    margin-bottom:25px;
}

.stock-text{
    font-size:18px;
    font-weight:600;
}

.description-box{
    background:#f8fafc;
    padding:20px;
    border-radius:15px;
    margin-bottom:25px;
}

.btn-cart{
    background:#16a34a;
    border:none;
    padding:14px 35px;
    font-size:18px;
    font-weight:bold;
    border-radius:12px;
}

.btn-cart:hover{
    background:#15803d;
}

.btn-back{
    padding:14px 35px;
    border-radius:12px;
    font-size:18px;
    font-weight:bold;
}

.feature-box{
    background:#f8fafc;
    padding:15px;
    border-radius:12px;
    text-align:center;
    margin-top:20px;
}

.feature-box h5{
    margin-bottom:5px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container product-wrapper">

<div class="product-card">

<div class="row g-0">

<div class="col-lg-6">

<div class="product-image-box">

<img
src="assets/images/<?php echo $product['image']; ?>"
class="img-fluid product-image">

</div>

</div>

<div class="col-lg-6">

<div class="product-details">

<span class="category-badge">
⭐ Premium Product
</span>

<h1 class="product-title">
<?php echo $product['product_name']; ?>
</h1>

<div class="price">
RWF <?php echo number_format($product['price']); ?>
</div>

<div class="stock-box">

<div class="stock-text">

📦 Stock Available:
<strong>
<?php echo $product['stock']; ?>
</strong>

</div>

</div>

<div class="description-box">

<h5>Description</h5>

<p class="mb-0">
<?php echo $product['description']; ?>
</p>

</div>

<div class="d-flex gap-3 flex-wrap">

<a
href="add_to_cart.php?id=<?php echo $product['id']; ?>"
class="btn btn-cart text-white">

🛒 Add To Cart

</a>

<a
href="products.php"
class="btn btn-outline-primary btn-back">

← Back To Products

</a>

</div>

<div class="row mt-4">

<div class="col-md-4">

<div class="feature-box">

<h5>🚚</h5>

<p>Fast Delivery</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-box">

<h5>🔒</h5>

<p>Secure Payment</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-box">

<h5>✅</h5>

<p>Quality Guarantee</p>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>