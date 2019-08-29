<script>
  function postUaString(id, uaString) {
    xhr = new XMLHttpRequest();
    xhr.onload = function() {
      if (xhr.responseText == "1") {
        location.reload();
      } else {
        alert("Couldn't parse. Please try again later.");
      }
    };
    xhr.open("POST", "ua/parse.php?r=" + Math.random(), true);
    try {
      var fd = new FormData();
      fd.append("id", id);
      fd.append("uaString", uaString);
      xhr.send(fd);
    } catch (ex) {

    }
  }
</script>
<?php
//sql
$sql = "select id, ip, isp, dl, ul, ping, jitter, ua, timestamp, uaString from result";
//query
$rows = $conn->query($sql);
//retrieve data
echo '<div class="box-header">
        <h3 class="box-title">Speedtest result table</h3>
      </div>

    <div class="box-body">

    <table id="example1" class="table table-bordered table-striped">
        <thead>
          <th>Id</th>
          <th>IP</th>
          <th>ISP</th>
          <th>Download</th>
          <th>Upload</th>
          <th>Ping</th>
          <th>Jitter</th>
          <th>User agent</th>
          <th>Timestamp</th>
          <th>UA String</th>
          <th>Action</th>
        </thead>
    <tbody>';
    foreach ($rows as $r) {
        echo "<tr>"
        . "<td>$r[0]</td>"
        . "<td>$r[1]</td>"
        . "<td><a href='index.php?page=isp&asn=$r[2]'>$r[2]</a></td>"
        . "<td>$r[3]</td>"
        . "<td>$r[4]</td>"
        . "<td>$r[5]</td>"
        . "<td>$r[6]</td>"
        . "<td><a href='index.php?page=ua&id=$r[7]'>$r[7]</a></td>"
        . "<td>$r[8]</td>"
        . "<td>$r[9]</td>";
        if ($r[9]!="") {
          // echo "<td><a href='ua/parse.php?ua=$r[9]&id=$r[0]'>Parse UA</a></td>"
          echo "<td><a href='javascript:postUaString($r[0],\"$r[9]\")'>Parse UA</a></td>"
          . "</tr>";
        } else {
          echo "<td></td>"
          . "</tr>";
        }
    }
    echo '</tbody>
            <tfoot>
              <tr>
                <th>Id</th>
                <th>IP</th>
                <th>ISP</th>
                <th>Download</th>
                <th>Upload</th>
                <th>Ping</th>
                <th>Jitter</th>
                <th>User agent</th>
                <th>Timestamp</th>
                <th>UA String</th>
                <th>Action</th>
              </tr>
            </tfoot>
    </table>
    </div>
  </div>';
?>
