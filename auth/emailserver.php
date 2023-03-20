<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ("../PHPMailer/PHPMailer.php");
require ("../PHPMailer/SMTP.php");
require ("../PHPMailer/Exception.php");


function sendOTP($recipient, $code, $name){
    $mail = new PHPMailer(true);
    $body = "Body ";
    try{
       $mail -> isSMTP();
       $mail -> Host = "smtp.gmail.com";
       $mail -> SMTPAuth = true;
       $mail -> Username = "YOUR EMAIL";
       $mail -> Password = "YOUR PASSWORD";
       $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
       $mail -> Port = 465;
       $mail ->setFrom('YOUR EMAI', 'TaskIDO Developer');
       $mail ->addAddress($recipient);
       $mail ->addReplyTo('YOUR EMAI', 'name');
        $mail ->isHTML(true);
        $mail ->Subject = "TaskIDO OTP Verification Code";
        $mail ->Body = $body;
       $mail ->send();
        }catch(Exception $e){
            
        }
    }
function contact($recipient, $name){
    $mail = new PHPMailer(true);
    $body = "
    <html>
    <body>
    <div style='background:rgb(255, 255, 255); padding:20px;'> 
        <div style='background:#c8d8e49a;padding:20px;'>
            <div style='max-width:600px; margin:0 auto; box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 5px 0 rgb(0 0 0 / 12%) ; background:#c8d8e4 ; border-radius:5px; padding: 20px;'>
                <div style='text-align:center;'>
                    <h1 style='color:#5f6061bb;'>mailed by .taskIDo Inc</h1>
                </div>
                <div>
                   <h1 style='color:#1f1f1f; padding-top:30px'>Hey $name, </h1>
                   <p style='padding-bottom:20px;'>Thank you for contacting us, your message has been received . We will reach to you ASAP
                   </p>
                </div>
                <p>With Ragards</p>
                <p><strong style='font-size:16px;'>TaskIDO Team</strong></p>
                <div style='width: 100px;'>
                    <img style='width:100%;' src='http://localhost/toDoUI/imgs/undraw_project_team_lc5a.svg' alt='Don`t share'>
                </div>
            </div>
        </div>
        <div style='text-align:center;'><small style='font-size:14px;'>.taskiDo Inc ©  2021</small> <span>Developed by <a style='font-size:16px;' href='https://linkedin.com/in/johnwaithira'>Jon Waithira</a> </span><br> <a href='https://taskido.unaux.com'>Website</a>
         <div><a href='https://linkedin.com/in/johnwaithira'>LinkedIn</a> <a href='https://wa.link/0tz6gr'>WhatsApp</a></div>
        <small>
            <p>taskIDo is cloud based task manager that helps you keep track of your daily activities.<br>About Developer - John Waithira. Im an undergraduate at the university of Meru</p>
        </small>
        </div>
        <p style='padding-bottom:100vh;'></p>
    </div>
    </html>
    ";
    try{
       $mail -> isSMTP();
       $mail -> Host = "smtp.gmail.com";
       $mail -> SMTPAuth = true;
       $mail -> Username = "YOUR EMAIL";
       $mail -> Password = "YOUR PASSWORD";
       $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
       $mail -> Port = 465;
       $mail ->setFrom('YOUR EMAI', 'TaskIDO Developer');
       $mail ->addAddress($recipient);
       $mail ->addReplyTo('YOUR EMAI', 'name');
        $mail ->isHTML(true);
        $mail ->Subject = "Thanks For Contacting Us";
        $mail ->Body = $body;
       $mail ->send();
        }
        catch(Exception $e){}
}

