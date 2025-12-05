<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Districts</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
<h2>
  <span style="font-size:22px; font-weight:bold;"><?php echo $state->state_name; ?></span><br>
  <small style="color:#555;">Districts</small>
</h2>
<div style="text-align:right;">
    <a href="<?php echo base_url();?>/common/new_district/<?php echo $state->state_id; ?>" class="new-btn">+ New District</a>
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
        <?php foreach ($districts as $district) {
            ?>
            <tr>
                <td><?php echo $district->district_id; ?></td>
                <td><?php echo $district->district_name; ?></td>
              <td>
                <a class="action-btn btn-group" href="<?= base_url(); ?>/common/blocks/<?php echo $district->district_id; ?>">
                    <i class="fa-solid fa-eye"></i> Blocks
                </a>
              <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/common/edit_district/<?php echo $district->district_id; ?>/<?php echo $district->district_state; ?>">
              <i class="fa-solid fa-pen"></i> Edit
                </a>
                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url(); ?>/common/delete_district/<?php echo $district->district_id; ?>">
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
