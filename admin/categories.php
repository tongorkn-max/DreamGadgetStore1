<?php
include("admin_header.php");
include("sidebar.php");

if(isset($_POST['add_category'])){
    $name=mysqli_real_escape_string($conn,trim($_POST['category_name']));
    if($name!=""){
        mysqli_query($conn,"INSERT INTO categories(category_name) VALUES('$name')");
    }
}

if(isset($_POST['update_category'])){
    $id=(int)$_POST['category_id'];
    $name=mysqli_real_escape_string($conn,trim($_POST['category_name']));
    mysqli_query($conn,"UPDATE categories SET category_name='$name' WHERE id='$id'");
}

if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $check=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM products WHERE category_id='$id'"));
    if($check['c']==0){
        mysqli_query($conn,"DELETE FROM categories WHERE id='$id'");
    }
}

$edit=null;
if(isset($_GET['edit'])){
    $eid=(int)$_GET['edit'];
    $edit=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM categories WHERE id='$eid'"));
}

$search=$_GET['search']??"";
$where="";
if($search!=""){
 $s=mysqli_real_escape_string($conn,$search);
 $where="WHERE c.category_name LIKE '%$s%'";
}

$sql="SELECT c.*,
(SELECT COUNT(*) FROM products p WHERE p.category_id=c.id) product_count
FROM categories c $where ORDER BY c.id DESC";
$res=mysqli_query($conn,$sql);
$total=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM categories"));
?>
<div class="col-md-10 p-4" style="background:#eef2f7;min-height:100vh;">
<div class="card border-0 shadow mb-4" style="background:linear-gradient(135deg,#1e40af,#2563eb);border-radius:20px;">
<div class="card-body text-white">
<h2>📂 Categories Management</h2>
<p class="mb-0">Create, edit, search and manage categories.</p>
</div></div>

<div class="row">
<div class="col-md-4">
<div class="card shadow border-0 mb-4"><div class="card-body">
<h4><?php echo $edit?"Edit Category":"Add Category";?></h4>
<form method="POST">
<?php if($edit){?><input type="hidden" name="category_id" value="<?php echo $edit['id'];?>"><?php }?>
<input class="form-control mb-3" name="category_name" required value="<?php echo $edit?htmlspecialchars($edit['category_name']):'';?>" placeholder="Category Name">
<?php if($edit){?>
<button class="btn btn-warning w-100" name="update_category">Update Category</button>
<a href="categories.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
<?php } else { ?>
<button class="btn btn-primary w-100" name="add_category">Add Category</button>
<?php } ?>
</form>
</div></div>

<div class="card shadow border-0"><div class="card-body text-center">
<h1><?php echo $total;?></h1><p>Total Categories</p>
</div></div>
</div>

<div class="col-md-8">
<div class="card shadow border-0"><div class="card-body">
<form class="row mb-3">
<div class="col-md-9"><input class="form-control" name="search" value="<?php echo htmlspecialchars($search);?>" placeholder="Search categories"></div>
<div class="col-md-3"><button class="btn btn-success w-100">Search</button></div>
</form>

<table class="table table-bordered table-hover">
<thead class="table-primary"><tr><th>ID</th><th>Category</th><th>Products</th><th>Actions</th></tr></thead>
<tbody>
<?php while($r=mysqli_fetch_assoc($res)){ ?>
<tr>
<td><?php echo $r['id'];?></td>
<td><?php echo htmlspecialchars($r['category_name']);?></td>
<td><span class="badge bg-primary"><?php echo $r['product_count'];?></span></td>
<td>
<a href="?edit=<?php echo $r['id'];?>" class="btn btn-warning btn-sm">Edit</a>
<?php if($r['product_count']==0){ ?>
<a href="?delete=<?php echo $r['id'];?>" onclick="return confirm('Delete this category?')" class="btn btn-danger btn-sm">Delete</a>
<?php } else { ?>
<button class="btn btn-secondary btn-sm" disabled>In Use</button>
<?php } ?>
</td>
</tr>
<?php } ?>
</tbody></table>
</div></div>
</div>
</div>
</div>
</body></html>