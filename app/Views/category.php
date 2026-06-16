<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Categories</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">

</head>

<body>

    <div class="content">

        <div style="text-align:right;">

            <a href="javascript:history.back()" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            <a href="<?= base_url(); ?>/category/add" class="new-btn">
+ New Category
</a>

        </div>

        <table id="myTable" class="display" style="width:100%">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
$i = 1;

if (!empty($categories)) :

foreach ($categories as $row) :
?>

                    <tr>

                        <td>
                            <?= $i++; ?>
                        </td>

                        <td>

                            <?php if (!empty($row['image_url'])) : ?>

                                <img src="<?= base_url('uploads/categories/' . $row['image_url']) ?>" width="60" height="60" style="border-radius:8px;object-fit:cover;">

                                <?php else : ?>

                                    <img src="<?= base_url('assets/images/no-image.png') ?>" width="60" height="60">

                                    <?php endif; ?>

                        </td>

                        <td>
                            <?= esc($row['name'] ?? '-'); ?>
                        </td>

                        <td>

                            <?php if (($row['status'] ?? '') == 'active') : ?>

                                <span class="badge bg-success">
Active
</span>

                                <?php else : ?>

                                    <span class="badge bg-danger">
Inactive
</span>

                                    <?php endif; ?>

                        </td>

                        <td>

                            <?= !empty($row['created_at'])
? date('d M Y', strtotime($row['created_at']))
: '-'; ?>

                        </td>

                        <td>

                            <a class="action-btn btn-edit" href="<?= base_url('category/edit/' . $row['id']); ?>">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>

                            <a class="action-btn btn-delete delete_data" href="<?= base_url('category/delete/' . $row['id']); ?>">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>

                        </td>

                    </tr>

                    <?php
endforeach;

endif;
?>

            </tbody>

        </table>

    </div>

</body>

</html>