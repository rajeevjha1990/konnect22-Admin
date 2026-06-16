<?php

if(isset($banner)){

    $id       = $banner->id ?? '';
    $title    = $banner->title ?? '';
    $subtitle = $banner->subtitle ?? '';
    $image    = $banner->image ?? '';
    $status   = $banner->status ?? 1;

}else{

    $id       = '';
    $title    = '';
    $subtitle = '';
    $image    = '';
    $status   = 1;

}
?>

<style>

.form-card{
    background:#fff;
    max-width:900px;
    margin:auto;
    border-radius:12px;
    padding:25px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.form-title{
    text-align:center;
    margin-bottom:25px;
    color:#0f5132;
    font-size:32px;
    font-weight:700;
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
    padding:10px 12px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
}

.form-group textarea{
    resize:vertical;
}

.preview-img{
    width:250px;
    max-width:100%;
    border-radius:10px;
    border:1px solid #ddd;
    object-fit:cover;
}

.action-box{
    text-align:center;
    margin-top:25px;
}

.save-btn{
    background:#198754;
    color:#fff;
    border:none;
    padding:10px 25px;
    border-radius:8px;
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
    margin-left:10px;
    display:inline-block;
}

@media(max-width:768px){

    .grid{
        grid-template-columns:1fr;
    }

    .form-title{
        font-size:26px;
    }

}
</style>

<div class="content">

```
<div style="text-align:right;margin-bottom:15px;">

    <a href="javascript:history.back()" class="back-btn">

        <i class="fa fa-arrow-left"></i> Back

    </a>

</div>

<div class="form-card">

    <h2 class="form-title">

        <?= empty($id) ? 'Add Banner' : 'Edit Banner'; ?>

    </h2>

    <form method="post"
          action="<?= base_url('banner/save') ?>"
          enctype="multipart/form-data">

        <input type="hidden"
               name="id"
               value="<?= esc($id) ?>">

        <div class="grid">

            <div class="form-group full">

                <label> Title *</label>

                <input type="text"
                       name="title"
                       value="<?= esc($title) ?>"
                       required>

            </div>

            <div class="form-group full">

                <label> Subtitle</label>

                <input name="subtitle"
                          rows="4"><?= esc($subtitle) ?></input>

            </div>

            <div class="form-group">

                <label> Image</label>

                <input type="file" name="image">

            </div>

            <?php if(!empty($image)){ ?>

            <div class="form-group full">

                <label>Current </label>

                <img src="<?= base_url('uploads/banners/'.$image) ?>"
                     class="preview-img">

            </div>

            <?php } ?>

        </div>

        <div class="action-box">

            <button type="submit" class="save-btn">

                <?= empty($id)
                    ? 'Save Banner'
                    : 'Update Banner'; ?>

            </button>

            <a href="<?= base_url('banner') ?>"
               class="back-btn">

                Cancel

            </a>

        </div>

    </form>

</div>
```

</div>
