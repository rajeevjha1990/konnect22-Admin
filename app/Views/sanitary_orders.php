<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders List</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Your Admin CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/admin.css">
</head>
<body>

<div class="content">

<h2>
  <span style="font-size:22px; font-weight:bold;">Sanitary Orders</span><br>
</h2>

<div style="text-align:right;">
  <a href="javascript:history.back()" class="back-btn">
      <i class="fa-solid fa-arrow-left"></i> Back
  </a>
</div>

<table id="myTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Program</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Pincode</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Assigne To</th>
        </tr>
    </thead>

    <tbody>
    <?php $i=1; foreach ($orders as $row) {  ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->order_name; ?></td>
            <td><?php echo $row->order_number; ?></td>
            <td><?php echo $row->order_pincode; ?></td>
            <td>₹<?php echo $row->amount; ?></td>
            <td><?php echo ucfirst($row->payment_mode); ?></td>
            <td>
                <?php if($row->payment_status == 'success'){ ?>
                    <span style="color:green;font-weight:bold;">Success</span>
                <?php } else { ?>
                    <span style="color:red;font-weight:bold;">Pending</span>
                <?php } ?>
            </td>

           <td>
            <?php if(!empty($row->associate_id)){ ?>
                <b><?php echo $row->volntr_name . "<br>" . $row->volntr_ep_temp; ?>
 </b><br>
            <?php } else { ?>
                <span style="color:red;">Not Assigned</span><br>
            <?php } ?>

           <a href="<?php echo base_url();?>/common/change_assign_order/<?php echo $row->order_id;?>/<?php echo $row->order_pincode;?>/<?php echo $row->program_id;?>/<?php echo !empty($row->associate_id) ? $row->associate_id : 0; ?>" 
               class="assign-btn">
               Change Associate
            </a>
        </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</div>

</body>
</html>
