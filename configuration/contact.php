<?php
require "../configuration/connect.php";
require "../auth/emailserver.php";
$contactname = $_POST['contactname'];
$contactemail = $_POST['contactemail'];
$contactmsg = $_POST['contactmessage'];
   if(!empty($contactname) && !empty($contactemail) && !empty($contactmsg)){
        $querycontact = $conn->query("INSERT INTO contact(name, email, msg) values('$contactname', '$contactemail', '$contactmsg')");
        
        if(!$querycontact){
            echo "Message not sent .. try again";
        }else{
            echo "Message sent <i style='color:green;padding-left:15px;' class='c-green fa fa-check-circle'></i>";
            contact($contactemail, $contactname);
            // echo "Message sent <i style='color:green;padding-left:15px;' class='c-green fa fa-check-circle'></i>";
        }
       
   }else{
       echo "<p style='color:#ff0000;'>Can't send empty fields";
   }
?>
