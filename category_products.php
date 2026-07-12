<?php
include("config/db.php");

if(isset($_GET['category']))
{
    $id = intval($_GET['category']);
}
elseif(isset($_GET['id']))
{
    $id = intval($_GET['id']);
}
else
{
    header("Location: categories.php");
    exit();
}

$cat_query = mysqli_query($conn,"
SELECT * FROM categories
WHERE id='$id'
");

$category = mysqli_fetch_assoc($cat_query);

$result = mysqli_query($conn,"
SELECT *
FROM products
WHERE category_id='$id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title><?php echo $category['category_name']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.page-section{
    padding:50px 0;
}

.category-card{
    background:white;
    border-radius:25px;
    padding:35px;
    box-shadow:0 15px 40px rgba(0,0,0,0.20);
}

.page-title{
    font-size:45px;
    font-weight:700;
    color:#111827;
}

.page-subtitle{
    color:#6b7280;
    margin-bottom:30px;
}

.product-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    transition:0.4s;
    box-shadow:0 10px 25px rgba(0,0,0,0.10);
    height:100%;
}

.product-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

.product-image{
    height:260px;
    object-fit:contain;
    background:#f8fafc;
    padding:20px;
}

.product-name{
    font-size:22px;
    font-weight:700;
    color:#111827;
}

.price{
    color:#2563eb;
    font-size:28px;
    font-weight:bold;
}

.btn-details{
    border-radius:10px;
    font-weight:600;
    padding:10px 20px;
}

.total-products{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    border-radius:20px;
    padding:25px;
    margin-bottom:30px;
}

.total-products h2{
    margin:0;
    font-weight:bold;
}

.empty-box{
    background:#f8fafc;
    padding:50px;
    border-radius:20px;
    text-align:center;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container page-section">

<div class="category-card">

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

<div>

<h1 class="page-title">
<?php echo $category['category_name']; ?>
</h1>

<p class="page-subtitle">
Browse all products available in this category.
</p>

</div>

<a href="categories.php" class="btn btn-outline-primary">
← Back To Categories
</a>

</div>

<div class="total-products">

<h2>
<?php echo mysqli_num_rows($result); ?>
</h2>

<p class="mb-0">
Products Available
</p>

</div>

<div class="row">

<?php
if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_assoc($result))
{
?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="card product-card">

<img
src="assets/images/<?php echo trim($row['image']); ?>"
class="card-img-top product-image"
alt="<?php echo $row['product_name']; ?>">

<div class="card-body">

<h5 class="product-name">
<?php echo $row['product_name']; ?>
</h5>

<p class="text-muted">
<?php echo substr($row['description'],0,70); ?>...
</p>

<h4 class="price">
RWF <?php echo number_format($row['price']); ?>
</h4>

<div class="d-grid">

<a
href="product_details.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-details">

View Details

</a>

</div>

</div>

</div>

</div>

<?php
}
}
else
{
?>

<div class="col-12">

<div class="empty-box">

<h3>No Products Found</h3>

<p class="text-muted">
There are currently no products in this category.
</p>

<a href="products.php" class="btn btn-primary">
Browse All Products
</a>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>