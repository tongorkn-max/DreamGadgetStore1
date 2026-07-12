
<?php
include("config/db.php");
?>

<!DOCTYPE html>
<html>

<head>

<title>Dream Gadget Store - Categories</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.hero-section{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(10px);
    border-radius:20px;
    padding:40px;
    text-align:center;
    color:#fff;
    margin-bottom:35px;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

.hero-section h1{
    font-size:48px;
    font-weight:800;
}

.hero-section p{
    font-size:18px;
    opacity:.9;
}

.page-header{
    color:white;
    margin-bottom:30px;
}

.total-badge{
    background:#ffc107;
    color:#000;
    padding:10px 20px;
    border-radius:30px;
    font-weight:bold;
}

.category-card{
    background:#fff;
    border:none;
    border-radius:20px;
    overflow:hidden;
    text-decoration:none;
    color:#111827;
    transition:.35s;
    display:block;
    box-shadow:0 8px 20px rgba(0,0,0,.18);
    height:100%;
}

.category-card:hover{
    transform:translateY(-8px);
    color:#2563eb;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

.category-image{
    width:100%;
    height:220px;
    object-fit:cover;
    display:block;
    transition:.35s;
    background:#f8fafc;
}

.category-card:hover .category-image{
    transform:scale(1.05);
}

.category-box{
    padding:20px;
    text-align:center;
}

.category-name{
    font-size:22px;
    font-weight:700;
}

.category-text{
    color:#6b7280;
    margin-top:10px;
}

.product-count{
    display:inline-block;
    margin-top:12px;
    background:#2563eb;
    color:#fff;
    padding:6px 15px;
    border-radius:30px;
    font-size:14px;
    font-weight:bold;
}

@media(max-width:768px){

.hero-section h1{
    font-size:34px;
}

.category-image{
    height:170px;
}

.category-name{
    font-size:18px;
}

}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container py-5">

<div class="hero-section">

<h1>📂 Product Categories</h1>

<p>
Browse products by category and quickly find what you're looking for.
</p>

</div>

<?php
$total_categories=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM categories"));
?>

<div class="d-flex justify-content-between align-items-center page-header">

<h2>Shop By Category</h2>

<span class="total-badge">
<?php echo $total_categories; ?> Categories
</span>

</div>

<div class="row">

<?php

$categories=mysqli_query($conn,"SELECT * FROM categories ORDER BY id ASC");

while($cat=mysqli_fetch_assoc($categories))
{

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

$count=mysqli_fetch_assoc(mysqli_query(
$conn,
"SELECT COUNT(*) AS total
 FROM products
 WHERE category_id='".$cat['id']."'"
));

?>

<div class="col-lg-4 col-md-6 mb-4">

<a href="category_products.php?id=<?php echo $cat['id']; ?>" class="category-card">

<img
src="assets/category-images/<?php echo $image; ?>"
class="category-image"
alt="<?php echo htmlspecialchars($cat['category_name']); ?>"
onerror="this.src='assets/images/no-image.png';">

<div class="category-box">

<div class="category-name">
<?php echo htmlspecialchars($cat['category_name']); ?>
</div>

<p class="category-text">
Click to browse products
</p>

<span class="product-count">
<?php echo $count['total']; ?> Products
</span>

</div>

</a>

</div>

<?php } ?>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
