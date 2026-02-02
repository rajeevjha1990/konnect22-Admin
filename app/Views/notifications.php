<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/admin.css">
</head>

<body>
<div class="content">

<h2>
  <span style="font-size:22px; font-weight:bold;">Notifications</span><br>
  <small style="color:#555;">Notification List</small>
</h2>

<div style="text-align:right;">
    <a href="<?php echo base_url(); ?>/adminauth/create_notification" class="new-btn">
        + New Notification
    </a>
</div>

<table id="myTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php if (!empty($notifications)) {
        $i = 1;
        foreach ($notifications as $row) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo esc($row->nftn_title); ?></td>
                <td><?php echo esc($row->nftn_text); ?></td>
                <td>
                    <a class="action-btn btn-edit"
                       href="<?php echo base_url(); ?>/adminauth/edit_notification/<?php echo $row->nftn_id; ?>">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>

                    <a class="action-btn btn-delete delete_data"
                       href="<?php echo base_url(); ?>/adminauth/delete_notification/<?php echo $row->nftn_id; ?>">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
    <?php } } ?>
    </tbody>
</table>

</div>
</body>
</html>
