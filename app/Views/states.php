<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>States</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
    <h2>States</h2>
<div style="text-align:right;">
    <a href="<?php echo base_url();?>/adminauth/new_state" class="new-btn">+ New State</a>
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
        <?php foreach ($states as $state) {
            ?>
            <tr>
                <td><?php echo $state->state_id; ?></td>
                <td><?php echo $state->state_name; ?></td>
                <td>
                <a class="action-btn btn-group" href="<?= base_url(); ?>/common/districts/<?php echo $state->state_id; ?>">
                    <i class="fa-solid fa-eye"></i> Districts
                </a>
              <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/common/edit_state/<?php echo $state->state_id; ?>">
              <i class="fa-solid fa-pen"></i> Edit
                </a>
                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url(); ?>/adminauth/delete_state/<?php echo $state->state_id; ?>">
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
