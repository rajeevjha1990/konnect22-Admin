<div class="content">

    <h2>Orders</h2>

    <table id="myTable" class="display">

        <thead>
        <tr>
            <th>ID</th>
            <th>Order No</th>
            <th>Customer</th>
            <th>Mobile</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>

        <?php
        $i = 1;
        foreach($orders as $row){
        ?>

        <tr>

            <td><?= $i++; ?></td>

            <td><?= $row['order_no']; ?></td>

            <td><?= $row['order_name']; ?></td>

            <td><?= $row['order_number']; ?></td>

            <td>₹<?= $row['total']; ?></td>

            <td><?= $row['payment_mode']; ?></td>

            <td>

                <?php if($row['status']=='Pending'){ ?>

                    <span class="badge bg-warning">
                        Pending
                    </span>

                <?php }elseif($row['status']=='Delivered'){ ?>

                    <span class="badge bg-success">
                        Delivered
                    </span>

                <?php }elseif($row['status']=='Cancelled'){ ?>

                    <span class="badge bg-danger">
                        Cancelled
                    </span>

                <?php }else{ ?>

                    <span class="badge bg-info">
                        <?= $row['status']; ?>
                    </span>

                <?php } ?>

            </td>

            <td>
                <?= date('d M Y', strtotime($row['created_at'])); ?>
            </td>

<td>

    <a href="<?= base_url('order/details/'.$row['id']) ?>"
       class="btn btn-primary btn-sm mb-2">
        View
    </a>

    <form action="<?= base_url('order/status/'.$row['id']); ?>"
          method="post">

        <select name="status"
                onchange="this.form.submit()">

            <option value="Pending"
                <?= $row['status']=='Pending'?'selected':'' ?>>
                Pending
            </option>

            <option value="Processing"
                <?= $row['status']=='Processing'?'selected':'' ?>>
                Processing
            </option>

            <option value="Shipped"
                <?= $row['status']=='Shipped'?'selected':'' ?>>
                Shipped
            </option>

            <option value="Delivered"
                <?= $row['status']=='Delivered'?'selected':'' ?>>
                Delivered
            </option>

            <option value="Cancelled"
                <?= $row['status']=='Cancelled'?'selected':'' ?>>
                Cancelled
            </option>

        </select>

    </form>

</td>

        </tr>

        <?php } ?>

        </tbody>

    </table>

</div>