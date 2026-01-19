<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Associate Page</title>

  <!-- Datatable + jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>
<body>

<div class="content">

  <!-- ===========================
       Associate Details (FULL ROW)
  ============================ -->
  <div class="assoc-card"
       style="background:white;padding:15px;border:1px solid #eee;border-radius:6px;margin-bottom:20px;">
    <h2>Associate Details</h2>

    <p><strong>Name:</strong> <?php echo $volunteerdetails->volntr_name; ?></p>
    <p><strong>EP No:</strong> <?php echo $volunteerdetails->volntr_ep_temp; ?></p>
    <p><strong>Mobile:</strong> <?php echo $volunteerdetails->volntr_mobile; ?></p>
    <p><strong>Email:</strong> <?php echo $volunteerdetails->volntr_email; ?></p>
    <p><strong>Join Date:</strong> <?php echo date('d-m-Y', strtotime($volunteerdetails->volntr_join_date)) ; ?></p>
  </div>

  <!-- ===========================
         DATE FILTER
  ============================ -->
  <div class="assoc-card"
       style="background:white;padding:15px;border:1px solid #eee;border-radius:6px;margin-bottom:20px;">
    <h3>Filter by Date</h3>

    <label>From:</label>
    <input type="date" id="fromDate">

    <label style="margin-left:10px;">To:</label>
    <input type="date" id="toDate">

    <button onclick="applyFilter()" style="margin-left:10px;">Apply</button>
    <button onclick="clearFilter()" style="margin-left:5px;">Clear</button>
  </div>

  <!-- ===========================
       TWO COLUMN LAYOUT
  ============================ -->
  <div class="row2" style="display:flex; gap:20px;">

    <!-- LEFT COLUMN = GROUP TABLE -->
    <div class="col" style="flex:1;">
      <h3>Groups</h3>
      <table id="groupTable" class="display" style="width:100%">
        <thead>
        <tr>
          <th>Group Name</th>
          <th>Members</th>
          <th>Senior EP</th>
          <th>Created</th>
        </tr>
        </thead>
        <tbody id="groupBody">
        <?php foreach ($groups as $g){ ?>
          <tr>
            <td><?php echo $g->group_name; ?></td>
            <td>
              <a href="<?php echo base_url('adminauth/group_members/'.$g->group_id.'/'.$g->group_volunteer); ?>">
              <?php echo $g->group_noof_member; ?> View Members
              </a>
            </td>
            <td><?php echo $g->group_senior_epno; ?></td>
            <td><?php echo date('d-m-Y', strtotime($g->group_start_date)); ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- RIGHT COLUMN = SAINITRI TABLE -->
    <div class="col" style="flex:1;">
      <h3>Saintri Distribution</h3>
      <table id="saintriTable" class="display" style="width:100%">
        <thead>
        <tr>
          <th>Member</th>
          <th>Mobile</th>
          <th>District</th>
          <th>Issue Date</th>
        </tr>
        </thead>
        <tbody id="saintriBody">
        <?php foreach ($saintridistributions as $m): ?>
          <tr>
            <td><?php echo $m->member_name; ?></td>
            <td><?php echo $m->mobile; ?></td>
            <td><?php echo $m->district_name; ?></td>
            <td><?php echo date('d-m-Y', strtotime($m->issue_date)); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div> <!-- row2 end -->

</div> <!-- content end -->

<script>
  let groupDT;
  let saintriDT;

  $(document).ready(function () {
      groupDT = $('#groupTable').DataTable();
      saintriDT = $('#saintriTable').DataTable();
  });

  function formatDMY(dateStr) {
      if(!dateStr) return '';
      const d = new Date(dateStr);
      const day = ("0" + d.getDate()).slice(-2);
      const month = ("0" + (d.getMonth()+1)).slice(-2);
      const year = d.getFullYear();
      return `${day}-${month}-${year}`;
  }

  function applyFilter() {
      let from = $('#fromDate').val();
      let to = $('#toDate').val();

      if (!from || !to) {
          alert("Please select both From & To date");
          return;
      }

      $.ajax({
          url: "<?php echo base_url('common/filter_associate_data') ?>",
          type: "POST",
          data: {
              from_date: from,
              to_date: to,
              associate_id: "<?php echo $volunteerdetails->volntr_id ?>"
          },
          success: function (res) {
              let data = JSON.parse(res);

              // Convert dates to d-m-Y
              data.groups.forEach(g => g.group_start_date = formatDMY(g.group_start_date));
              data.saintri.forEach(m => m.issue_date = formatDMY(m.issue_date));

              // Update tables
              updateGroupTable(data.groups);
              updateSaintriTable(data.saintri);
          },
          error: function(xhr, status, err) {
              console.error("Filter Error:", err);
              alert("Error while applying filter!");
          }
      });
  }

  function updateGroupTable(groups) {
      groupDT.clear();
      if(groups.length === 0){
          groupDT.row.add(['-', '-', '-', '-']);
      } else {
          groups.forEach(g => {
              groupDT.row.add([
                  g.group_name || '-',
                  g.group_noof_member || '-',
                  g.group_senior_epno || '-',
                  g.group_start_date || '-'
              ]);
          });
      }
      groupDT.draw();
  }

  function updateSaintriTable(saintri) {
      saintriDT.clear();
      if(saintri.length === 0){
          saintriDT.row.add(['-', '-', '-', '-']);
      } else {
          saintri.forEach(m => {
              saintriDT.row.add([
                  m.member_name || '-',
                  m.mobile || '-',
                  m.district_name || '-',
                  m.issue_date || '-'
              ]);
          });
      }
      saintriDT.draw();
  }

  function clearFilter() {
      $('#fromDate').val('');
      $('#toDate').val('');
      applyFilter(); // reapply filter to reset tables
  }
</script>

</body>
</html>
