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
                    <!-- Groups Button -->
                    <a class="action-btn btn-group" href="<?= base_url(); ?>/adminauth/volunteer_groups/<?php echo ?>">
                        <i class="fa-solid fa-users"></i> Groups
                    </a>

                    <!-- Saintri Distribution Button -->
                    <a class="action-btn btn-saintri" href="<?= base_url(); ?>/adminauth/permission_granted/">
                        <i class="fa-solid fa-hand-holding-heart"></i> Saintri Distribution
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
