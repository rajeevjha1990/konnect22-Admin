<div class="sidebar">

  <h2>सबका विकास जयति</h2>
  <ul class="menu">

    <li>
      <a href="<?= base_url('dashboard'); ?>">
        <i class="fas fa-home"></i> Dashboard
      </a>
    </li>

    <!-- Master Data Accordion -->
    <li>
      <a href="javascript:void(0)" class="accordion-btn">
        <i class="fas fa-database"></i> Master Data
        <i class="fas fa-chevron-down" style="float:right"></i>
      </a>
      <ul class="submenu">
        <li>
          <a href="<?= base_url('adminauth/programs'); ?>">
            <i class="fas fa-list-alt"></i> Programs
          </a>
        </li>
        <li>
          <a href="<?= base_url('common/states'); ?>">
            <i class="fas fa-map-marked-alt"></i> States
          </a>
        </li>
        <li>
          <a href="<?= base_url('adminauth/events'); ?>">
            <i class="fas fa-calendar-check"></i>
             Events
          </a>
        </li>
      </ul>
    </li>

    <li>
      <a href="<?= base_url('adminauth/volunteers'); ?>">
        <i class="fas fa-users"></i> Associates
      </a>
    </li>
    <li>
      <a href="javascript:void(0)" class="accordion-btn">
        <i class="fas fa-hand-holding-medical"></i>Website Orders 
        <i class="fas fa-chevron-down" style="float:right"></i>
      </a>
      <ul class="submenu">
        <?php if(!empty($programs)): ?>
            <?php foreach($programs as $prog): ?>
                <li>
                  <a href="<?= base_url('common/sanitry_orders/'.$prog->id); ?>">
                    <i class="fas fa-chevron-right" style="font-size: 10px;"></i> 
                    <?= $prog->name; ?>
                  </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li><a href="#">No Programs Found</a></li>
        <?php endif; ?>
      </ul>
    </li>

    <li>
      <a href="<?= base_url('auth/group_edit_requests'); ?>">
        <i class="fas fa-edit"></i> Group Edit Requests
      </a>
    </li>
    <li>
      <a href="<?= base_url('adminauth/group_edit_requests'); ?>">
        <i class="fas fa-edit"></i> News & Events
      </a>
    </li>
    <li>
      <a href="<?= base_url('adminauth/create_notification'); ?>">
        <i class="fas fa-bell"></i> Notifications
      </a>
    </li>
    <li>
      <a href="<?= base_url('adminauth/create_message'); ?>">
        <i class="fas fa-envelope"></i> New Message
      </a>
    </li>
  </ul>
</div>
