

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reassign Order</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        .card { border: 1px solid #ccc; padding: 15px; border-radius: 5px; background: #fff; }
        .card h2, .card h3 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        select, input, button { padding: 8px; width: 100%; }
        button { background: #007bff; color: #fff; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background: #0056b3; }
        /* Flexbox row for side-by-side cards */
        .row { display: flex; gap: 20px; }
        .col { flex: 1; }
    </style>
</head>
<body>

<div class="content">
<div class="card">
    <h2><?php echo $programdetails->name; ?></h2>
    <p><?php echo $programdetails->short_desc; ?></p>
</div>

<div class="row">
    <!-- Order Details -->
    <div class="col">
        <div class="card">
            <h3>Order Details</h3>
            <p><strong>Order Name:</strong> <?php echo $assignedorders->order_name; ?></p>
            <p><strong>Order Number:</strong> <?php echo $assignedorders->order_number; ?></p>
            <p><strong>Pincode:</strong> <?php echo $assignedorders->order_pincode; ?></p>
            <p><strong>Address:</strong> <?php echo $assignedorders->order_address; ?></p>
            <p><strong>Amount:</strong> ₹<?php echo $assignedorders->amount; ?></p>
            <p><strong>Payment Mode:</strong> <?php echo $assignedorders->payment_mode; ?></p>
            <p><strong>Status:</strong> <?php echo $assignedorders->payment_status; ?></p>
        </div>
    </div>

    <!-- Reassign Form -->
    <div class="col">
        <div class="card">
    <h3>Reassign Order</h3>
    <form method="post" action="reassign_order.php">
        <input type="hidden" name="order_id" value="<?php echo $assignedorders->order_id; ?>">
        
        <div class="form-group">
            <label for="associate">Select Associate</label>
            <select name="associate_id" id="associate" required>
                <option value="">-- Choose Associate --</option>
                <?php foreach($associates as $associate) { 
                  if($assignedorders->associate_id == $associate->volntr_id){
                      $s='selected';
                  }else{
                    $s='';
                  }
                  ?>
                    <option value="<?php echo $associate->volntr_id; ?>"
                        <?php echo $s ;?>>
                        <?php echo $associate->volntr_name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <button type="submit">Reassign</button>
    </form>
</div>
</div>
</div>
</body>
</html>
