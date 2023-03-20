<?php
$conn = new mysqli("localhost", "root", "", "final");
if(!$conn){
    echo "Failed to connect to the database";
}
