<?php
require "./session.php";
checkLoggedIn();
$err = array();
require "./configuration/connect.php";
$email = $_SESSION['loggedin'];
$check_user = $conn->query("SELECT userid FROM taskidodb  WHERE email = '$email'");
$id = $check_user->fetch_assoc();
$userid = $id['userid'];
$selectcategory = $conn->query("SELECT categoryid, categoryname  FROM taskcategory WHERE user='$userid'");
// $catid = $selectcategory->fetch_assoc();
// id	user	categoryid	categoryname	
if(isset($_POST['add_new_category'])){
    if(!empty($_POST['category'])){
        $categoryname = $_POST['category'];
            $check_category = $conn->query("SELECT categoryname FROM taskcategory WHERE user = '$userid' AND categoryname = '$categoryname'");
            if($check_category->num_rows > 0){
                $err['found'] = "<p style='color:red'> Sorry the Name already exist";
            }else{
                $categoryid = bin2hex(random_bytes(3));
                $insert = $conn->query("INSERT INTO taskcategory(user, categoryid, categoryname) VALUES('$userid','$categoryid','$categoryname')");
                if($insert){
                    $err['added'] = "<p style='color:green'> New Category added";
                    ?>
                    <script>
                        setInterval(() => {
                            window.location.assign("./new_category");
                        }, 1000);
                    </script>
                    <?php
                }
            }
    }else{
    $err['empty'] ="<p style='color:red;'>You cant insert empty fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <style>
        @import url(./placeholder.css);
        .cat_navigation{
            padding: 20px 15px;
        }
        .form-add-new-category, .cat_all_categories_div{
            width: 90%;
            margin: auto;
            padding: 10px 0;
        }
        form{

            box-shadow: 0 2px 5px 0 rgb(240 240 240 /91%),  0 2px 5px 0 rgb(0 0 0 /12%);

        }
        .cat_form{
            display: flex;
            flex-direction: column;
            padding: 20px 5px;

        }
        .cat_form input{
            padding: 15px;
            outline: none;
            border: 1px solid rgba(90, 90, 88, 0.712);
            font-size: 16px;
        }
        .cat_form .btn{
            padding: 10px 0;
        }
        .cat_form .btn button{
            padding: 10px 25px;
            font-weight: 800;
            box-shadow: 0 2px 5px 0 rgb(240 240 240 /91%),  0 2px 5px 0 rgb(0 0 0 /12%);
            background: rgb(238, 238, 238);
            border: none;
        }
        .cat_inner_category_wrapper{
            border-radius: 5px;
            padding-top: 20px;
            border-bottom: 1px solid rgb(226, 218, 218);
        }
        .cat_empty-category{
            width: 100%;
            /* display: none; */
            overflow:hidden;
            border: 1px solid rgb(226, 218, 218);
            
        }.cat_empty_text{
            text-align: center;
        }
        .cat_with_content{
          color: rgb(88, 84, 84);
          display: flex;
          background: rgb(250, 250, 250);
          flex-direction: column;
          height: 50vh;
         
          overflow: scroll;
        }
        .cat_with_content::-webkit-scrollbar{
            width: 0;
        }
        .cat_list_title{
            width: 100%;
            padding: 5px 0;
            background: #fff;
            position: fixed;
        }

        .cat_list{
            margin-top: 60px;
            padding-left: 10px;
            font-size: 16px;
        }
    </style>
    <div class="cat_navigation">
    <style>
         .in{
             display:flex;
             align-items:center;
             margin-right: 20px;
         }
         .fa-long-arrow-left{
             font-weight:900;
             padding-right:20px;
         }
     </style>
     <div class="in">
      <span class="arrow_back">
         <a href="./me">
             <i class="fa fa-long-arrow-left"></i>
         </a>
     </span>
        <h2> Task(s) Category </h1>
      </div>
    </div>
    <!-- All classes and id to have  cat_ as a suffix -->
    <div class="form-add-new-category">
      <form  method="post">
        <div class="errorDiv"> <?php foreach($err as $error){ echo "<p style='color:red;'>".$error;} ?> </div>
        <div class="cat_form">
            <input type="text" name="category" placeholder="New Category name">
           <div class="btn">
            <button type="submit" name="add_new_category">Add </button>
           </div>
           
        </div>
     </form>
        <div class="cat_all_categories_div">
            <div class="cat_inner_category_wrapper">
                <?php
                    if($selectcategory->num_rows <1){
                        ?>
                        <div class="cat_empty-category">
                            <div class="cat_empty">
                                <img src="./undraw_Empty_re_opql.svg" alt="">
                                <div class="cat_empty_text">
                                    <p>No category is set</p>
                                </div>
                            </div>
                        </div>                        
                        <?php
                    }else{
                        ?>
                        <div class="cat_with_content">
                            <div class="cat_list_title">
                                <h3>My categories</h3>
                            </div>
                            <div class="cat_list">
                                <?php
                                    while($catid = $selectcategory->fetch_assoc()){
                                        ?>
                                        <ul>
                                            <li><h2><?php echo $catid['categoryname'];?></h2></li>
                                        </ol>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>


            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            document.querySelector(".errorDiv").innerHTML = '';
        }, 3000);
    </script>
</body>
</html>