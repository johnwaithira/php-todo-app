<?php
require "./connect.php";
    if(!empty($_POST['landingemail'])){
        $tryemail = $_POST['landingemail'];
            $checkemail = $conn->query("SELECT email FROM taskidodb WHERE email = '$tryemail'");
                if($checkemail->num_rows > 0){
                    echo "Sorry, the email is already taken.";
                }else{
                    echo "emailok";
                }
    }else{
        echo "Please enter an email to continue";
    }
?>
