<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock List</title>
        <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">
</head>
<body>
<div class="content">
    <h2>Group Edit Requests</h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Volunteer</th>
                <th>Groups</th>
                <th>Reason</th>
                <th>Permission</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($groupeditrequests as $request) { ?>
                <tr>
                    <td><?php echo $request->volntr_name.$request->volntr_ep_temp; ?></td>
                    <td><?php echo $request->group_name; ?></td>
                    <td><?php echo $request->reason; ?></td>
                    <td>
                      <a class="btn btn-success approve_request" href="<?php echo base_url(); ?>/adminauth/permission_granted/<?php echo $request->id;?>/<?php echo $request->group_id; ?>">
                       Permission
                    </a>
                    </td>
                </tr>
                <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