function newsletter($recipient){
    $mail = new PHPMailer(true);
    $body = "
    <html>
    <body>
    <div style='background:rgb(255, 255, 255); padding:20px;'> 
        <div style='background:#c8d8e49a;padding:20px;'>
            <div style='max-width:600px; margin:0 auto; box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 5px 0 rgb(0 0 0 / 12%) ; background:#c8d8e4 ; border-radius:5px; padding: 20px;'>
                <div style='text-align:center;'>
                    <h1 style='color:#5f6061bb;'>mailed by .taskIDo Inc</h1>
                </div>
                <div>
                   <h1 style='color:#1f1f1f; padding-top:30px'>Hey there, </h1>
                   <p style='padding-bottom:20px;'>You have successfully subscribed to our newsletter . Stay posted.
                   </p>
                </div>
                <p>With Ragards</p>
                <p><strong style='font-size:16px;'>TaskIDO Team</strong></p>
                <div style='width: 100px;'>
                    <img style='width:100%;' src='http://localhost/toDoUI/imgs/undraw_project_team_lc5a.svg' alt='Don`t share'>
                </div>
            </div>
        </div>
        <div style='text-align:center;'><small style='font-size:14px;'>.taskiDo Inc ©  2021</small> <span>Developed by <a style='font-size:16px;' href='https://linkedin.com/in/johnwaithira'>Jon Waithira</a> </span><br> <a href='https://taskido.unaux.com'>Website</a>
         <div><a href='https://linkedin.com/in/johnwaithira'>LinkedIn</a> <a href='https://wa.link/0tz6gr'>WhatsApp</a></div>
        <small>
            <p>taskIDo is cloud based task manager that helps you keep track of your daily activities.<br>About Developer - John Waithira. Im an undergraduate at the university of Meru</p>
        </small>
        </div>
        <p style='padding-bottom:100vh;'></p>
    </div>
    </html>
    ";
    try{
       $mail -> isSMTP();
       $mail -> Host = "smtp.gmail.com";
       $mail -> SMTPAuth = true;
       $mail -> Username = "YOUR EMAIL";
       $mail -> Password = "YOUR PASSWORD";
       $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
       $mail -> Port = 465;
       $mail ->setFrom('YOUR EMAI', 'TaskIDO Developer');
       $mail ->addAddress($recipient);
       $mail ->addReplyTo('YOUR EMAI', 'name');
        $mail ->isHTML(true);
        $mail ->Subject = "Subscribed to Newsletter";
        $mail ->Body = $body;
       $mail ->send();
        }
        catch(Exception $e){}
}


