<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendors</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet"
          href="<?php echo base_url();?>/assets/css/admin.css">

</head>

<body>

<div class="content">

<div style="text-align:right;">

    <a href="javascript:history.back()" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>

    <a href="<?php echo base_url();?>/vendor/add"
       class="new-btn">
       + New Vendor
    </a>

</div>

<table id="myTable"
       class="display"
       style="width:100%">

    <thead>

        <tr>

            <th>ID</th>

            <th>Vendor Code</th>

            <th>Shop Name</th>

            <th>Owner Name</th>

            <th>Mobile</th>

            <th>Email</th>

            <th>Status</th>

            <th>Created At</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

    <?php

    $i = 1;

    foreach ($vendors as $row) {

    ?>

        <tr>

            <td>
                <?php echo $i++; ?>
            </td>

            <td>
                <?php echo !empty($row->vendor_code)
                    ? $row->vendor_code
                    : '-'; ?>
            </td>

            <td>
                <?php echo !empty($row->shop_name)
                    ? $row->shop_name
                    : '-'; ?>
            </td>

            <td>
                <?php echo !empty($row->owner_name)
                    ? $row->owner_name
                    : '-'; ?>
            </td>

            <td>
                <?php echo !empty($row->mobile)
                    ? $row->mobile
                    : '-'; ?>
            </td>

            <td>
                <?php echo !empty($row->email)
                    ? $row->email
                    : '-'; ?>
            </td>

            <td>

                <?php if($row->status == 'Active'){ ?>

                    <span class="badge bg-success">
                        Active
                    </span>

                <?php } else { ?>

                    <span class="badge bg-danger">
                        Inactive
                    </span>

                <?php } ?>

            </td>

            <td>

                <?php

                echo !empty($row->created_at)
                    ? date(
                        'd M Y',
                        strtotime($row->created_at)
                    )
                    : '-';

                ?>

            </td>

            <td>

                <a class="action-btn btn-edit"
                   href="<?php echo base_url();?>/vendor/edit/<?php echo $row->id; ?>">

                    <i class="fa-solid fa-pen"></i>
                    Edit

                </a>

                <a class="action-btn btn-delete delete_data"
                   href="<?php echo base_url();?>/vendor/delete/<?php echo $row->id; ?>">

                    <i class="fa-solid fa-trash"></i>
                    Delete

                </a>

            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>

</div>

</body>
</html>