<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Villages</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
<h2>
  <span style="font-size:22px; font-weight:bold;"><?php echo @$block->block_name; ?></span><br>
  <small style="color:#555;">Villages</small>
</h2>
<div style="text-align:right;">
    <a href="<?php echo base_url();?>/common/new_village/<?php echo $block->block_id; ?>" class="new-btn">+ New Village</a>
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
        foreach ($villages as $village) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $village->village_name; ?></td>
            <td>
              <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/common/edit_village/<?php echo $village->village_id; ?>/<?php echo $village->village_block; ?>">
              <i class="fa-solid fa-pen"></i> Edit
                </a>
                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url(); ?>/common/delete_village/<?php echo $village->village_id; ?>">
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
