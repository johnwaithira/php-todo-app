<?php
require "./session.php";
checkLoggedIn();
require "./configuration/connect.php";
$c = "";
$allCategoryUser = $_SESSION['loggedin'];
$selectUser = $conn->query("SELECT userid FROM taskidodb where email = '$allCategoryUser'");
$qry = $selectUser->fetch_assoc();
$allCategorySelector = $qry['userid'];
if(isset($_GET['c']) && $_GET['c'] !=""){
    $cid = $_GET['c'];
    $getCategoryName = $conn->query("SELECT categoryname
                                     FROM taskcategory where categoryid = '$cid'");
    $row = $getCategoryName->fetch_assoc();
    $c = $row['categoryname'];
        $selectAllTasks = $conn->query("SELECT userid, categoryid, taskid, tasktitle, taskdesc, day, status, color 
                                        FROM task WHERE categoryid = '$cid' and not status = 'done' and not status = 'deleted'");
        $totalTasksInHand = $selectAllTasks->num_rows;
        $todoLabel = "todo";
        $selectTodoTasks = $conn->query("SELECT userid, categoryid, taskid, tasktitle, taskdesc, status, day 
                                         FROM task WHERE categoryid = '$cid' && status = '$todoLabel'");
        $totalTodoTasksInHand = $selectTodoTasks->num_rows;
        $inProgressLabel = "inprogress";
        $selectInProgressTasks = $conn->query("SELECT userid, categoryid, taskid, tasktitle, taskdesc, status, day 
                                                FROM task WHERE categoryid = '$cid'&& status = '$inProgressLabel'");
        $totalInProgessTasks = $selectInProgressTasks->num_rows;
        $doneLabel = "done";
        $selectDoneTasks = $conn->query("SELECT userid, categoryid, taskid, tasktitle, taskdesc, day
                                         FROM task WHERE categoryid = '$cid' && status = '$doneLabel'");
        $totalDoneTasks = $selectDoneTasks->num_rows;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog Ui</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="taskido_ui">
        <div class="taskido_wrapper">
            <div class="taskido_navigation">
                <div class="taskido_upper_navigation">
                    <div class="in">
                        <style>
                            .in{
                                display:flex;  

                            }
                            .fa-long-arrow-left{
                                font-weight:900;
                            }
                        </style>
                        <span class="arrow_back">
                            <a href="./me">
                                <i class="fa fa-long-arrow-left"></i>
                            </a>
                        </span>
                        <h2><?php echo $c;?></h2>
                    </div>
                </div>
                <div class="taskido_lower_navigation">
                    <div class="taskido_navigation_tab">
                        <button onclick="show_project_page(event, ('all'))" id="main_tab" class="taskido_button_navigate_tabs">
                            All
                            <span class="item_number">
                                <?php echo $totalTasksInHand;?>
                            </span>
                        </button>
                        <button onclick="show_project_page(event, ('todo'))" class="taskido_button_navigate_tabs">
                            To do  
                            <span class="item_number">
                                <?php echo $totalTodoTasksInHand;?>
                            </span>
                        </button>
                        <button onclick="show_project_page(event, ('inprogress'))" class="taskido_button_navigate_tabs">
                            In progress 
                            <span class="item_number">
                                <?php echo $totalInProgessTasks;?>
                            </span>
                        </button>
                        <button onclick="show_project_page(event, ('done'))" class="taskido_button_navigate_tabs">
                            Done 
                            <span class="item_number">
                                <?php echo $totalDoneTasks;?>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
           <div class="catalog">
            <div id="all" class="taskido_tab_content">
                <div class="content">
                    <?php
                    if($selectAllTasks->num_rows<1){
                        ?>
                        <div class="no_task_wrapper">
                            <div class="inner_no_task_wrapper">
                                <img src="./programing-01_4x.webp" alt="">
                                <p align='center'>No task yet</p>
                            </div>
                         </div>
                        <?php
                    }else{
                        while($selectAllTasksRow = $selectAllTasks->fetch_assoc()){
                            $profileUserId = $selectAllTasksRow['userid'];  
                            $labelProfile = $conn->query("SELECT profiledata 
                                                          FROM profile WHERE userid='$profileUserId'");
                            $labelProfilePath = $labelProfile->fetch_assoc();
                            $profileUserIdPic =  $labelProfilePath['profiledata'];
                        ?>
                            <div class="task_container">
                                <div class="upper_task_container">
                                    <h3 class="tasktitle">
                                        <?php echo $selectAllTasksRow['tasktitle'];?>
                                    </h2>
                                    <div class="indicator">
                                        <div class="circle" style="backgroud:<?php echo $selectAllTasksRow['color'];?>">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="lower_task_container">
                                    <div class="date">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <small>till 
                                            <?php echo $selectAllTasksRow['day'];?>
                                        </small>
                                    </div>
                                    <p class="p">
                                        <?php echo $selectAllTasksRow['status'];?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div> 
            </div>
            <div id="todo" class="taskido_tab_content">
                <div class="content">
                <?php
                    if($selectTodoTasks->num_rows<1){
                        ?>
                        <div class="no_task_wrapper">
                            <div class="inner_no_task_wrapper">
                                <img src="./programing-01_4x.webp">
                                <p align='center'>No task yet</p>
                            </div>
                         </div>
                        <?php
                    }else{
                        while($selectTodoTasksRow = $selectTodoTasks->fetch_assoc()){
                            $profileUserIdTodo = $selectTodoTasksRow['userid'];  
                            $labelProfileTodo = $conn->query("SELECT profiledata 
                                                            FROM profile WHERE userid='$profileUserIdTodo'");
                            $labelProfilePathTodo = $labelProfileTodo->fetch_assoc();
                            $profileUserIdPicTodo =  $labelProfilePathTodo['profiledata'];
                        ?>
                        <a href="?c=<?php echo $selectTodoTasksRow['categoryid'] . "&taskId=".$selectTodoTasksRow['taskid'] ;?>">
                            <div class="task_container">
                                <div class="upper_task_container">
                                    <h3 class="tasktitle">
                                        <?php echo $selectTodoTasksRow['tasktitle'];?>
                                    </h2>
                                    <div class="indicator">
                                        <div class="circle">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="lower_task_container">
                                    <div class="date">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <small>till 
                                            <?php echo $selectTodoTasksRow['day'];?>
                                        </small>
                                    </div>
                                    <style>
                                    #customize button{
                                        border: none;
                                        width: 100px;
                                        border-radius: 20px;
                                        flex-direction: column;
                                        margin: 3px 5px;
                                        float: right;
                                        padding: 8px 10px;
                                    }
                                    </style>
                                    <div class="formz">
                                        <form  id="customize" method="post">
                                            <input type="text" name="completeTask" hidden value="<?php echo $selectTodoTasksRow['taskid'];?>">
                                            <button name="begin" id="customizebutton" type="submit">Start</button>
                                        </form>
                                        <form  id="customize" method="post">
                                            <input type="text" name="suspendedTask" hidden value="<?php echo $selectTodoTasksRow['taskid'];?>">
                                            <button type="submit" id="customizebutton" name="cancel">Cancel</button>
                                        </form>
                                    </div>
                                    
                                    <?php
                                    if(isset($_POST['begin'])){
                                        $finish = $_POST['completeTask'];
                                        $done = "inprogress";
                                        $qry = $conn->query("UPDATE task SET status = '$done' WHERE taskid ='$finish'");
                                        ?>
                                        <script>
                                            setTimeout(() => {
                                                window.location.assign("./view?c=<?php echo $cid;?>");
                                            }, 1000);
                                        </script>
                                        <?php
                                        
                                    }if(isset($_POST['cancel'])){
                                        
                                        $sus = $_POST['suspendedTask'];
                                        $suspend = "deleted";
                                        $qry = $conn->query("UPDATE task SET status = '$suspend' WHERE taskid ='$sus'");
                                        ?>
                                        <script>
                                        setTimeout(() => {
                                            window.location.assign("./view?c=<?php echo $cid;?>");
                                        }, 1000);
                                         </script>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                        <?php
                        }
                     }
                    ?>
                </div> 
            </div>
            <div id="inprogress" class="taskido_tab_content">
                <div class="content">
                <?php
                    if($selectInProgressTasks->num_rows<1){
                        ?>
                        <div class="no_task_wrapper">
                            <div class="inner_no_task_wrapper">
                                <img src="./programing-01_4x.webp" alt="">
                                <p align='center'>No task yet</p>
                            </div>
                         </div>
                        <?php
                    }else{
                        while($selectInProgressTasksRow = $selectInProgressTasks->fetch_assoc()){
                            $profileUserIdInProgress = $selectInProgressTasksRow['userid'];  
                            $labelProfileInProgress = $conn->query("SELECT profiledata FROM profile WHERE userid='$profileUserIdInProgress'");
                            $labelProfilePathInProgress = $labelProfileInProgress->fetch_assoc();
                            $profileUserIdPicInProgress =  $labelProfilePathInProgress['profiledata'];
                        ?>
                        <a href="?c=<?php echo $selectInProgressTasksRow['categoryid'] . "&taskId=".$selectInProgressTasksRow['taskid'] ;?>"">
                            <div class="task_container">
                                <div class="upper_task_container">
                                    <h3 class="tasktitle"><?php echo $selectInProgressTasksRow['tasktitle'];?></h2>
                                    <div class="indicator">
                                        <div class="circle">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="lower_task_container">
                                    <div class="date">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <small>till <?php echo $selectInProgressTasksRow['day'];?></small>
                                    </div>
                                    <style>
                                    #customize button{
                                        border: none;
                                        width: 100px;
                                        border-radius: 20px;
                                        flex-direction: column;
                                        margin: 3px 5px;
                                        float: right;
                                        padding: 8px 10px;
                                    }
                                    </style>
                                    <div class="formz">
                                        <form  id="customize" method="post">
                                            <input type="text" name="completeTask" hidden value="<?php echo $selectInProgressTasksRow['taskid'];?>">
                                            <button name="complete" id="customizebutton" type="submit">Complete</button>
                                        </form>
                                        <form  id="customize" method="post">
                                            <input type="text" name="suspendedTask" hidden value="<?php echo $selectInProgressTasksRow['taskid'];?>">
                                            <button type="submit" id="customizebutton" name="suspend">Suspend</button>
                                        </form>
                                    </div>
                                    <?php
                                    if(isset($_POST['complete'])){
                                        $finish = $_POST['completeTask'];
                                        $done = "done";
                                        $qry = $conn->query("UPDATE task SET status = '$done' WHERE taskid ='$finish'");
                                        ?>
                                        <script>
                                            setTimeout(() => {
                                                window.location.assign("./view?c=<?php echo $cid;?>");
                                            }, 2000);
                                        </script>
                                        <?php
                                        
                                        
                                    }if(isset($_POST['suspend'])){
                                        
                                        $sus = $_POST['suspendedTask'];
                                        $suspend = "todo";
                                        $qry = $conn->query("UPDATE task SET status = '$suspend' WHERE taskid ='$sus'");
                                        ?>
                                        <script>
                                        setTimeout(() => {
                                            window.location.assign("./view?c=<?php echo $cid;?>");
                                        }, 2000);
                                         </script>
                                        <?php
                                    }
                                    
                                    ?>
                                </div>
                            </div>
                        </a>
                        <?php
                        }
                     }
                    ?>                    
                </div> 
            </div>
            <div id="done" class="taskido_tab_content">
                <div class="content">
                <?php
                    if($selectDoneTasks->num_rows<1){
                       ?>
                        <div class="no_task_wrapper">
                            <div class="inner_no_task_wrapper">
                                <img src="./programing-01_4x.webp" alt="">
                                <p align='center'>No task yet</p>
                            </div>
                         </div>
                        <?php
                    }else{
                        while($selectDoneTasksRow = $selectDoneTasks->fetch_assoc()){
                            $profileUserIdDone = $selectDoneTasksRow['userid'];  
                            $labelProfileDone = $conn->query("SELECT profiledata FROM profile WHERE userid='$profileUserIdDone'");
                            $labelProfilePathDone = $labelProfileDone->fetch_assoc();
                            $profileUserIdPicDone =  $labelProfilePathDone['profiledata'];
                        ?>
                            <div class="task_container">
                                <div class="upper_task_container">
                                    <h3 class="tasktitle"><?php echo $selectDoneTasksRow['tasktitle'];?></h2>
                                    <div class="indicator">
                                        <div class="circle">                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="lower_task_container">
                                    <div class="date">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <small>till <?php echo $selectDoneTasksRow['day'];?></small>
                                    </div>
                                    <div class="profile" style=" width:30px; height:30px;border: 2px solid #00800080; display:flex; justify-content:center; align-items:center; border-radius:50%;">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }//end of while Loop **fetching data from the database**
                    }
                    ?>
                </div> 
            </div>
           </div>
           <div class="stick_add_navigator_btn">
               <div class="add_interface">
                   <a href="addtask?category=<?php echo $cid;?>"><span>+</span> New task</a>
               </div>
           </div>
        </div>
    </div>
    <script>
        function show_project_page(evt, taskido_tab){
            var i, tablink, tabcontent;
            tabcontent = document.getElementsByClassName("taskido_tab_content");
            for(i = 0; i < tabcontent.length; i++){
                tabcontent[i].style.display = "none";
            }
            tablink = document.getElementsByClassName("taskido_button_navigate_tabs");
            for(i = 0; i < tablink.length; i++){
                tablink[i].className = tablink[i].className.replace(" active", "");
            }
            document.getElementById(taskido_tab).style.display = "block";
            evt.currentTarget.className += " active"; 
        }
        document.getElementById("main_tab").click();
    </script>
</body>
</html>

