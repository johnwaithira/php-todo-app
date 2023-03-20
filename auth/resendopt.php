<?php
require "../configuration/connect.php";
require "./emailserver.php";
   $email =  $_POST['resendemail'];
   $check_email = $conn->query("SELECT username, email FROM unverified WHERE email = '$email'");
   if($check_email->num_rows < 1){
       echo "<p style='color:red;'>Sorry, Email not found";
   }else{
       $row = $check_email->fetch_assoc(); 
       $username = $row['username'];
       $new_otp = rand(100000, 999999);
       $update_otp = $conn->query("UPDATE unverified SET otp = '$new_otp' WHERE email = '$email'");  
       if($update_otp){

           sendOTP($email, $new_otp, $username);
           echo "<p style='color:green;'>Otp sent to your mail";
       }else{
           echo "<p style='color:red;'>Otp not sent. Try again";
       }
   }

?>
