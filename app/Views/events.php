<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/admin.css">
</head>
<body>

<div class="content">
    <h2>Events</h2>

    <div style="text-align:right;">
        <a href="<?php echo base_url('adminauth/new_event'); ?>" class="new-btn">+ New Event</a>
    </div>

    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Icon</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if (!empty($events)) : ?>
            <?php foreach ($events as $event) : ?>
                <tr>
                    <td><?= esc($event->event_name); ?></td>
                    <td><?= date('d-m-Y', strtotime($event->event_date)); ?></td>
                    <td>
                        <?php if (!empty($event->event_icon)) : ?>
                            <img src="<?= base_url('uploads/event_icons/' . $event->event_icon); ?>" height="35">
                        <?php else : ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="action-btn btn-edit"
                           href="<?= base_url('adminauth/edit_event/' . $event->event_id); ?>">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>

                        <a class="action-btn btn-delete delete_data"
                           href="<?= base_url('adminauth/delete_event/' . $event->event_id); ?>"
                           onclick="return confirm('Are you sure you want to delete this event?');">
                            <i class="fa-solid fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        </tbody>
    </table>
</div>

</body>
</html>
