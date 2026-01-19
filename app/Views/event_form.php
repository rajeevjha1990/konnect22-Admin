<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= empty($event_id) ? 'New Event' : 'Edit Event' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
if (isset($event)) {
    $event_id   = $event->event_id;
    $event_icon = $event->event_icon;
    $event_name = $event->event_name;
    $event_date = $event->event_date;
} else {
    $event_id   = '';
    $event_icon = '';
    $event_name = '';
    $event_date = '';
}
?>

<body>
<div class="container mt-5">
  <div class="content">
    <div class="card shadow">
      <div class="card-header bg-success text-white text-center">
        <h5><?= empty($event_id) ? 'New Event' : 'Edit Event' ?></h5>
      </div>

      <div class="card-body">

        <form method="post" action="<?= base_url('adminauth/save_event_master'); ?>" enctype="multipart/form-data">

          <!-- Hidden Event ID -->
          <input type="hidden" name="event_id" value="<?= esc($event_id) ?>">

          <div class="row g-3">

            <!-- Event Icon -->
            <div class="col-md-4">
              <label class="form-label">Event Icon</label>
              <!-- If you want image upload -->
              <input type="file" name="event_icon" class="form-control">

              <?php if (!empty($event_icon)): ?>
                <small class="d-block mt-1">Current Icon:</small>
                <img src="<?= base_url('uploads/event_icons/' . $event_icon) ?>" height="40">
              <?php endif; ?>
            </div>

            <!-- Event Name -->
            <div class="col-md-8">
              <label class="form-label">Event Name</label>
              <input type="text" name="event_name" value="<?= esc($event_name) ?>"
                     class="form-control" required>
            </div>

            <!-- Event Date -->
            <div class="col-md-6">
              <label class="form-label">Event Date</label>
              <input type="date" name="event_date" value="<?= esc($event_date) ?>"
                     class="form-control" required>
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
                <?= empty($event_id) ? 'Save Event' : 'Update Event' ?>
              </button>
              <a href="<?= base_url('adminauth/events'); ?>" class="btn btn-secondary ms-2">
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
