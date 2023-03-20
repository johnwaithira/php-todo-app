<?php
require "./session.php";
    $err = array();
    checkLoggedIn();
    require "./configuration/connect.php";
    $email = $_SESSION['loggedin'];
    $check_user = $conn->query("SELECT userid FROM taskidodb  WHERE email = '$email'");
    $id = $check_user->fetch_assoc();
    $userid = $id['userid'];
    $selectcategory = $conn->query("SELECT categoryid, categoryname  FROM taskcategory WHERE user='$userid'");
if(isset($_POST['addtask'])){
    if(!empty($_POST['tasktitle']) && !empty($_POST['taskdescription']) && !empty($_POST['completedate'])){
        $tasktitle = mysqli_real_escape_string($conn,  $_POST['tasktitle']);
        $taskdesc = mysqli_real_escape_string($conn, $_POST['taskdescription']);
        $day =$_POST['completedate'];
        $categoryid = $_POST['categoryselect'];
        $userid = $userid;
        $taskid = bin2hex(random_bytes(3));
        $taskstatus = "todo";
        $color = "#ca2e07";
        $inserttask = $conn->query("INSERT INTO task(userid,categoryid,	taskid, tasktitle, taskdesc,status ,day, color) 
                                    VALUES('$userid', '$categoryid', '$taskid', '$tasktitle', '$taskdesc','$taskstatus','$day', '$color')");
        if($inserttask){
            $taskidsuccess =  $taskid;
            $err['success'] = "<p style='padding:10px ;color:green;'>Task added successfullty ";
            ?>
            <script>
               setTimeout(() => {
                document.querySelector(".about_container").style.display = "block";
                document.querySelector("#about").click();
               }, 500);
            </script>
            <?php
        }else{
            $err['fail'] = "<p style='padding:10px; color:red;'>  Failed to add task, try again " . $conn->error;
        }
    }else{
        $err['emptytitle'] = "<p style='padding:10px; color:red;'>All fields are required ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./taskido/javascript/jquery-3.4.1.min.js"></script>
    <title>Add New Task</title>
    <link rel="stylesheet" href="addtask.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <input type="checkbox" name="about" id="about">
    <div class="body">
    <div class="addnewtask">
        <div class="addtask_wrapper">
            <style>
                .addtask_wrapper{
                    display:flex;
                    justify-content:space-around;
                    padding:10px;
                    align-items:center;
                }
                .addtask_wrapper{
                }
            </style>
        <h2><small>
            <style>
             .fa-long-arrow-left{
                font-weight:900;
                }
                .arrow_back{
                    margin-right: 10px;
                }
            </style>
            <span class="arrow_back">
                <a href="./me">
                <i class="fa fa-long-arrow-left"></i>
                </a>
            </span>
    </small> New task</h2> 
            <p><a href="./auth/edit">Setting</a>
        </div>
       
    </div>
    
    <form  method="post">
   
        <div class="category  addbox" id="category"> <div class="error-div"> <?php foreach($err as $error){ echo $error;} ?> </div>
            <div class="add-box">
                <!-- if there exist options -->
                <!-- { -->
                    <div class="input-box">
                        <select name="categoryselect" id="select">
                          <!-- <option value="undefined">Choose category </option> -->
                            <?php
                            while($catid = $selectcategory->fetch_assoc()){
                                ?>
                                  <option value="<?php echo $catid['categoryid'];?>"><?php echo $catid['categoryname'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                <!-- } -->
                <!-- else display add Category -->
                  <!-- { -->
                    <div class="a">
                        <a href="./new_category">Add New Category</a>
                    </div>
                    <!-- } -->
            </div>
        </div>

        <div class="taskdetails  addbox" id="taskdetails">
            <div class="task-details-box">
                <div class="input-field">
                    <input type="text" name="tasktitle" id="" placeholder="Task title">
                    <textarea name="taskdescription" id="textarea" placeholder="Task description"></textarea>
                    <!-- <label for="starttimeanddate">Start</label>
                    <input type="date" name="startdate"> -->
                    <label for="completetimeanddate">Till when</label>
                    <input type="date" name="completedate">
                </div>
                <div class="submitarea">                    
                    <div class="gotonextactivity">
                        <div class="addnewcategorybtn">
                            <button type="submit" name="addtask">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <style>
            .about_container{max-width: 300px; display:none;right: 0;left: 0;top: 20%;margin: auto;position: absolute;border-radius: 5px;padding: 20px 0; background: #f2f2f2;animation: zoom_about 0.7s;}
            /*Dipslay none*/
            @keyframes zoom_about{from{transform: scale(0);}}
           .about_container form button{padding: 8px 12px; font-weight: 700; border: 3px solid rgb(165, 162, 162);border-radius: 5px;}
           button{cursor: pointer;}
            .about{padding: 40px 20px; display: flex; justify-content: space-evenly;}
            .about a{color: rgb(52, 52, 85);background: #000;padding: 1px 20px ;}
            #about:checked ~ .body{filter: blur(5px);}
            .propmt_task_title{width: 90%; margin: auto;}
            #about{display:none;}
            .inner_wrapper_task_title{padding: 0 15px;}
    </style>
    <!--About Taskido PopUp-->
    <div class="about_container">
        <div class="propmt_task_title">
            <div class="inner_wrapper_task_title">
                <i><small style="margin:  20px 0 0 0;color: brown;">Task is added to Do Later if you skip this option</small></i>
                <p class="p">Task Title <?php echo ":  ". $tasktitle;?></p>
            </div>
        </div>

        <?php
        if(isset($_POST['startnow'])){
            $idStatus = $_POST['inprogress'];
            $status = "inprogress";
            $color="green"; 
            $updateStatus = $conn->query("UPDATE task SET status='$status', color='$color' WHERE taskid ='$idStatus'");
        }
        ?>
        <div class="about">
            <form method="post" class="todo">
                <input type="text" name="todo" value="<?php echo $taskidsuccess;?>" hidden id="todo">
                <label for="about"> <button type="submit" name="doLater">Do later</button></label>
            </form>
            <form method="post" class="inprogress">
             <input type="text" name="inprogress" value="<?php echo $taskidsuccess;?>" hidden id="inprogress">
             <label for="about"> <button type="submit" name="startnow">Start Now</button></label>
            </form>
        </div>
    </div>
                
    <script>
        $('#textarea').on('input', function(){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight)+'px';
        });
    </script>
     <script>
            const form = document.querySelector("form"), 
            alertbox = form.querySelector(".error-div");
                setTimeout(() => {
                    alertbox.innerHTML = '';
                }, 3000);
        </script> 

    <!-- <script>
        document.querySelector("#about").click();
    </script> -->
</body>
</html>

