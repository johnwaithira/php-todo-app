<?php
$err = array();
require "../configuration/connect.php";
require "./emailserver.php";
if(isset($_POST['createAcc'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $profile = $_FILES['profile'];
    $confirm_password = $_POST['cpassword'];
    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)){
        $checkemail = $conn->query("SELECT email FROM taskidodb WHERE email = '$email' limit 1");
        if($checkemail->num_rows > 0){
            $err['emailtaken'] = "Sorry, the email is already taken.";
        }else{
            if($password != $confirm_password){
                $err['passwordmismatch'] = "Please confirm password";
            }else{
                if(!empty($_FILES['profile']['name'])){
                    $profile_folder = "../userprofile/";
                    $file = $profile_folder . strtotime(date("Y-m-d H:i:s")) . "_my_profile_" . basename($_FILES['profile']['name']);
                    if(move_uploaded_file($_FILES['profile']['tmp_name'], $file)){
                        $profile_path = basename($file);
                    }else{
                        $profile_path = "defaultprofile.png";
                    }
                }else{
                    $profile_path = "defaultprofile.png";
                }
                $password = md5($password);
                $otp = rand(100000, 999999);
                $userid = strtolower(bin2hex(random_bytes(3)));
                // $insertdata = $conn->query("INSERT INTO taskidodb (username, email, password, profile) VALUES ('$username', '$email', '$password', '$profile_path')");
                $insertdata = $conn->query("INSERT INTO unverified (userid, username, email, password, profile, otp) VALUES ('$userid','$username', '$email', '$password', '$profile_path', '$otp')");
                
                if($insertdata){
                    $err['created'] = "<p style='color:green;'>Account created ";
                    session_start();
                    $_SESSION['unverified'] = $email;
                    echo sendOTP($email, $otp, $username);
                    ?>
                        <script>
                            setTimeout(() => {
                                window.location.assign("./verify?recent=<?php echo $email;?>")
                            }, 3100);
                        </script>
                    <?php 
                }else{
                    $err['failedtocreate'] = "<p style='color:red;'>Failed " . $conn->error;
                }
            }
        }
    }else{
        $err['emptyfield'] = "<p style='color:red;'>All fields are required ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.taskIDO SignUp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../taskido/css/form-1.0.0.21.min.css">
</head>
<body>
    <div class="homebtn" style="padding:5px 20px;"><a href="../"><button> Home</button></a></div>
    <div class="form-container box-shadow" >
        <div class="form-title">
            <h1>TaskIdo SignUp</h1>
        </div>
        <form  method="post" enctype="multipart/form-data">
            <div class="error-div"> <?php foreach($err as $error){ echo $error;} ?> </div>
            <div class="form-group"><input type="text" placeholder="Username" name="username" id="username"></div>
            <div class="form-group"><input type="email" placeholder="Email" name="email" id="try"></div>
            <div class="form-group"><input type="password"  placeholder="Password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}" title="Please ensure that your password contains atleast an uppercase, lowercase a number and should be of 6 characters and above" name="password" id=""></div>
            <div class="form-group"><input type="password" placeholder="Confirm Password" name="cpassword" id="password"> <i class="bi bi-eye-slash" id="togglepassword"></i></div>
            <div class="form-group-one"><input type="file" name="profile"></div>
            <div class="form-group"><button type="submit" name="createAcc"> Create </button></div>
        </form>
        <script>
            const form = document.querySelector("form"), 
            alertbox = form.querySelector(".error-div");
                setTimeout(() => {
                    alertbox.innerHTML = '';
                }, 3000);
        </script> 
        <div class="prompt">
            <p>Already have an Account? <a href="login">Login</a></p>
            <p style='padding-top: 10px;'>Forgot Password? <a href='resetpassword'>Reset</a></p>
        </div>
    </div>
   <?php if(isset($_GET['create']) && $_GET['create'] != ""){?>
        <script> document.querySelector("#try").value= '<?php echo $_GET['create'];?>';</script>
    <?php }?>
    <script src="../taskido/javascript/visitors.js"></script>
    <script src="../taskido/javascript/passscript.js"> </script>
</body>
</html>