<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>    <?php echo $volunteer->volntr_ep_temp . ' ' . $volunteer->volntr_name; ?> Groups
 </title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">

</head>
<body>
<div class="content">
    <h2>
    <?php echo  $volunteer->volntr_name; ?> (<?php echo $volunteer->volntr_ep_temp; ?>) Groups
    </h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Epno</th>
                <th>Senior Epno</th>
                <th>Name</th>
                <th>Program</th>
                <th>Number of Member</th>
                <th>Group Start Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($groups as $group) {

            ?>
            <tr>
                <td><?php echo $group->group_epno; ?></td>
                <td><?php echo $group->group_senior_epno; ?></td>
                <td><?php echo $group->group_name; ?></td>
                <td><?php echo $group->group_program; ?></td>
                <td>
                  <a class="action-btn btn-group icon-only"
                     href="<?= base_url(); ?>/adminauth/group_members/<?php echo $group->group_id; ?>/<?php echo $group->group_volunteer; ?>"
                     title="View Members">
                      <i class="fa-solid fa-eye"></i><?php echo $group->group_noof_member; ?>
                  </a>
                </td>
                <td><?php echo $group->group_start_date; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
