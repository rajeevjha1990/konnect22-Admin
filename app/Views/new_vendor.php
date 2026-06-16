<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= empty($vendor_id) ? 'New Vendor' : 'Edit Vendor' ?></title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

<style>
.form-card{
    background:#fff;
    max-width:950px;
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
    color:#333;
}
.form-group input,
.form-group select,
.form-group textarea{
    padding:10px;
    border:1px solid #dcdcdc;
    border-radius:8px;
    font-size:14px;
}
.form-group textarea{
    resize:vertical;
}
.full{
    grid-column:1 / -1;
}
.action-box{
    margin-top:25px;
    text-align:center;
}
.save-btn{
    background:#198754;
    color:#fff;
    border:none;
    padding:10px 22px;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}
.save-btn:hover{
    background:#157347;
}
.back-btn{
    display:inline-block;
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    padding:10px 18px;
    border-radius:8px;
    margin-left:10px;
}
.back-btn:hover{
    background:#5c636a;
    color:#fff;
}
.top-bar{
    text-align:right;
    margin-bottom:15px;
}
@media(max-width:768px){
    .grid{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<?php

if(isset($vendor)){

    $vendor_id   = $vendor->id ?? '';
    $vendor_code = $vendor->vendor_code ?? '';
    $shop_name   = $vendor->shop_name ?? '';
    $owner_name  = $vendor->owner_name ?? '';
    $mobile      = $vendor->mobile ?? '';
    $email       = $vendor->email ?? '';
    $address     = $vendor->address ?? '';
    $gst_no      = $vendor->gst_no ?? '';
    $status      = $vendor->status ?? 'Active';

}else{

    $vendor_id   = '';
    $vendor_code = '';
    $shop_name   = '';
    $owner_name  = '';
    $mobile      = '';
    $email       = '';
    $address     = '';
    $gst_no      = '';
    $status      = 'Active';
}
?>

<body>

<div class="content">

    <div class="top-bar">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="form-card">

        <h2 class="form-title">
            <?= empty($vendor_id) ? 'Add New Vendor' : 'Edit Vendor' ?>
        </h2>

        <form method="post" action="<?= base_url('vendor/save') ?>">

            <input type="hidden" name="id" value="<?= esc($vendor_id) ?>">

            <div class="grid">

                <div class="form-group">
                    <label>Shop Name *</label>
                    <input type="text"
                           name="shop_name"
                           value="<?= esc($shop_name) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Owner Name *</label>
                    <input type="text"
                           name="owner_name"
                           value="<?= esc($owner_name) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Mobile *</label>
                    <input type="text"
                           name="mobile"
                           value="<?= esc($mobile) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           value="<?= esc($email) ?>">
                </div>

                <div class="form-group">
                    <label>GST No</label>
                    <input type="text"
                           name="gst_no"
                           value="<?= esc($gst_no) ?>">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">

                        <option value="Active"
                            <?= $status=='Active'?'selected':'' ?>>
                            Active
                        </option>

                        <option value="Inactive"
                            <?= $status=='Inactive'?'selected':'' ?>>
                            Inactive
                        </option>

                    </select>
                </div>

                <div class="form-group full">
                    <label>Address</label>
                    <textarea name="address" rows="4"><?= esc($address) ?></textarea>
                </div>

            </div>

            <div class="action-box">

                <button type="submit" class="save-btn">
                    <?= empty($vendor_id)
                        ? 'Save Vendor'
                        : 'Update Vendor'; ?>
                </button>

                <a href="<?= base_url('vendors') ?>" class="back-btn">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>