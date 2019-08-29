<?php
include_once('../telemetry_settings.php');
$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1");

function getUaId($conn, $aType, $aName, $aVersion, $oType, $oName, $oVName, $oVNumber) {
  $uaId = 0;
  $sql = "select * from useragent where agentType = '$aType'
          and agentName = '$aName'
          and agentVersion = '$aVersion'
          and osType = '$oType'
          and osName = '$oName'
          and osVersionName = '$oVName'
          and osVersionNumber = '$oVNumber'
          ";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return $result->fetch_assoc()["id"];
  }
  return $uaId;
}

function insertUaInfo($conn, $aType, $aName, $aVersion, $oType, $oName, $oVName, $oVNumber) {
  $stmt = $conn->prepare("insert into useragent (agentType,agentName,agentVersion,osType,osName,osVersionName,osVersionNumber) VALUES (?,?,?,?,?,?,?)") or die("2");
  $stmt->bind_param("sssssss",$aType,$aName,$aVersion,$oType,$oName,$oVName,$oVNumber) or die("3");
  $stmt->execute() or die("41");
  $insertedId = $stmt->insert_id;
  $stmt->close() or die("5");
  return $insertedId;
}

function updateUaString($conn, $id) {
  $stmt = $conn->prepare("update result set uaString = '' where id = ?") or die("2");
  $stmt->bind_param("i", $id) or die("3");
  $stmt->execute() or die("41");
  $stmt->close() or die("5");
}

// $ua = $_GET["ua"];
// $resultId = $_GET["id"];

$ua = $_POST["uaString"];
$resultId = $_POST["id"];

$ctx = stream_context_create(array('http'=>
  array(
    'timeout' => 3,
  )
));

$uaJson = @file_get_contents("http://www.useragentstring.com/?uas=". rawurlencode($ua) . "&getJSON=all", false, $ctx);

if ($uaJson===false) {
  echo '0';
} else {
  $uaDetails = json_decode($uaJson, true);
  $agentType = $uaDetails["agent_type"];
  $agentName = $uaDetails["agent_name"];
  $agentVersion = $uaDetails["agent_version"];
  $osType = $uaDetails["os_type"];
  $osName = $uaDetails["os_name"];
  $osVersionName = $uaDetails["os_versionName"];
  $osVersionNumber = $uaDetails["os_versionNumber"];
  $uaId = getUaId($conn, $agentType, $agentName, $agentVersion, $osType, $osName, $osVersionName, $osVersionNumber);
  if ($uaId == 0) {
    $uaId = insertUaInfo($conn, $agentType, $agentName, $agentVersion, $osType, $osName, $osVersionName, $osVersionNumber);
  }
  // update result table
  $stmt = $conn->prepare("update result set ua = ? where id = ?") or die("2");
  $stmt->bind_param("ii",$uaId, $resultId) or die("3");
  $stmt->execute() or die("41");
  $stmt->close() or die("5");
  // update result uaString
  updateUaString($conn, $resultId);

  echo '1';
}
?>
