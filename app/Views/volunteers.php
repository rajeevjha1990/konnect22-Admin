<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Associates</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">
</head>
<style>
.highlight {
    background-color: #007bff !important;
    color: #fff !important;
    border-color: #0056b3 !important;
    font-weight: bold;
}

.highlight i {
    color: #fff !important;
}
</style>
<body>
<div class="content">
    <h2>Associates</h2>
    <div style="text-align:right;">
        <a href="<?php echo base_url();?>/adminauth/new_associate" class="new-btn">+ New Associate</a>
    </div>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>EP No</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($volunteers as $request) { ?>
            <tr>
                <td>
                  <a class="action-btn btn-group highlight"
                     href="<?php echo base_url(); ?>/common/associate_details/<?php echo $request->volntr_id; ?>">
                      <i class="fa-solid fa-eye"></i> <?php echo $request->volntr_ep_temp; ?>
                  </a>
                </td>
                <td><?php echo $request->volntr_name; ?></td>
                <td><?php echo $request->volntr_mobile; ?></td>
                <td><?php echo $request->volntr_email; ?></td>
                <td>
          <?php if($request->has_group) { ?>
            <a class="action-btn btn-group highlight"
               href="<?php echo base_url(); ?>/adminauth/volunteer_groups/<?php echo $request->volntr_id; ?>">
                <i class="fa-solid fa-users"></i> Groups
                <span class="badge"><?php echo $request->has_group; ?></span>
            </a>
            <?php } ?>

            <?php if($request->has_saintri) { ?>
            <a class="action-btn btn-saintri highlight"
               href="<?php echo base_url(); ?>/adminauth/saintri_distribution/<?php echo $request->volntr_id; ?>">
                <i class="fa-solid fa-hand-holding-heart"></i> Saintri
                <span class="badge"><?php echo $request->has_saintri; ?></span>
            </a>
            <?php } ?>
            <a class="action-btn btn-edit" href="<?php echo base_url(); ?>/adminauth/edit_associate/<?php echo $request->volntr_id; ?>">
                  <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a class="action-btn btn-delete delete_data"
                 href="<?php echo base_url(); ?>/adminauth/delete_associate/<?php echo $request->volntr_id; ?>">
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
