<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Banners</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">
</head>

<body>

<div class="content">

    <div style="text-align:right; margin-bottom:15px;">

        <a href="javascript:history.back()" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>

        <a href="<?= base_url();?>/banner/add" class="new-btn">
            + New Banner
        </a>

    </div>

    <table id="myTable" class="display" style="width:100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($banners as $row){ ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td>

                    <?php if(!empty($row['image'])){ ?>

                        <img src="<?= base_url('uploads/banners/'.$row['image']) ?>"
                             width="80"
                             height="50"
                             style="object-fit:cover;border-radius:6px;">

                    <?php }else{ ?>

                        <img src="<?= base_url('assets/images/no-image.png')?>"
                             width="80">

                    <?php } ?>

                </td>

                <td><?= $row['title']; ?></td>

                <td><?= $row['subtitle']; ?></td>

                <td>

                    <?php if($row['status'] == 1){ ?>

                        <span class="badge bg-success">
                            Active
                        </span>

                    <?php }else{ ?>

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                    <?php } ?>

                </td>

                <td>
                    <?= date('d M Y h:i A', strtotime($row['created'])) ?>
                </td>

                <td>

                    <a class="action-btn btn-edit"
                       href="<?= base_url();?>/banner/edit/<?= $row['id']; ?>">

                        <i class="fa-solid fa-pen"></i>
                        Edit

                    </a>

                    <a class="action-btn btn-delete delete_data"
                       href="<?= base_url();?>/banner/delete/<?= $row['id']; ?>">

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