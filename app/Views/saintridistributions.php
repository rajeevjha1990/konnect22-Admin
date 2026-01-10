<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member List</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="content">
    <h2>Distributed Saintri by<br> <?php echo $volunteer->volntr_name.'-'.($volunteer->volntr_ep_temp);?></h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Block/Village</th>
                <th>Mobile</th>
                <th>District</th>
                <th>Pincode</th>
                <th>Issue Date</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($saintridistributions as $m) { ?>
            <tr>
                <td><?php echo $m->member_name; ?></td>
                <td><?php echo $m->village.''.$m->village; ?></td>
                <td><?php echo $m->mobile; ?></td>
                <td><?php echo $m->district_name; ?></td>
                <td><?php echo $m->pincode; ?></td>
                <td><?php echo date("d M Y", strtotime($m->issue_date)); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
