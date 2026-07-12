
<?php
include("config/db.php");
?>

<!DOCTYPE html>
<html>
<head>

<title>About Us - Dream Gadget Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#071a52,#1e3a8a);
    min-height:100vh;
}

.about-section{
    padding:60px 0;
}

.about-card{
    background:white;
    border-radius:25px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.feature-box{
    background:#f8fafc;
    padding:25px;
    border-radius:15px;
    text-align:center;
    transition:0.3s;
}

.feature-box:hover{
    transform:translateY(-5px);
}

.hero-box{
    background:rgba(255,255,255,0.12);
    color:white;
    border-radius:25px;
    padding:40px;
    text-align:center;
    margin-bottom:30px;
}

</style>

</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container about-section">

<div class="hero-box">

<h1>🏢 About Dream Gadget Store</h1>

<p class="lead">
Your trusted destination for quality electronics and smart gadgets.
</p>

</div>

<div class="about-card">

<h2 class="mb-4">Who We Are</h2>

<p>
Dream Gadget Store is a modern online electronics store providing
smartphones, laptops, smart watches, headphones and accessories
to customers through a secure and convenient shopping experience.
</p>

<p>
Our goal is to provide quality products, affordable prices,
fast delivery and excellent customer service.
</p>

<hr>

<div class="row mt-4">

<div class="col-md-4 mb-3">

<div class="feature-box">

<h1>🎯</h1>

<h4>Our Mission</h4>

<p>
To provide quality electronics with excellent customer satisfaction.
</p>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="feature-box">

<h1>👁️</h1>

<h4>Our Vision</h4>

<p>
To become the most trusted online gadget store in Africa.
</p>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="feature-box">

<h1>⭐</h1>

<h4>Why Choose Us</h4>

<p>
Quality products, secure payments and fast delivery.
</p>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
