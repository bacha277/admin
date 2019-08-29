<script>
  function postAsn(asn) {
    xhr = new XMLHttpRequest();
    xhr.onload = function() {
      if (xhr.responseText == "1") {
        location.reload();
      } else {
        alert("Couldn't parse. Please try again later.");
      }
    };
    xhr.open("POST", "isp/parse.php?r=" + Math.random(), true);
    try {
      var fd = new FormData();
      fd.append("asn", asn);
      xhr.send(fd);
    } catch (ex) {

    }
  }
</script>

<?php
if (isset($_REQUEST['asn'])) {
  $asn = $_REQUEST['asn'];
  //sql
  $sql = "select * from isp where asn = '$asn'";
  //query
  $rows = $conn->query($sql);
  //retrieve data
  echo '
        <div class="box-header">
          <h3 class="box-title">ISP details</h3>
        </div>

        <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <th>ASN</th>
            <th>Name</th>
            <th>Organisation</th>
            <th>Registry</th>
            <th>Registered Country</th>
            <th>Registration Last Change</th>
            <th>Total Ipv4 Addresses</th>
            <th>Total Ipv4 Prefixes</th>
            <th>Rank</th>
            <th>Rank Text</th>
            <th>Action</th>
          </thead>
      <tbody>';
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
      . "<td>$r[8]</td>"
      . "<td>$r[9]</td>";
      if ($r[10] != 1) {
        echo "<td><a href='javascript:postAsn(\"$r[0]\")'>Parse</a></td>";
      } else {
        echo "<td></td>";
      }
      echo  '</tr>';
  }
  echo '</tbody>
        </table>
      </div>
    </div>';
}
?>
