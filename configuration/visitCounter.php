<?php
require "./connect.php";
$insert = $conn->query("INSERT INTO visits(visited) value('visit')");