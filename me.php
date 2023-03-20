<?php
require "./session.php";
checkLoggedIn();
require "./configuration/connect.php";
$email = $_SESSION['loggedin'];
$check_user = $conn->query("SELECT userid, username FROM taskidodb  WHERE email = '$email'");
if($check_user){
    $profilepicandname= $check_user->fetch_assoc();
    $username = $profilepicandname['username'];
        $userid = $profilepicandname['userid'];
            $profilepic = $conn->query("SELECT profiledata FROM profile where userid='$userid'");
               $prow = $profilepic->fetch_assoc();
                    $profile = $prow['profiledata'];

}else{
    echo $check_user->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>taskido</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="taskido_ui">
        <div class="taskido_wrapper">
            <div class="taskido_navigation">
                <div class="taskido_upper_navigation">
                    <h2>Hello,  <?php
                            $username = $username;
                            if(strlen($username)> 10){
                                $stringCut = substr($username, 0, 10);
                                $endPoint = strrpos($stringCut, ' ');
                                $username = $endPoint? substr($stringCut ,0 ,$endPoint):substr($stringCut, 0);
                                $username .= "...";
                            }
                            echo " ".$username;                         
                        ?></h2>
                    <!-- <p><i class="fa fa-bell"></i></p> -->
                    <style>
                        img{
                            width: 45px;
                            height: 45px;
                            border-radius: 50%;
                            border: 1px solid #000;
                        }
                    </style>
                    <img src="./userprofile/<?php echo $profile;?>">
                </div>
            </div>
            <div class="home">
            <div class="taskido_tasks_display">
                <div class="inner_todays_tasks_wrapper">
                    <div class="task-show_div">
                        <p>Today</p>
                        <!-- userid	taskid	taskdesc -->
                        <?php
                        $today = date("Y-m-d");
                        $taskDone = "done";
                        $task = $conn->query("SELECT taskid, taskdesc FROM task WHERE userid = '$userid' && day='$today' && status != '$taskDone'");
                        $taskpending = $task-> num_rows;
                        if($taskpending < 1){
                            $taskpending = "No task";
                        }elseif($taskpending == 1){
                            $taskpending = $taskpending ." task";
                        }else{
                            $taskpending = $taskpending ." Tasks";
                        }
                        ?>
                        <h2><?php echo $taskpending ;?> </h2>
                    </div>
                    <div class="task-svg_div img">
                    </div>
                </div>
            </div>
            </div>
            <!-- id	user		 -->
            <?php
                $taskcategory = $conn->query("SELECT categoryid,  categoryname  FROM taskcategory WHERE user='$userid'");
                if($taskcategory->num_rows < 1){
                ?>  <!-- default div for new user -->
                    <div class="default_category">
                        <div class="inner_default_category">
                            <a href="./new_category"> + Add new Category </a>
                        </div>
                    </div>     
                <?php
            }else{
                ?>
            <div class="category">
                <div class="category_wrapper">
                    <div class="category_title">
                        <h2>Category</h2>
                    </div>
                    <div class="category_div">

                    <?php
                        while($catrow = $taskcategory->fetch_assoc()){
                            ?>
                            <a href="./view?c=<?php echo $catrow['categoryid'];?>">

                                <div class="category_box">
                                    <div class="img_profile">
                                    <img src="./userprofile/<?php echo $profile;?>">
                                    </div>
                                    <div class="category_description">
                                        <div class="progress">
                                            <?php
                                            $done = "done";
                                            $todo = "todo";
                                            $inAction = "inprogress";
                                            $taskcategoryid =  $catrow['categoryid'];
                                            $selectCurrentTasks = $conn->query("SELECT taskid FROM task WHERE categoryid = '$taskcategoryid' && status = '$inAction'");
                                            $num_oftasks =$selectCurrentTasks->num_rows;
                                            
                                            $selectAllTasks = $conn->query("SELECT taskid FROM task WHERE categoryid = '$taskcategoryid' && status != '$done' && status != 'deleted'");
                                            $totalTasks = $selectAllTasks->num_rows;
                                            if(($num_oftasks > 0 )&&($totalTasks>0)){
                                                $inActionTasksPercentage = ($num_oftasks/$totalTasks)*100; 
                                            }else{
                                                $inActionTasksPercentage = 0;
                                            }
                                            
                                           ?>
                                            <small><?php echo $num_oftasks."/".$totalTasks ." tasks ~ ".$inActionTasksPercentage."%";?> </small>
                                            <h2><?php
                                            $name = $catrow['categoryname'];
                                            if(strlen($name) > 15){
                                                $strCut = substr($name,0,15);
                                                $endPoint = strpos($strCut, ' ');
                                                $name = $endPoint? substr($strCut, 0, $endPoint):substr($strCut,$endPoint);
                                                $name .= "...";
                                            }
                                             echo $name;
                                             ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                        
                        <!-- //btn section -->
                        <a href="./new_category?new"><button style="padding:10px;margin:25%;">Add New</button></a>
                        <!-- //btn section -->
                    </div>
                </div>
            </div> 
            <?php
                }
            ?>
            <!-- This displays when the user has created categories  -->
            <div class="recently_added">
                <div class="recent_title">
                    <h3>Recently Added</h3>
                    <span class="span">All tasks</span>
                </div>
                <?php
                    $selectrecenttasks = $conn->query("SELECT tasktitle, taskdesc, day  FROM task WHERE userid = '$userid' order by id desc LIMIT 5");
                    if($selectrecenttasks->num_rows < 1){
                        ?>
                        <style>
                            .div-no-recent{
                                width:100%;
                                padding: 20px 0;
                            }
                            .no-recent{
                                padding: 30px 0;
                                width: 85%;
                                margin: 0 auto;
                                text-align:center;
                            }
                        </style>
                        <div class="div-no-recent">
                            <div class="no-recent">
                                <div class="h1">
                                    <h3>No recent tasks yet</h1>
                                </div>
                            </div>
                        </div>
                        <?php
                }else{
                    while($taskrow = $selectrecenttasks->fetch_assoc()){
                        ?>
                            <div class="recent_added_task_box">
                                <div class="recent_task_title">
                                    <h3><?php echo $taskrow['tasktitle'];?></h3>
                                    <small>High&nbsp;Priority</small>
                                </div>
                                <div class="recent_task_description">
                                    <div class="recent_task_description_body">
                                        <p><?php echo $taskrow['taskdesc'];?></p>
                                    </div>
                                    <hr>
                                    <div class="recent_task_description_date">
                                        <p>
                                            till 
                                            <i style=" padding:0 10px;" class="fa fa-clock-o"> 
                                            </i>
                                            <?php echo $taskrow['day'];
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
            }            
        
        ?>
                
            </div>
        </div>  
    </div>
</body>
</html>