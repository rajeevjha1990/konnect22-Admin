<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Create Notifications</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
  <?php 
    if(isset($notification)){
      $id=$notification->nftn_id;
      $title=$notification->nftn_title;
      $text=$notification->nftn_text;
    }else{
      $id='';
      $title='';
      $text='';
    }
  ?>
<body>
<div class="container mt-5">
  <div class="content">
    <div class="card shadow">
      <div class="card-header bg-primary text-white text-center">
        <h5>Create Notifications</h5>
      </div>
      <div class="card-body">

        <form method="post" action="<?php echo base_url('adminauth/save_notification'); ?>">
          <input type="hidden" value="<?php echo $id; ?>" name="id">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">Title</label>
              <input
                type="text"
                name="nftn_title"
                class="form-control"
                value="<?php echo $title;?>"
                required
              >
            </div>
              <div class="col-md-12">
              <label class="form-label">Description</label>
              <input
                type="text"
                name="nftn_text"
                class="form-control"
                value="<?php echo $text;?>"
                required
              >
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-success px-5">
               Save Notification
              </button>

              <a href="" class="btn btn-secondary ms-2">
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
