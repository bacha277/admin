<?php

$db_type="mysql"; //Type of db: "mysql", "sqlite" or "postgresql"
$stats_password="1234567"; //password to login to stats.php. Change this!!!
$enable_id_obfuscation=false; //if set to true, test IDs will be obfuscated to prevent users from guessing URLs of other tests

// Sqlite3 settings
$Sqlite_db_file = "../../speedtest_telemetry.sql";

// Mysql settings
$MySql_username="root";
$MySql_password="";
$MySql_hostname="localhost";
$MySql_databasename="speedtest_design";

// Postgresql settings
$PostgreSql_username="USERNAME";
$PostgreSql_password="PASSWORD";
$PostgreSql_hostname="DB_HOSTNAME";
$PostgreSql_databasename="DB_NAME";


//IMPORTANT: DO NOT ADD ANYTHING BELOW THIS PHP CLOSING TAG, NOT EVEN EMPTY LINES!
?>
