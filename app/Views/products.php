<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Categories</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">

</head>

<div class="content">

<div style="text-align:right;">

<a href="javascript:history.back()"
   class="back-btn">

<i class="fa-solid fa-arrow-left"></i> Back

</a>

<a href="<?= base_url();?>/product/add"
   class="new-btn">

+ New Product

</a>

</div>

<table id="myTable"
       class="display"
       style="width:100%">

<thead>

<tr>

<th>ID</th>
<th>Image</th>
<th>Vendor</th>
<th>Category</th>
<th>Product</th>
<th>Price</th>
<th>Sale Price</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>
<th>Is Featured</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

foreach($products as $row){

?>

<tr>

<td><?= $i++; ?></td>

<td>

<?php if(!empty($row['image_webp'])){ ?>

<img src="<?= base_url('uploads/products/'.$row['image_webp']) ?>"
     width="60"
     height="60"
     style="object-fit:cover;border-radius:8px;">

<?php }else{ ?>

<img src="<?= base_url('assets/images/no-image.png')?>"
     width="60">

<?php } ?>

</td>

<td>
<?= $row['shop_name'] ?? '-' ?>
</td>

<td>
<?= $row['name'] ?? '-' ?>
</td>

<td>
<?= $row['name'] ?? '-' ?>
</td>

<td>
₹<?= $row['price'] ?? 0 ?>
</td>

<td>
₹<?= $row['mrp'] ?? 0 ?>
</td>

<td>
<?= $row['stock_quantity'] ?? 0 ?>
</td>

<td>

<?php if($row['status']=='Active'){ ?>

<span class="badge bg-success">

Active

</span>

<?php }else{ ?>

<span class="badge bg-danger">

Inactive

</span>

<?php } ?>

</td>

<td>

<a class="action-btn btn-edit"
href="<?= base_url();?>/product/edit/<?= $row['id']; ?>">

<i class="fa-solid fa-pen"></i>

Edit

</a>

<a class="action-btn btn-delete delete_data"
href="<?= base_url();?>/product/delete/<?= $row['id']; ?>">

<i class="fa-solid fa-trash"></i>

Delete

</a>

</td>
<td>

<?php if($row['is_featured'] == 1){ ?>

    <a href="<?= base_url();?>/product/toggle_featured/<?= $row['id']; ?>/0"
       class="badge bg-success"
       style="text-decoration:none;">

        Featured

    </a>

<?php }else{ ?>

    <a href="<?= base_url();?>/product/toggle_featured/<?= $row['id']; ?>/1"
       class="badge bg-secondary"
       style="text-decoration:none;">

        No

    </a>

<?php } ?>

</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>