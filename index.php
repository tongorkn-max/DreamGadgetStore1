<?php
include("config/db.php");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dream Gadget Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}
.hero{
    text-align:center;
    padding:100px 20px;
    color:white;
}
.hero h1{font-size:65px;font-weight:800;}
.hero p{font-size:22px;color:#dbeafe;margin-bottom:30px;}
.hero-btn{padding:15px 35px;border-radius:50px;font-size:18px;font-weight:bold;}
.section-title{color:white;font-size:40px;font-weight:bold;text-align:center;margin-bottom:40px;}
.stats-card,.category-card,.product-card{
    background:#fff;border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}
.stats-card{padding:25px;text-align:center;}
.stats-card h2{color:#2563eb;font-weight:bold;}
.category-card{transition:.3s;height:100%;}
.category-card:hover,.product-card:hover{transform:translateY(-8px);}
.category-icon{font-size:55px;}
.product-card{overflow:hidden;transition:.3s;}
.product-image{height:220px;object-fit:contain;padding:15px;background:#f8fafc;}
.product-price{color:#2563eb;font-weight:bold;}
.footer{background:#021033;color:#fff;margin-top:80px;padding:30px;text-align:center;}
@media(max-width:768px){
.hero{padding:70px 15px;}
.hero h1{font-size:2.5rem;}
.hero p{font-size:1rem;}
.section-title{font-size:2rem;}
.product-image{height:140px;}
.product-card h5{font-size:14px;}
.product-price{font-size:18px;}
.category-icon{font-size:40px;}
.stats-card{padding:15px;}
}
</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container">

<div class="hero">
<h1>Dream Gadget Store</h1>
<p>Your Trusted Destination For Smartphones, Laptops, Accessories And Smart Devices</p>
<a href="products.php" class="btn btn-warning hero-btn">🛒 Shop Now</a>
</div>

<div class="row mb-5">
<div class="col-md-4 mb-3"><div class="stats-card"><h2><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products")); ?></h2><p>Total Products</p></div></div>
<div class="col-md-4 mb-3"><div class="stats-card"><h2><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM categories")); ?></h2><p>Product Categories</p></div></div>
<div class="col-md-4 mb-3"><div class="stats-card"><h2>24/7</h2><p>Customer Support</p></div></div>
</div>

<h2 class="section-title">Shop By Category</h2>

<div class="row mb-5">

<?php

$categories=mysqli_query($conn,"SELECT * FROM categories ORDER BY id ASC");

while($cat=mysqli_fetch_assoc($categories)){

$image="default.jpg";

switch($cat['category_name']){

case "Personal Computing & Mobile":
$image="personal-computing.jpg";
break;

case "Smart Home & Networking":
$image="smart-home.jpg";
break;

case "Office & Creator Equipment":
$image="office.jpg";
break;

case "Power & Accessories":
$image="accessories.jpg";
break;

case "Audio & Entertainment":
$image="audio.jpg";
break;

case "Car & Automotive Electronics":
$image="car.jpg";
break;

case "Photography, Videography & Drones":
$image="camera.jpg";
break;

case "Wellness, Health & Grooming Tech":
$image="wellness.jpg";
break;

case "Eco-Friendly & Outdoor Tech":
$image="outdoor.jpg";
break;

case "Component Level & DIY Electronics":
$image="diy.jpg";
break;

case "Gaming Gear & Esports Equipment":
$image="gaming.jpg";
break;

case "Kitchen & Culinary Electronics":
$image="kitchen.jpg";
break;

}

?>

<div class="col-lg-3 col-md-4 col-6 mb-4">

<a href="category_products.php?id=<?php echo $cat['id']; ?>" style="text-decoration:none;color:inherit;">

<div class="card category-card h-100">

<img
src="assets/category-images/<?php echo $image; ?>"
class="card-img-top"
style="height:180px;object-fit:cover;"
alt="<?php echo htmlspecialchars($cat['category_name']); ?>">

<div class="card-body text-center">

<h5 class="fw-bold">
<?php echo htmlspecialchars($cat['category_name']); ?>
</h5>

</div>

</div>

</a>

</div>

<?php } ?>

</div>


<div class="container mb-5">
<h2 class="section-title">🔍 Search Products By Category</h2>
<form action="category_products.php" method="GET">
<div class="row justify-content-center">
<div class="col-md-8 col-8">
<select name="category" class="form-select form-select-lg" required>
<option value="">All Categories</option>
<?php
$sc=mysqli_query($conn,"SELECT * FROM categories ORDER BY category_name ASC");
while($c=mysqli_fetch_assoc($sc)){
?>
<option value="<?php echo $c['id']; ?>"><?php echo $c['category_name']; ?></option>
<?php } ?>
</select>
</div>
<div class="col-md-2 col-4">
<button class="btn btn-primary btn-lg w-100" type="submit">🔍 Search</button>
</div>
</div>
</form>
</div>

<h2 class="section-title">Featured Products</h2>

<div class="row">
<?php
$featured=mysqli_query($conn,"SELECT * FROM products ORDER BY id DESC");
while($product=mysqli_fetch_assoc($featured)){
?>
<div class="col-6 col-md-3 mb-4">
<div class="card product-card h-100">
<img src="assets/images/<?php echo trim($product['image']); ?>" class="card-img-top product-image" alt="<?php echo $product['product_name']; ?>">
<div class="card-body">
<h5 class="fw-bold"><?php echo $product['product_name']; ?></h5>
<p><?php echo $product['description']; ?></p>
<h4 class="product-price">RWF <?php echo number_format($product['price']); ?></h4>
<a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100">View Details</a>
</div>
</div>
</div>
<?php } ?>
</div>

</div>

<div class="footer">
<h5>Dream Gadget Store</h5>
<p>Your Trusted Online Electronics Store</p>
<p>© <?php echo date('Y'); ?> Dream Gadget Store. All Rights Reserved.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
