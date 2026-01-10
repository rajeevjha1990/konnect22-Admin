<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?php echo empty($id) ? 'New Village' : 'Edit Village' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
// Editing Mode Check
if (isset($village)) {
  $id   = $village->village_id;
  $name = $village->village_name;
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
        <h5><?php echo empty($id) ? 'Add New Village' : 'Edit Village' ?></h5>
        <small>Block: <strong><?php echo $block->block_name ?></strong></small>
      </div>

      <div class="card-body">

        <!-- FORM START -->
        <form method="post" action="<?php echo base_url('common/save_village'); ?>">

          <!-- Hidden IDs -->
          <input type="hidden" name="village_id" value="<?php echo $id; ?>">
          <input type="hidden" name="village_block" value="<?php echo $block->block_id; ?>">

          <div class="row g-3">

            <!-- Village Name -->
            <div class="col-md-12">
              <label class="form-label">Village Name</label>
              <input
                type="text"
                name="village_name"
                class="form-control"
                value="<?php echo $name; ?>"
                placeholder="Enter Village Name"
                required
              >
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
                <?php echo empty($id) ? 'Save Village' : 'Update Village' ?>
              </button>

              <a href="<?php echo base_url('common/villages/'.$block->block_id); ?>" class="btn btn-secondary ms-2">
                Cancel
              </a>
            </div>

          </div>

        </form>
        <!-- FORM END -->

      </div>

    </div>

  </div>
</div>
</body>
</html>
