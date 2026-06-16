<div class="content">

    <?php $order = $items[0]; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Order Details</h2>

        <a href="<?= base_url('order') ?>" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">

        <!-- Customer Details -->
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    Customer Information
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <th width="35%">Order No</th>
                            <td><?= $order['order_no']; ?></td>
                        </tr>

                        <tr>
                            <th>Customer</th>
                            <td><?= $order['order_name']; ?></td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td><?= $order['order_number']; ?></td>
                        </tr>

                        <tr>
                            <th>Address</th>
                            <td>
                                <?= $order['order_address']; ?><br>
                                <?= $order['order_city']; ?> -
                                <?= $order['order_pincode']; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Landmark</th>
                            <td><?= $order['order_landmark']; ?></td>
                        </tr>

                    </table>

                </div>
            </div>

        </div>

        <!-- Order Details -->
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-success text-white">
                    Order Information
                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <th width="40%">Payment Mode</th>
                            <td><?= strtoupper($order['payment_mode']); ?></td>
                        </tr>

                        <tr>
                            <th>Payment Status</th>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <?= ucfirst($order['payment_status']); ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Order Status</th>
                            <td>

                                <?php
                                $statusClass = 'secondary';

                                if ($order['status'] == 'Pending') {
                                    $statusClass = 'warning';
                                } elseif ($order['status'] == 'Processing') {
                                    $statusClass = 'info';
                                } elseif ($order['status'] == 'Shipped') {
                                    $statusClass = 'primary';
                                } elseif ($order['status'] == 'Delivered') {
                                    $statusClass = 'success';
                                } elseif ($order['status'] == 'Cancelled') {
                                    $statusClass = 'danger';
                                }
                                ?>

                                <span class="badge bg-<?= $statusClass ?>">
                                    <?= $order['status']; ?>
                                </span>

                            </td>
                        </tr>

                        <tr>
                            <th>Total Amount</th>
                            <td>
                                <strong class="text-success">
                                    ₹<?= number_format($order['total'], 2); ?>
                                </strong>
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- Products -->

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            Ordered Products
        </div>

        <div class="card-body p-0">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                <tr>
                    <th width="100">Image</th>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

                </thead>

                <tbody>

                <?php
                $grandTotal = 0;

                foreach ($items as $item):

                    $lineTotal = $item['price'] * $item['qty'];
                    $grandTotal += $lineTotal;
                ?>

                <tr>

                    <td>

                        <?php if (!empty($item['image_webp'])) : ?>

                            <img
                                src="<?= base_url('uploads/products/'.$item['image_webp']) ?>"
                                width="70"
                                height="70"
                                style="object-fit:cover;border-radius:8px;">

                        <?php endif; ?>

                    </td>

                    <td>
                        <strong><?= $item['product_name']; ?></strong>
                    </td>

                    <td>
                        <span class="badge bg-info text-dark">
                            <?= $item['vendor_name']; ?>
                        </span>
                    </td>

                    <td>
                        ₹<?= number_format($item['price'],2); ?>
                    </td>

                    <td>
                        <?= $item['qty']; ?>
                    </td>

                    <td>
                        ₹<?= number_format($lineTotal,2); ?>
                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

                <tfoot>

                <tr>

                    <th colspan="5" class="text-end">
                        Grand Total
                    </th>

                    <th class="text-success">
                        ₹<?= number_format($grandTotal,2); ?>
                    </th>

                </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>