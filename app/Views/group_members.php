<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group members</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<style>
.page-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.volunteer-name {
    color: #007bff;   /* Blue for Volunteer */
    font-weight: 700;
}

.volunteer-ep {
    color: #555;
    font-size: 16px;
}

.group-name {
    color: #28a745;   /* Green for Group */
    font-weight: 700;
}

</style>
<body>
<div class="content">
        <h2 class="page-title">
        <span class="volunteer-name">
            <?= $volunteer->volntr_name; ?>
        </span>
        <span class="volunteer-ep">
            (<?= $volunteer->volntr_ep_temp; ?>)
        </span>
        –
        <span class="group-name">
            <?= $group->group_name; ?>
        </span>
        Group Members
    </h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>EpNo</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($groupmembers as $member) {
            ?>
            <tr>
                <td><?php echo $member->epno; ?></td>
                <td><?php echo $member->name; ?></td>
                <td><?php echo $member->mobile; ?></td>
                <td>
                    <?php echo (!empty($member->role)) ? $member->role : 'Not Assigned'; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
