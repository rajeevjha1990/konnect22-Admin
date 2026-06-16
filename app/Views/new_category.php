<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= empty($id) ? 'New Category' : 'Edit Category' ?></title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

<style>
.form-card{
    background:#fff;
    max-width:900px;
    margin:auto;
    border-radius:12px;
    padding:25px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}
.form-title{
    text-align:center;
    margin-bottom:20px;
    color:#0f5132;
}
.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}
.form-group{
    display:flex;
    flex-direction:column;
}
.form-group label{
    margin-bottom:6px;
    font-weight:600;
}
.form-group input,
.form-group select{
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}
.action-box{
    text-align:center;
    margin-top:25px;
}
.save-btn{
    background:#198754;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:8px;
}
.back-btn{
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    padding:10px 18px;
    border-radius:8px;
    margin-left:10px;
}
.preview-img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
    border:1px solid #ddd;
}
</style>
</head>

<?php

if(isset($category)){

    $id   = $category['id'] ?? '';
    $name = $category['name'] ?? '';
    $image         = $category['image_url'] ?? '';
    $status        = $category['status'] ?? 'Active';

}else{

    $id   = '';
    $name = '';
    $image         = '';
    $status        = 'Active';
}
?>

<body>

<div class="content">

<div style="text-align:right;margin-bottom:15px;">
    <a href="javascript:history.back()" class="back-btn">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

<div class="form-card">

<h2 class="form-title">
<?= empty($id)
    ? 'Add New Category'
    : 'Edit Category'; ?>
</h2>

<form method="post"
      action="<?= base_url('category/save') ?>"
      enctype="multipart/form-data">

<input type="hidden"
       name="id"
       value="<?= esc($id) ?>">

<div class="grid">

<div class="form-group">
<label>Category Name *</label>
<input type="text"
       name="category_name"
       value="<?= esc($name) ?>"
       required>
</div>

<div class="form-group">
<label>Status</label>

<select name="status">

<option value="Active"
<?= $status=='active'?'selected':'' ?>>
Active
</option>

<option value="Inactive"
<?= $status=='inactive'?'selected':'' ?>>
Inactive
</option>

</select>

</div>

<div class="form-group">
<label>Category Image</label>
<input type="file" name="image">
</div>

<?php if(!empty($image)){ ?>

<div class="form-group">
<label>Current Image</label>

<img src="<?= base_url('uploads/categories/'.$image) ?>"
     class="preview-img">

</div>

<?php } ?>

</div>

<div class="action-box">

<button type="submit" class="save-btn">
<?= empty($id)
    ? 'Save Category'
    : 'Update Category'; ?>
</button>

<a href="<?= base_url('category') ?>"
   class="back-btn">
   Cancel
</a>

</div>

</form>

</div>

</div>

</body>
</html>