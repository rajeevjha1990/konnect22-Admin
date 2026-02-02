<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Create Message</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .chat-box {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 15px;
    }

    .chat-bubble {
      background: #e9f2ff;
      padding: 12px 15px;
      border-radius: 12px;
      max-width: 100%;
      font-size: 15px;
    }

    .chat-bubble label {
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
    }
  </style>
</head>

<body>
<div class="container mt-5">
  <div class="content">

    <div class="card shadow">

      <div class="card-header bg-primary text-white text-center">
        <h5>Create Message</h5>
        <small>Admin → User / Users</small>
      </div>

      <div class="card-body">

        <form method="post" action="<?= base_url('admin/messages/store') ?>">

          <div class="row g-3">

            <!-- Message Title -->
            <div class="col-md-12">
              <label class="form-label">Message Title</label>
              <input
                type="text"
                name="msg_title"
                class="form-control"
                placeholder="Enter message title"
                required
              >
            </div>

            <!-- Conversation Box -->
            <div class="col-md-12">
              <div class="chat-box">
                <div class="chat-bubble">
                  <label>Message Content</label>
                  <textarea
                    name="msg_text"
                    class="form-control"
                    rows="4"
                    placeholder="Type your message here..."
                    required
                  ></textarea>
                </div>
              </div>
            </div>

            <!-- User Selection -->
            <div class="col-md-12">
              <label class="form-label">Send To</label>
              <select name="user_ids[]" class="form-control" multiple required>
                <?php foreach ($users as $u): ?>
                  <option value="<?= $u['id'] ?>">
                    <?= esc($u['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">
                Single select = One-to-One, Multiple = One-to-Many
              </small>
            </div>

            <!-- Actions -->
            <
