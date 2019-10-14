<?php
require("api/functions.php");
$con = getConnection();
$search = $_POST["search"];
$sql = "SELECT token FROM active WHERE token LIKE '%$search%' AND aktiviert='0' LIMIT 1";
$res = $con->query($sql) OR die($con->connect_errno);

foreach($res as $row){
  if($row['token'] == $search){
    echo "true";
  }
}
?>
