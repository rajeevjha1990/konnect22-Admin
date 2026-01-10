<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Programs</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
    <h2>Programs</h2>
<div style="text-align:right;">
    <a href="<?php echo base_url();?>/adminauth/new_program" class="new-btn">+ New Program</a>
</div>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Program</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($programs as $program) {
            ?>
            <tr>
                <td><?php echo $program->name; ?></td>
                <td><?php echo $program->short_desc; ?></td>
                <td><?php echo $program->icon; ?></td>
                <td>
              <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/adminauth/edit_program/<?php echo $program->id; ?>">
              <i class="fa-solid fa-pen"></i> Edit
                </a>
                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url(); ?>/adminauth/delete_program/<?php echo $program->id; ?>">
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
