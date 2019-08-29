<?php
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  //sql
  $sql = "select * from useragent where id = $id";
  //query
  $rows = $conn->query($sql);
  echo '
    <div class="box-header">
      <h3 class="box-title">User agent details</h3>
    </div>

    <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
          <thead>
            <th>Id</th>
            <th>Agent Type</th>
            <th>Agent Name</th>
            <th>Agent Version</th>
            <th>OS Type</th>
            <th>OS Name</th>
            <th>OS Version Name</th>
            <th>OS Version Number</th>
          </thead>
      <tbody>';
  //retrieve data
  foreach ($rows as $r) {
      echo "<tr>"
      . "<td>$r[0]</td>"
      . "<td>$r[1]</td>"
      . "<td>$r[2]</td>"
      . "<td>$r[3]</td>"
      . "<td>$r[4]</td>"
      . "<td>$r[5]</td>"
      . "<td>$r[6]</td>"
      . "<td>$r[7]</td>"
      . "</tr>";
  }
  echo '</tbody>
        </table>
      </div>
  </div>';
}
?>
