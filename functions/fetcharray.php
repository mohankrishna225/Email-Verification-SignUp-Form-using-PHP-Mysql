<?php 

$sql = "SELECT * FROM users";
$result =query($sql);

confirm($result);

$row = fetch_array($result);

echo $row['username'];


?>