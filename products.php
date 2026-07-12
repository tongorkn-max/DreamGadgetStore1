<?php
include("config/db.php");

if(isset($_GET['search']))
{
    $search = $_GET['search'];

    $result = mysqli_query($conn,"
    SELECT * FROM products
    WHERE product_name LIKE '%$search%'
    ");
}
else
{
    $result = mysqli_query($conn,"
    SELECT * FROM products
    ");
}

$product_count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dream Gadget Store - Products</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.hero-section{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    border-radius:20px;
    padding:40px;
    text-align:center;
    color:white;
    margin-bottom:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

.hero-section h1{
    font-size:48px;
    font-weight:bold;
}

.hero-section p{
    font-size:18px;
    opacity:0.9;
}

.search-box{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.15);
    margin-bottom:30px;
}

.product-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    transition:0.4s;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

.product-card:hover{
    transform:translateY(-10px);
    box-shadow:0 15px 35px rgba(0,0,0,0.25);
}

.product-image{
    height:280px;
    object-fit:contain;
    background:#f8fafc;
    padding:20px;
}

.price-tag{
    font-size:28px;
    font-weight:bold;
    color:#2563eb;
}

.view-btn{
    border-radius:10px;
    font-weight:bold;
}

.products-header{
    color:white;
    margin-bottom:20px;
}

.count-badge{
    background:#ffc107;
    color:black;
    padding:8px 15px;
    border-radius:30px;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container py-5">

<div class="hero-section">

<h1>🛍 Dream Gadget Store</h1>

<p>
Discover the latest smartphones, laptops, smart watches and accessories.
</p>

</div>

<div class="search-box">

<form method="GET">

<div class="row">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control form-control-lg"
placeholder="Search products by name..."
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

</div>

<div class="col-md-2">

<button
class="btn btn-primary btn-lg w-100">
🔍 Search
</button>

</div>

</div>

</form>

</div>

<div class="d-flex justify-content-between align-items-center products-header">

<h2>Our Products</h2>

<span class="count-badge">
<?php echo $product_count; ?> Products
</span>

</div>

<div class="row">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="card product-card h-100">

<img
src="assets/images/<?php echo $row['image']; ?>"
class="card-img-top product-image"
alt="<?php echo $row['product_name']; ?>">

<div class="card-body">

<h5 class="fw-bold">
<?php echo $row['product_name']; ?>
</h5>

<p class="text-muted">
<?php echo $row['description']; ?>
</p>

<div class="price-tag mb-3">
RWF <?php echo number_format($row['price']); ?>
</div>

<a
href="product_details.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary view-btn w-100">
View Details
</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>