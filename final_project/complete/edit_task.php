<?php 
    session_start();

    // Check if user already logged in 
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
		echo "<script>alert('please log in')</script> ";
        header("location: login.php");

	}
    if(!isset($_GET["task_id"]) || trim($_GET['task_id']) == ""
    || !isset($_GET["user_id"]) || trim($_GET['user_id']) == ""){
        echo "<script>alert('missing task_id or user_id')</script> ";
        exit();
    }
    
    $host = "303.itpwebdev.com";
    $user = "nchan103_db_user";
    $pass = "itp303webdev";
    $db = "nchan103_taskboard";

    // Establish MySQL Connection.
    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check for any Connection Errors.
    if ( $mysqli->connect_errno ) {
        echo "<script>alert('error when connecting to the database')</script> ";
        $mysqli->close();
        exit();
    }
    $mysqli->set_charset('utf8');

    $task_id = $_GET["task_id"];
    $user_id = $_GET["user_id"];

    $sql = "SELECT * FROM tasks
            WHERE $task_id = tasks.task_id;";
            
    $results =  $mysqli->query($sql);

    if (!$results) {
        echo "<script>alert('error querying sql')</script> ";
        $mysqli->close();
        exit();
    }
    $result_data = $results->fetch_assoc();
    if($result_data == null){
        echo "<script>alert('task with given task id doesnt exist')</script> ";
        $mysqli->close();
        exit();
    }
    $name = $result_data["name"];
    $priority = $result_data["priority"];
    $category_id = $result_data["category_id"];

    $sql_category = "SELECT * FROM categories;";

    $results_category = $mysqli->query($sql_category);

    if (!$results_category) {
        echo "<script>alert('error querying sql for category options')</script> ";
        $mysqli->close();
        exit();
    }




    

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Here you can edit the task you just clicked on. You can change the tasks's name, priority, and its completion category. Once finished, you can submit and then return to the task board" >

    <title> assignment 5 forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="general.css">

<style>


    #header{
        height: 70px;
        background-color: rgb(21, 21, 21);


    }



 
    .form-group{
        margin: 8px;
    }
    .goback{
        margin: 8px;
        padding:12px;

    }
    .sucessful{
        color: greenyellow;
        font-size: 30px;
    }




</style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light p-0">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="landing.php"> Landing</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="sign_out.php">Sign Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row no-gutters">
        <div class="col-12 no-gutters">
            <div id="header" class=" d-flex flex-column ">
                <h1 class="">Edit Task</h1>
            </div><!--header-->
        </div><!--col-->
    </div> <!--row-->
    <p class="sucessful"> </p>
    
    <div class="row">
        <div class="col-6">
           <!--<form id="signup-form" action="taskboard.html" method="POST"> --> 
            <form id="signup-form">
                <!--first name-->
                <div class="form-group row">
                    <label for="task" class="form-label col-sm-2 col-form-label" >Task Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="task" class="form-control" value="<?php echo $name?>" id="task" required>
                    </div> <!-- col sm 10-->
                </div><!-- form-group -->

                <!--favorite priority optional text field for image url-->
                <div class="form-group row">
                    <label for="priority" class="form-label col-sm-2 col-form-label">Priority</label>
                    <div class="col-sm-10">
                        <input type="text" name="priority" class="form-control" value="<?php echo $priority?>" id="priority">
                    </div> <!-- col sm 10-->
                </div><!-- form-group -->

                <div class="form-group row">
                <label for="status" class="form-label col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select name="status" class="form-control"  id="status">
                        <?php while( $row = $results_category->fetch_assoc() ): ?>

								<?php if ( $row['category_id'] == $category_id) : ?>

									<option value="<?php echo $row['category_id']; ?>" selected>
										<?php echo $row['category']; ?>
									</option>

								<?php else: ?>

									<option value="<?php echo $row['category_id']; ?>">
										<?php echo $row['category']; ?>
									</option>

								<?php endif; ?>

								<?php endwhile; ?>

                    </select>
                    <small id="status-error" class="form-text text-danger"></small>
                </div> <!-- col sm 10-->
            </div><!-- form-group -->
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div> <!-- .col -->
                </div> <!-- .form-group -->
            </form><!-- form-->
            <div class="goback">
                <button type="submit" class="btn btn-primary" id="back-bttn">Go Back</button>
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script> 
   <script>
        document.querySelector("#signup-form").onsubmit = function(){
            
            form = document.querySelector("#signup-form")

            
            var formData = {
                task_id: <?php echo $task_id?>,
                task: document.querySelector("#task").value.trim(),
                priority: document.querySelector("#priority").value.trim(),
                category: document.querySelector("#status").value.trim()
            }
            $.ajax({
                url: "edit_confirmation.php",
                type: "POST", 
                data: formData,
                dataType: "text",
                success: function (data){
                    const data_obj = JSON.parse(data)
                    console.log(data_obj)
                    
                    if(data_obj.status == "success"){
                        document.querySelector(".sucessful").innerHTML = "successfully edited!"
                        return true
                    }
                    else{
                        alert(data_obj.status)
                        return false
                    }
                },
                error:function(x,e) {
                    if (x.status==0) {
                        alert('You are offline!!\n Please Check Your Network.');
                    } else if(x.status==404) {
                        alert('Requested URL not found.');
                    } else if(x.status==500) {
                        alert('Internel Server Error.');
                    } else if(e=='parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if(e=='timeout'){
                        alert('Request Time out.');
                    } else {
                        alert('Unknow Error.\n'+x.responseText);
                    }
                }
            })
            console.log("hi")
            return false
        }
        document.querySelector("#back-bttn").onclick = function(){
            window.location.replace('taskboard.php')
            console.log("hi")

        }
    
   </script>




</body>
</html>