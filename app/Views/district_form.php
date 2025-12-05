<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo empty($id) ? 'New District' : 'Edit District' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
// Editing Mode Check
if(isset($district)){
  $id   = $district->district_id;
  $name = $district->district_name;
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
        <h5><?php echo empty($id) ? 'Add New District' : 'Edit District' ?></h5>
        <small>State: <strong><?php echo $state->state_name ?></strong></small>
      </div>

      <div class="card-body">

        <form method="post" action="<?php echo base_url('common/save_district'); ?>">

          <!-- Hidden IDs -->
          <input type="hidden" name="district_id" value="<?php echo $id; ?>">
          <input type="hidden" name="state_id" value="<?php echo $state->state_id; ?>">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">District Name</label>
              <input type="text" name="district_name" class="form-control"
                     value="<?php echo $name; ?>" required>
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
                <?php echo empty($id) ? 'Save District' : 'Update District' ?>
              </button>
              <a href="<?php echo base_url('common/state_districts/'.$state->state_id); ?>" class="btn btn-secondary ms-2">
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
