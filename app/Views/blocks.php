<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blocks</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
<h2>
  <span style="font-size:22px; font-weight:bold;"><?php echo @$district->district_name; ?></span><br>
  <small style="color:#555;">Blocks</small>
</h2>
<div style="text-align:right;">
  <a href="javascript:history.back()" class="back-btn">
      <i class="fa-solid fa-arrow-left"></i> Back
  </a>
    <a href="<?php echo base_url();?>/common/new_block/<?php echo $district->district_id; ?>" class="new-btn">+ New Block</a>
</div>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        foreach ($blocks as $block) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $block->block_name; ?></td>
                <td>
                <a class="action-btn btn-group" href="<?= base_url(); ?>/common/villages/<?php echo $block->block_id; ?>">
                    <i class="fa-solid fa-eye"></i> Villages
                </a>
              <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/common/edit_block/<?php echo $block->block_id; ?>/<?php echo $block->block_district; ?>">
              <i class="fa-solid fa-pen"></i> Edit
                </a>
                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url(); ?>/common/delete_block/<?php echo $block->block_id; ?>">
                    <i class="fa-solid fa-trash"></i> Delete
                </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
