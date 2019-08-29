<?php
include_once('../telemetry_settings.php');
$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1");

function updateIspInfo($conn, $asn, $name, $organisation, $registry, $registeredCountry, $registrationLastChange, $totalIpv4Addresses, $totalIpv4Prefixes, $rank, $rankText, $parsed) {
  $stmt = $conn->prepare("update isp set name=?,organisation=?,registry=?,registeredCountry=?,registrationLastChange=?,totalIpv4Addresses=?,totalIpv4Prefixes=?,rank=?,rankText=?,isParsed=? where asn=?") or die("2");
  $stmt->bind_param("sssssssssis",$name, $organisation, $registry, $registeredCountry, $registrationLastChange, $totalIpv4Addresses, $totalIpv4Prefixes, $rank, $rankText, $parsed, $asn) or die("3");
  $stmt->execute() or die("42");
  $stmt->close() or die("5");
}

$asn = $_POST["asn"];

$ctx = stream_context_create(array('http'=>
  array(
    'timeout' => 3,
  )
));

$ispJson = @file_get_contents("https://api.bigdatacloud.net/data/asn-info-full?asn=" . $asn . "&key=3a63260339d44f6597d0ee8a0c5efeac", false, $ctx);

// get isp info
if ($ispJson===false) {
  echo '0';
} else {
  $ispDetails = json_decode($ispJson, true);
  $ispName = $ispDetails["name"];
  $ispOrganisation = $ispDetails["organisation"];
  $ispRegistry = $ispDetails["registry"];
  $ispRegisteredCountry = $ispDetails["registeredCountryName"];
  $ispRegistrationLastChange = $ispDetails["registrationLastChange"];
  $ispTotalIpv4Addresses = $ispDetails["totalIpv4Addresses"];
  $ispTotalIpv4Prefixes = $ispDetails["totalIpv4Prefixes"];
  $ispRank = $ispDetails["rank"];
  $ispRankText = $ispDetails["rankText"];
  $ispParsed = 1;
  updateIspInfo($conn, $asn, $ispName, $ispOrganisation, $ispRegistry, $ispRegisteredCountry, $ispRegistrationLastChange, $ispTotalIpv4Addresses, $ispTotalIpv4Prefixes, $ispRank, $ispRankText, $ispParsed);
  echo '1';
}
?>
