<?php
session_start();
$err = array();
require "../configuration/connect.php";
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password =  $_POST['password'];
    // if(!empty($email) && !empty($password)){
        if(!empty($email)){
            if(!empty($password)){
                $password =  md5($_POST['password']);
                $check_user = $conn->query("SELECT userid, username, email, password  FROM taskidodb  WHERE email = '$email'");
                $row = $check_user->fetch_assoc();
                if($email == $row['email']){
                    if($password == $row['password']){
                        session_unset();
                        $_SESSION['loggedin'] = $email;
                        $session_user = $row['userid'];
                        $session_time = time();

                        $check_session = $conn->query("SELECT userid FROM session WHERE userid = '$session_user'");
                        if($check_session->num_rows < 1){
                            $insert_session = $conn->query("INSERT INTO session (userid, lastsession)VALUES ('$session_user', '$session_time')");
                        }else{
                            $update_session = $conn->query("UPDATE session SET lastsession = '$session_time' WHERE userid='$session_user'");
                        }
                        header('Location: ../me?welcome='.$row['username']);
                    
                    }else{
                        $err['password not found'] = "Password don't match";
                    }
                }else{
                    $err['not found'] = "Email not registered";
                }
            }else{
                $err['emptypass'] = "Password can't be empty";
            }
        }else{
            $err['emptyemail'] = "please enter an email";
        }
    // }else{
    //     $err['emptyemailpass'] = "All fields can't be empty";
    // }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate</title>
    <link rel="stylesheet" href="../taskido/css/form-1.0.0.21.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>
<body>
    <div class="homebtn" style="padding:5px 20px;">
        <a href="../"><button> Home</button></a>
    </div>
    <div class="form-container box-shadow">
        <div class="errorDiv"> <?php foreach($err as $error){ echo "<p style='color:red;'>".$error;} ?> </div>
        <div class="form-title">
            <h1>TaskIdo Login</h1>
        </div>
        <form  method="post">
            <div class="form-group">
                <input type="text" placeholder="Email" name="email" id="signed">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" name="password" id="password">
                <i class="bi bi-eye-slash" id="togglepassword"></i>
            </div>   
            <div class="form-group">
                <button type="submit" name="login"> Login </button>
            </div>
        </form>
        <div class="prompt">
            <p>New here? <a href="sign">SignUp</a></p> 
            <p style='padding-top: 10px;'>Forgot Password? <a href='./resetpassword'>Reset</a></p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.querySelector(".errorDiv").innerHTML = '';
        }, 3000);
    </script>
    <script src="../taskido/javascript/passscript.js"> </script>
    <script src="../taskido/javascript/visitors.js"></script>
</body>
</html>