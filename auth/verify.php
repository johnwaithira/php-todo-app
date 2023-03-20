<?php
require "../configuration/connect.php";
session_start();
// if(!isset($_SESSION['unverified']))
// {
//     header('Location: ./sign');
// }
$err = array();
if(isset($_POST['verifyotp'])){
    $otpcode = $_POST['otpcode'];
    if(!empty($otpcode)){
        $email = $_GET['recent'];
         $check_otp = $conn->query("SELECT userid, username, email, password, profile, otp FROM unverified WHERE email = '$email' and otp = '$otpcode' limit 1");
            if($check_otp->num_rows < 1){
                $err['mismatch'] = "<p style='color:red'>Sorry, either the code or email is invalid code";
            }else{
                $err['verified'] = "<p style='color:green'>Verified";
                $row = $check_otp->fetch_assoc();
                $userid = $row['userid'];
                $username = $row['username'];
                $email = $row['email'];
                $password = $row['password'];
                $profile = $row['profile'];
                $move_to_user = $conn->query("INSERT INTO taskidodb (userid, username, email, password) VALUES ('$userid','$username', '$email', '$password')");
                $set_user_profile = $conn->query("INSERT INTO profile (userid, profiledata) VALUES ('$userid', '$profile')");
                if($move_to_user){
                   $delete_data = $conn->query("DELETE FROM unverified WHERE email = '$email'");
                   unset($_SESSION['unverified']);
                //    session_destroy();
                   ?>
                   <script>
                      setTimeout(() => {
                        window.location.assign("./login");
                      }, 2000);
                   </script>
                   <?php
                }
            }
    }else{
         $err['blank'] = "<p style='color:red'>Please enter 6 digit code";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify account</title>
    <link rel="stylesheet" href="../taskido/css/form-1.0.0.21.min.css">
    <link rel="stylesheet" href="../taskido/css/landing-1.0.0.21.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>
<body>
    <!-- Navigation bar -->
    <div class="landing_navigation w-100" id="navigation">
        <div class="landing_inner_navigation_wrapper">
            <div class="landing_navigation_links_logo" style="color:#000;">
                <!-- Logo -->
                <h1  style="color:#000;">TaskiDo </h1>
                <!-- Logo END-->
            </div>
            <input type="checkbox" name="check" id="check">
            <div class="landing_auth_links"  style="color:#000;">
                <!-- Navigation links -->
                <li><a  style="color:#000;" href="../" id="home" onclick="closeMenu()" >Home</a></li>
                <li><a  style="color:#000;" href="./sign"  onclick="closeMenu()" class="auth p-10-20  signup">SignUp</a></li>
                <!-- Navigation links END-->
            </div>
            <!-- checkbox Label -->
            <label for="check">
                <!-- Menu bars -->
                <div class="menu"></div>
                <div class="menu mid"></div>
                <div class="menu"></div>
                <!-- Menu bars END-->
            </label>
            <!-- checkbox Label END-->
        </div>
    </div>
    <!-- Navigation bar END-->
    <!-- User verification form -->
    <div class="form-container box-shadow">
        <!-- Request FeedBack Div -->
        <div class="error-div"> 
            <?php 
                foreach($err as $error){
                    echo "<p style='color:red'>" . $error;
                    }
            ?> 
        </div>
        <!-- Request FeedBack Div END-->
        <!-- verification Text prompt -->
        <p class="p-30-0" style='color:black;'>Please check the OTP code sent to <br> <span > <a style='color:black;' href="https://mail.google.com">Mail</a></span><br>
            <span class="promptCheck">
                <br>
                    <small>
                        <i style='color:black;'>Cant't find the email? navigate to spam folder</i>
                    </small>
            </span>
        </p>
        <!-- verification Text prompt END-->
        <!--Verification Code Form Div -->
        <form  method="post">
            <div class="form-group">
                <input type="text" name="otpcode" placeholder="  6 digit code" id="otpinput" required maxlength="6">
            </div>   
            <div class="form-group">
                <button type="submit" name="verifyotp">Verify</button>
            </div>
        </form>
        <!--Verification Code Form Div END -->
        <!-- Hidden Resend Email Div -->
        <form method="post" id="resendform">
            <input type="email" name="resendemail" hidden id="resendmail">
            <div class="form-group">
                <button type="submit" name="resend" id="resend">Resend</button>
            </div>
        </form>
        <!-- Hidden Resend Email Div END-->

    </div>
    <!-- User verification form END-->
     <style>
        .letter-spacing{
            letter-spacing:30px;
        }
    </style>
    
    <script>
        // error_div timeout
        setTimeout(() => {
            document.querySelector(".promptCheck").style.display = "none";
        }, 3000);
        let home = document.getElementById("home");
            home.onclick = (e) =>{
                e.preventDefault();
                window.location.assign("../");
            }
            
        const myForm = document.querySelector("#otpinput");
        myForm.onkeyup = () =>{
            if(myForm.value.length > 1){
                myForm.classList.add("letter-spacing");
            }else{
                myForm.classList.remove("letter-spacing");
            }       
        }
        const errorDiv= document.querySelector(".error-div");
        const resendForm = document.getElementById("resendform"),
        resendEmail = document.querySelector("input").value,
        resendBtn = resendForm.querySelector("button");
        // prevent page reload 
        resendForm.onsubmit = (e)=>{
            e.preventDefault();
        }
        // add Event listener
        resendBtn.onclick= ()=>{
          let xhr = new XMLHttpRequest();
            xhr.open("POST", "./resendopt.php");
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                            // display HTTP feedback
                            errorDiv.innerHTML = data;
                                setTimeout(() => {
                                    errorDiv.innerHTML = '';
                                }, 3000);    
                    }
                }
            }
            // send HTTP request
        let formData = new FormData(resendForm);
        xhr.send(formData);
        }
        setTimeout(() => {
            errorDiv.innerHTML = '';
        }, 3000);
    </script>
    <?php if(isset($_GET['recent']) && $_GET['recent'] != ""){?>
        <script> document.querySelector("#resendmail").value= '<?php echo $_GET['recent'];?>';
    </script>
    <?php }?>

    <?php if(isset($_GET['otpcode']) && $_GET['otpcode'] != ""){?>
        <script> document.querySelector("#otpinput").value= '<?php echo $_GET['otpcode'];?>';</script>
    <?php }?>
    <script src="../taskido/javascript/passscript.js"> </script>
    <script src="../taskido/javascript/visitors.js"></script>

</body>
</html>
