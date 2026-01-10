<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= empty($id) ? 'New Program' : 'Edit Program' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
if(isset($program)){
  $id         = $program->id;
  $icon       = $program->icon;
  $name       = $program->name;
  $short_desc = $program->short_desc;
}else{
  $id         = '';
  $icon       = '';
  $name       = '';
  $short_desc = '';
}
?>

<body>
<div class="container mt-5">
  <div class="content">
    <div class="card shadow">
      <div class="card-header bg-primary text-white text-center">
        <h5><?php echo empty($id) ? 'New Program' : 'Edit Program' ?></h5>
      </div>

      <div class="card-body">

        <form method="post" action="<?= base_url(); ?>/adminauth/save_program">

          <!-- Hidden ID -->
          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="row g-3">

            <!-- Program Icon -->
            <div class="col-md-4">
              <label class="form-label">Program Icon</label>
              <input type="text" name="icon" value="<?php echo $icon; ?>"
                     class="form-control" placeholder="e.g. fa-solid fa-leaf" required>
            </div>

            <!-- Program Name -->
            <div class="col-md-8">
              <label class="form-label">Program Name</label>
              <input type="text" name="name" value="<?php echo $name; ?>"
                     class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Short Description</label>
              <textarea name="short_desc" class="form-control" rows="3" required><?php echo $short_desc; ?></textarea>
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
                <?= empty($id) ? 'Save Program' : 'Update Program' ?>
              </button>
              <a href="<?php echo base_url('adminauth/programs'); ?>" class="btn btn-secondary ms-2">
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
