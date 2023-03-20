<?php
require "../configuration/connect.php";
require "./emailserver.php";
$err = array();
if(!isset($_GET['token'])){
    header('Location: ../?forbbiden');
}
if($_GET['token'] == ''){
    header('Location: ../?forbbiden');
}else{
    $token = $_GET['token'];
    $check_token = $conn->query("SELECT emailid, token FROM resetpassword WHERE token = '$token'");
        if($check_token->num_rows < 1){
            header('Location: ../?forbbiden....invalid token');
        }else{
            $row  = $check_token->fetch_assoc();
            $email = $row['emailid'];
            if(isset($_POST['setpassword'])){
                if(empty($_POST['newpassword'])){
                    $err['empty'] = "Password cannot be empty";
                }else{
                    $newpassword_before_hash = $_POST['newpassword'];
                    $newpassword = md5($_POST['newpassword']);
                    $checkpreviouspassword = $conn->query("SELECT username, email , password FROM taskidodb WHERE email='$email'");
                    $qry = $checkpreviouspassword->fetch_assoc();
                        if($qry['password'] == $newpassword){
                            $err['nochanges'] = "<p style='color:red'>Please set another password different from the previuos one";
                        }else{
                            $username = $qry['username'];
                            $update = $conn->query("UPDATE taskidodb SET password = '$newpassword' WHERE email = '$email'");
                            if($update){
                                resetsucess($email, $username, $newpassword_before_hash);
                                $deleterecord = $conn->query("DELETE FROM resetpassword  WHERE emailid = '$email'");
                                if($deleterecord){
                                    $err['update'] = "<p style='color:green'>Successfully set";
                                    ?>
                                    <script>
                                        setTimeout(() => {
                                            window.location.assign('./login');
                                        }, 3000);
                                    </script>
                                    <?php
                                }
                            }
                        }
                }
            }
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link rel="stylesheet" href="../taskido/css/form-1.0.0.21.min.css">
    <link rel="stylesheet" href="../taskido/css/landing-1.0.0.21.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>
<body>
    
                <div class="landing_navigation w-100" id="navigation">
                    <div class="landing_inner_navigation_wrapper">
                        <div class="landing_navigation_links_logo" style="color:#000;">
                            <h1  style="color:#000;">TaskiDo </h1>
                        </div>
                        <input type="checkbox" name="check" id="check">
                        <div class="landing_auth_links"  style="color:#000;">
                            <li><a  style="color:#000;" href="../" id="home" onclick="closeMenu()" >Home</a></li>
                            <li><a  style="color:#000;" href="./sign"  onclick="closeMenu()" class="auth p-10-20  signup">SignUp</a></li>
                        </div>
                        <label for="check">
                            <div class="menu"></div>
                            <div class="menu mid"></div>
                            <div class="menu"></div>
                        </label>
                    </div>
                </div>
    <div class="form-container box-shadow">
        <div class="errorDiv"> <?php foreach($err as $error){ echo "<p style='color:red;'>".$error;} ?> </div>
        <div class="form-title">
            <h1>Enter your new password below</h1>
        </div>
        <form  method="post">
            <div class="form-group">
                <input type="password" placeholder="New Password" name="newpassword" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}" title="Please ensure that your password contains atleast an uppercase, lowercase  a number and should be of 6 characters and above" id="password">
                <i class="bi bi-eye-slash" id="togglepassword"></i>
            </div>   
            <div class="form-group">
                <button type="submit" name="setpassword"> Change Now </button>
            </div>
        </form>
        <div class="prompt">
            <p><a href="login">Login</a></p> 
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.querySelector(".errorDiv").style.display = "none";
        }, 3000);
    </script>
    <script src="../taskido/javascript/passscript.js"> </script>
    <script src="../taskido/javascript/visitors.js"></script>

</body>
</html>