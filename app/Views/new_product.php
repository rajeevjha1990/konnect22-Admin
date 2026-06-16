<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= empty($id) ? 'New Category' : 'Edit Category' ?></title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

<style>
body{
    background:#f5f6fa;
}

.content{
    padding:20px;
}

.form-card{
    background:#fff;
    max-width:1000px;
    margin:auto;
    border-radius:15px;
    padding:30px;
    box-shadow:0 5px 25px rgba(0,0,0,.08);
}

.form-title{
    text-align:center;
    color:#198754;
    margin-bottom:25px;
    font-size:30px;
    font-weight:700;
}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group.full{
    grid-column:1 / -1;
}

.form-group label{
    margin-bottom:6px;
    font-weight:600;
    color:#333;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:14px;
}

.form-group textarea{
    resize:vertical;
}

.preview-img{
    width:180px;
    height:180px;
    object-fit:cover;
    border-radius:12px;
    border:1px solid #ddd;
}

.action-box{
    text-align:center;
    margin-top:25px;
}

.save-btn{
    background:#198754;
    color:#fff;
    border:none;
    padding:12px 30px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
}

.save-btn:hover{
    background:#157347;
}

.back-btn{
    background:#6c757d;
    color:#fff !important;
    text-decoration:none;
    padding:10px 18px;
    border-radius:8px;
    display:inline-block;
}

.back-btn:hover{
    background:#5c636a;
}
</style>
</head>

<?php

if(isset($product)){

    $id             = $product->id ?? '';
    $vendor_id      = $product->vendor_id ?? '';
    $category_id    = $product->category_id ?? '';
    $product_name   = $product->name ?? '';
    $description    = $product->description ?? '';
    $price          = $product->price ?? '';
    $sale_price     = $product->mrp ?? '';
    $stock          = $product->stock_quantity ?? '';
    $image          = $product->image_webp ?? '';
    $status         = $product->status ?? 'available';

}else{

    $id             = '';
    $vendor_id      = '';
    $category_id    = '';
    $product_name   = '';
    $description    = '';
    $price          = '';
    $sale_price     = '';
    $stock          = '';
    $image          = '';
    $status         = 'available';
}
?>
<div class="content">

    <div class="form-card">

        <h2 class="form-title">
            <?= empty($id) ? 'Add Product' : 'Edit Product'; ?>
        </h2>

<form method="post"
      action="<?= base_url('product/save') ?>"
      enctype="multipart/form-data">

    <input type="hidden"
           name="id"
           value="<?= esc($id) ?>">

    <div class="grid">

        <div class="form-group">
            <label>Vendor *</label>

            <select name="vendor_id" required>

                <option value="">Select Vendor</option>

                <?php foreach($vendors as $vendor){ ?>

                    <option value="<?= $vendor->id ?>"
                        <?= $vendor_id == $vendor->id ? 'selected' : '' ?>>

                        <?= $vendor->owner_name ?>

                    </option>

                <?php } ?>

            </select>

        </div>

        <div class="form-group">
            <label>Category *</label>

            <select name="category_id" required>

                <option value="">Select Category</option>

                <?php foreach($categories as $category){ ?>

                    <option value="<?= $category['id'] ?>"
                        <?= $category_id == $category['id'] ? 'selected' : '' ?>>

                        <?= $category['name'] ?>

                    </option>

                <?php } ?>

            </select>

        </div>

        <div class="form-group full">

            <label>Product Name *</label>

            <input type="text"
                   name="product_name"
                   value="<?= esc($product_name) ?>"
                   required>

        </div>

        <div class="form-group full">

            <label>Description *</label>

            <textarea name="description"
                      rows="4"
                      required><?= esc($description) ?></textarea>

        </div>

        <div class="form-group">

            <label>Price *</label>

            <input type="number"
                   step="0.01"
                   name="price"
                   value="<?= esc($price) ?>"
                   required>

        </div>

        <div class="form-group">

            <label>MRP *</label>

            <input type="number"
                   step="0.01"
                   name="sale_price"
                   value="<?= esc($sale_price) ?>"
                   required>

        </div>

        <div class="form-group">

            <label>Stock Quantity *</label>

            <input type="number"
                   name="stock"
                   value="<?= esc($stock) ?>"
                   required>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select name="status">

                <option value="available"
                    <?= $status == 'available' ? 'selected' : '' ?>>
                    Available
                </option>

                <option value="out_of_stock"
                    <?= $status == 'out_of_stock' ? 'selected' : '' ?>>
                    Out Of Stock
                </option>

                <option value="disabled"
                    <?= $status == 'disabled' ? 'selected' : '' ?>>
                    Disabled
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>Product Image</label>

            <input type="file" name="image">

        </div>

        <?php if(!empty($image)){ ?>

        <div class="form-group full">

            <label>Current Product Image</label>

            <img src="<?= base_url('uploads/products/'.$image) ?>"
                 class="preview-img">

        </div>

        <?php } ?>

    </div>

    <div class="action-box">

        <button type="submit" class="save-btn">

            <?= empty($id)
                ? 'Save Product'
                : 'Update Product'; ?>

        </button>

        <a href="<?= base_url('product') ?>"
           class="back-btn">

            Cancel

        </a>

    </div>

</form>
    </div>

</div>