function resetpass($recipient,$token, $name){
    $mail = new PHPMailer(true);
    $body = "

    <html>
    <body>
        <div style='background:rgb(255, 255, 255); padding:20px;'> 
            <div style='background:#c8d8e49a;padding:20px;'>
                <div style='max-width:600px; margin:0 auto; box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 5px 0 rgb(0 0 0 / 12%) ; background:#c8d8e4 ; border-radius:5px; padding: 20px;'>
                    <div style='text-align:center;'>
                    <h1 style='color:#5f6061bb;'>by .taskIDo</h1>
                </div>
                <div>
                   <h1 style='color:#1f1f1f; padding-top:30px'>Hi $name, </h1>
                   <p style='padding-bottom:20px;'>Looks like you would like to change your TaskiDo password. Please click the following button to do so. </p>
                   <p>Please disregard this e-mail if you did not request a password reset.</p>
                </div>
                <div style='padding-bottom:10vh;'>
                    <a href='http://localhost/final/auth/token?token=$token' style='background:grey; text-decoration:none; font-weight:800;
                    color:white; padding:10px 20px; border-radius:30px;'>Reset Password</a>
                </div>
                <p></p>
                <p><a href='http://localhost/final/auth/token?token=$token'>http://localhost/final/auth/token?token=$token</a></p>
                <p>With Ragards</p>
                <p><strong style='font-size:16px;'>TaskIDO Team</strong></p>
                <div style='width: 100px;'>
                    <img style='width:100%;' src='http://localhost/toDoUI/imgs/undraw_project_team_lc5a.svg' alt='Don`t share'>
                </div>
            </div>
        </div>
        <div style='text-align:center;'><small style='font-size:14px;'>.taskiDo Inc ©  2021</small> <span>Developed by <a style='font-size:16px;' href='https://linkedin.com/in/johnwaithira'>Jon Waithira</a> </span><br> <a href='https://taskido.unaux.com'>Website</a>
         <div><a href='https://linkedin.com/in/johnwaithira'>LinkedIn</a> <a href='https://wa.link/0tz6gr'>WhatsApp</a></div>
         <small>
            <p>taskIDo is cloud based task manager that helps you keep track of your daily activities.<br>About Developer - John Waithira. Im an undergraduate at the university of Meru</p>
        
        </small>
        </div>
        <p style='padding-bottom:100vh;'></p>
    </div>
    </html>
    
    ";
    try{
       $mail -> isSMTP();
       $mail -> Host = "smtp.gmail.com";
       $mail -> SMTPAuth = true;
       $mail -> Username = "YOUR EMAIL";
       $mail -> Password = "YOUR PASSWORD";
       $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
       $mail -> Port = 465;
       $mail ->setFrom('YOUR EMAI', 'TaskIDO Developer');
       $mail ->addAddress($recipient);
       $mail ->addReplyTo('YOUR EMAI', 'name');
        $mail ->isHTML(true);
        $mail ->Subject = "TaskiDO Password Reset";
        $mail ->Body = $body;
       $mail ->send();
    //    echo " Sent";
        }catch(Exception $e){}
}

    

        function resetsucess($recipient, $name, $new_pass){
            $mail = new PHPMailer(true);
            $body = "
            <html>
            <body>
                <div style='background:rgb(255, 255, 255); padding:20px;'> 
                    <div style='background:#c8d8e49a;padding:20px;'>
                        <div style='max-width:600px; margin:0 auto; box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 5px 0 rgb(0 0 0 / 12%) ; background:#c8d8e4 ; border-radius:5px; padding: 20px;'>
                            <div style='text-align:center;'>
                            <h1 style='color:#5f6061bb;'>by .taskIDo Inc</h1>
                        </div>
                        <div>
                           <h1 style='color:#1f1f1f; padding-top:30px'>Hi $name, </h1>
                           <p style='padding-bottom:20px;'>The password for your TaskIDO account $recipient was recently changed. </p>
                        </div>
                    
                        <p></p>
                        <p>With Ragards</p>
                        <p><strong style='font-size:16px;'>TaskIDO Team</strong></p>
                        <div style='width: 100px;'>
                            <img style='width:100%;' src='http://taskido.unaux.com/imgs/undraw_project_team_lc5a.svg' alt='Don`t share'>
                        </div>
                    </div>
                </div>
                <div style='text-align:center;'><small style='font-size:14px;'>.taskiDo Inc ©  2021</small> <span>Developed by <a style='font-size:16px;' href='https://linkedin.com/in/johnwaithira'>Jon Waithira</a> </span><br> <a href='https://taskido.unaux.com'>Website</a>
                 <div><a href='https://linkedin.com/in/johnwaithira'>LinkedIn</a> <a href='https://wa.link/0tz6gr'>WhatsApp</a></div>
                 <small>
                    <p>taskIDo is cloud based task manager that helps you keep track of your daily activities.<br>About Developer - John Waithira. Im an undergraduate at the university of Meru</p>
                
                </small>
                </div>
                <p style='padding-bottom:100vh;'></p>
            </div>
        </html>
            
            ";
            try{
               $mail -> isSMTP();
               $mail -> Host = "smtp.gmail.com";
               $mail -> SMTPAuth = true;
               $mail -> Username = "YOUR EMAIL";
               $mail -> Password = "YOUR PASSWORD";
               $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
               $mail -> Port = 465;
               $mail ->setFrom('YOUR EMAI', 'TaskIDO Developer');
               $mail ->addAddress($recipient);
               $mail ->addReplyTo('YOUR EMAI', 'name');
                $mail ->isHTML(true);
                $mail ->Subject = "TaskIDO Password Changed";
                $mail ->Body = $body;
               $mail ->send();
            //    echo " Sent";
                }catch(Exception $e){}}


