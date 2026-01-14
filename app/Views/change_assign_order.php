<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reassign Order</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        .card { border: 1px solid #ccc; padding: 15px; border-radius: 5px; background: #fff; margin-bottom: 20px; }
        .card h2, .card h3 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        select, input, button { padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007bff; color: #fff; border: none; cursor: pointer; font-weight: bold; }
        button:hover { background: #0056b3; }
        .row { display: flex; gap: 20px; }
        .col { flex: 1; }
        .shadow { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        /* Fix for Select2 height */
        .select2-container .select2-selection--single { height: 38px !important; padding-top: 5px; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="content">
        <!-- Program Details Card -->
        <div class="card shadow">
            <h2><?php echo $programdetails->name; ?></h2>
            <p><?php echo $programdetails->short_desc; ?></p>
        </div>

        <div class="row">
            <!-- Order Details Column -->
            <div class="col">
                <div class="card shadow">
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

            <!-- Reassign Form Column -->
            <div class="col">
                <div class="card shadow">
                    <h3>Reassign Order</h3>
                    <form method="post" action="<?php echo base_url('common/re_assign_order'); ?>">
                        <input type="hidden" name="order_id" value="<?php echo $assignedorders->order_id; ?>">
                        <input type="hidden" name="program_id" value="<?php echo $assignedorders->program_id; ?>">
                        <input type="hidden" name="pincode" value="<?php echo $assignedorders->order_pincode; ?>">
                        
                        <div class="form-group">
                            <label for="associate">Select Associate</label>
                            <select name="associate_id" id="associate" class="searchable-select" required>
                                <option value="">-- Choose Associate --</option>
                                <?php foreach($associates as $associate) { 
                                    if(($assignedorders->associate_id == $associate->volntr_id)){
                                    $selected ='selected';
                                    }else{
                                        $selected ='';
                                    }
                                ?>
                        <option <?php echo $selected; ?> value="<?php echo $associate->volntr_id; ?>" >
                                        <?php echo $associate->volntr_name . " " . $associate->volntr_ep_temp; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <button type="submit">Reassign Now</button>
                    </form>
                </div>
            </div> <!-- col end -->
        </div> <!-- row end -->
    </div> <!-- content end -->
</div> <!-- container end -->
</body>
</html>
