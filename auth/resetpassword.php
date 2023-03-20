<?php
$err = array();
require "../configuration/connect.php";
require "./emailserver.php";

if(isset($_POST['resetPass'])){
    if(!empty($_POST['resetEmail'])){
        $email = $_POST['resetEmail'];
            $checkmail = $conn->query("SELECT username, email FROM taskidodb WHERE email = '$email'");
                
                if($checkmail->num_rows < 1){
                    $err['emptymail'] = "<p style='color:red;'>Email not registered";
                }else{
                    $row = $checkmail->fetch_assoc();
                    $username = $row['username'];
                    $token = bin2hex(random_bytes(20));
                    // $currenttime = time;
                    $insertdatatoresettable = $conn->query("INSERT INTO resetpassword(emailid, token) VALUES('$email', '$token')");
                    if($insertdatatoresettable){
                        resetpass($email,$token, $username);
                        $err['emailsent'] = "<p style='color:green'>Check reset link from your email";
                    }else{
                        $err['Failed'] = "Failed" . $conn->error;
                        
                    }
                }
    }else{
        $err['emptymail'] = "<p style='color:red;'>Please insert an email";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../taskido/css/landing-1.0.0.21.min.css">
</head>
<body>
        <!-- navigation -->
        <div class="landing_navigation w-100" id="navigation">
            <div class="landing_inner_navigation_wrapper">
                <div class="landing_navigation_links_logo">
                    <h1>TaskiDo </h1>
                </div>
                <input type="checkbox" name="check" id="check">
                <div class="landing_auth_links">
                    <li><a href="../" id="home" onclick="closeMenu()" >Home</a></li>
                    <li><a href="./login"  onclick="closeMenu()" class="auth  p-10-20 login">Login</a></li>
                    <li><a href="./sign"  onclick="closeMenu()" class="auth p-10-20  signup">SignUp</a></li>
                </div>
                <label for="check">
                    <div class="menu"></div>
                    <div class="menu mid"></div>
                    <div class="menu"></div>
                </label>
            </div>
        </div>
        <div class="landing_page_context w-50 w-s-40 p-t-100">
            <div class="landing_page_context_inner_wrapper p-t-20">
                <div class="otpform w-65 box-shadow m-0-auto w-m-90">
                    <div class="otp-content box-shadow  p-10-20" style="display: flex;flex-direction: column;">
                        <div class="error_div">
                            <?php 
                            foreach($err as $error){
                                echo $error;
                            }
                            ?>
                        </div>
                        <p class="p-30-0">Please enter the Email you want to reset for</p>
                        <form action=""  style="display: flex;flex-direction: column;" method="post">
                            <input type="email" name="resetEmail" placeholder=" reset password" id="resetemail">
                            <button type="submit" name="resetPass">Reset</button>
                        </form>
                        <!--login -->
                        <div class="login_btn">
                            <a href="./login"><button>Login</button></a>
                        </div>
                    </div>
                    <style>
                        .letter-spacing{
                            letter-spacing:30px;
                        }
                    </style>
                    <script>
                        const resendform = document.querySelector("form"),
                        error_div = document.querySelector(".error_div");
                        setTimeout(() => {
                            error_div.innerHTML = '';
                        }, 3000);
                    </script>
            </div>
        </div>

        <script>
            // setTimeout(() => {
            //     document.querySelector(".prompt-check").style.display = "none";
            // }, 3000);
            let home = document.getElementById("home");
                home.onclick = (e) =>{
                    e.preventDefault();
                    window.location.assign("../");
              }
        </script>
    <?php if(isset($_GET['reset']) && $_GET['reset'] != ""){?>
        <script> document.querySelector("#resetmail").value= '<?php echo $_GET['reset'];?>';
    </script>
    <?php }?>
    <script src="../taskido/javascript/visitors.js"></script>

</body>
</html>
