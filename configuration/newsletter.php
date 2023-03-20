<?php
require "./connect.php";
require "../auth/emailserver.php";
    $email = $_POST['newsletteremail'];
    if(!empty($email)){
        $postnewsletter = $conn->query("SELECT email FROM newsletter WHERE email = '$email'");
        if($postnewsletter->num_rows > 0){
            echo "You are already to subscribed";
        }else{
            $current_date = date("Y-m-d");
            $postnewnewsletter = $conn->query("INSERT INTO newsletter (email, subdate) values('$email','$current_date')");
            if($postnewnewsletter){
                newsletter($email);
                echo "<p style='color:green;'>Successfully subscribed";
            }else{
                echo "<p style='color:#8a0606'>Failed to subscribe to newsletter";

            }
        }
    }else{
        echo "<p style='color:#8a0606;'>Please enter  email address";
    }

?>
