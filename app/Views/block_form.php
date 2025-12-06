<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?php echo empty($id) ? 'New Block' : 'Edit Block' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
// Editing Mode Check
if (isset($block)) {
  $id   = $block->block_id;
  $name = $block->block_name;
} else {
  $id   = '';
  $name = '';
}
?>

<body>
<div class="container mt-5">
  <div class="content">

    <div class="card shadow">

      <div class="card-header bg-primary text-white text-center">
        <h5><?php echo empty($id) ? 'Add New Block' : 'Edit Block' ?></h5>
        <small>District: <strong><?php echo $district->district_name ?></strong></small>
      </div>

      <div class="card-body">

        <form method="post" action="<?php echo base_url('common/save_block'); ?>">

          <!-- Hidden IDs -->
          <input type="hidden" name="block_id" value="<?php echo $id; ?>">
          <input type="hidden" name="block_district" value="<?php echo $district->district_id; ?>">

          <div class="row g-3">

            <div class="col-md-12">
              <label class="form-label">Block Name</label>
              <input
                type="text"
                name="block_name"
                class="form-control"
                value="<?php echo $name; ?>"
                required
              >
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
                <?php echo empty($id) ? 'Save Block' : 'Update Block' ?>
              </button>

              <a href="<?php echo base_url('common/blocks/'.$district->district_id); ?>" class="btn btn-secondary ms-2">
                Cancel
              </a>
            </div>

          </div>

        </form>

      </div>

    </div>

  </div>
</div>
</body>
</html>
