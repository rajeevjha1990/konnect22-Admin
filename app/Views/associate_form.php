<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>New Associate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
  if(isset($associate)){
    $id=$associate->volntr_id;
    $volntr_ep_temp=$associate->volntr_ep_temp;
    $volntr_name=$associate->volntr_name;
    $volntr_qualification=$associate->volntr_qualification;
    $volntr_mobile=$associate->volntr_mobile;
    $volntr_email=$associate->volntr_email;
    $volntr_address=$associate->volntr_address;
    $volntr_pincode=$associate->volntr_pincode;
    $volntr_password=$associate->volntr_password;
    $volntr_join_date=$associate->volntr_join_date;
  }else{
    $id='';
    $volntr_ep_temp='';
    $volntr_name='';
    $volntr_qualification='';
    $volntr_mobile='';
    $volntr_email='';
    $volntr_address='';
    $volntr_pincode='';
    $volntr_password='';
    $volntr_join_date='';
  }
?>
<body>
<div class="container mt-5">
  <div class="content">
    <div class="card shadow">
      <div class="card-header bg-primary text-white text-center">
        <h5>New Associate Registration</h5>
      </div>

      <div class="card-body">

        <form method="post" action="<?= base_url(); ?>/adminauth/save_volunteer">

      <input type="hidden" name="id" value="<?= $id ?>">

      <div class="row g-3">

      <!-- Temp EP -->
      <div class="col-md-4">
        <label class="form-label">Temp EP Number</label>
        <input type="text" name="volntr_ep_temp" value="<?= $volntr_ep_temp ?>" class="form-control" required>
      </div>

      <!-- Name -->
      <div class="col-md-4">
        <label class="form-label">Full Name</label>
        <input type="text" name="volntr_name" value="<?= $volntr_name ?>" class="form-control" required>
      </div>

      <!-- Qualification -->
      <div class="col-md-4">
        <label class="form-label">Qualification</label>
        <select name="volntr_qualification" class="form-control" required>
          <option value="">Select Qualification</option>
          <?php foreach ($qualifications as $q) { ?>
            <option value="<?= $q->qualification_id ?>"
              <?= ($q->qualification_id == $volntr_qualification) ? 'selected' : '' ?>>
              <?= $q->qualification_title ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <!-- Mobile -->
      <div class="col-md-4">
        <label class="form-label">Mobile</label>
        <input type="text" name="volntr_mobile" value="<?= $volntr_mobile ?>"
               class="form-control" maxlength="10" required>
      </div>

      <!-- Email -->
      <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="volntr_email" value="<?= $volntr_email ?>" class="form-control">
      </div>

      <!-- Password (ONLY FOR NEW) -->
      <?php if (empty($id)) { ?>
      <div class="col-md-4">
        <label class="form-label">Password</label>
        <input type="password" name="volntr_password" class="form-control" required>
      </div>
      <?php } else { ?>
      <div class="col-md-4">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" disabled value="********">
      </div>
      <?php } ?>

      <!-- Pincode -->
      <div class="col-md-6">
        <label class="form-label">Pincode</label>
        <input type="text" name="volntr_pincode" value="<?= $volntr_pincode ?>"
               class="form-control" maxlength="6">
      </div>

      <!-- Join Date -->
      <div class="col-md-6">
        <label class="form-label">Joining Date</label>
        <input type="date" name="volntr_join_date"
               value="<?= $volntr_join_date ?>" class="form-control" required>
      </div>

      <!-- Address -->
      <div class="col-md-12">
        <label class="form-label">Address</label>
        <textarea name="volntr_address" class="form-control"
                  rows="2"><?= $volntr_address ?></textarea>
      </div>

      <!-- Buttons -->
      <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-success px-5">
          <?= empty($id) ? 'Save Associate' : 'Update Associate' ?>
        </button>

        <a href="<?= base_url('adminauth/volunteers') ?>" class="btn btn-secondary ms-2">
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
