<?php 
    session_start();

    // Check if user already logged in 
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
		echo "<script>alert('please log in')</script> ";
    header("location: login.php");
		exit();
	}
    else{
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
        $user_id = $_SESSION["user_id"];

        $sql_todo = "SELECT * FROM tasks 
                        WHERE tasks.user_id = $user_id
                        AND tasks.category_id = 1";
        
        $results_todo =  $mysqli->query($sql_todo);

        if (!$results_todo) {
            echo "<script>alert('error querying sql for items in todo')</script> ";
            $mysqli->close();
		    exit();
        }

        $sql_in_progress = "SELECT * FROM tasks 
                            WHERE tasks.user_id = $user_id
                            AND tasks.category_id = 2";

        $results_in_progress =  $mysqli->query($sql_in_progress);
        if (!$results_in_progress) {
            echo "<script>alert('error querying sql for items in in_progress')</script> ";
            $mysqli->close();
		    exit();
        }


        $sql_finished = "SELECT * FROM tasks 
                        WHERE tasks.user_id = $user_id
                        AND tasks.category_id = 3";
        $results_finished =  $mysqli->query($sql_finished);
        if (!$results_finished) {
            echo $mysqli->error;
            $mysqli->close();
		    exit();
        }

        //count how many in todo
        $sql_count = "SELECT categories.category_id, COUNT(*) AS count FROM tasks
                            LEFT JOIN categories
                                ON tasks.category_id = categories.category_id
                            WHERE tasks.user_id = $user_id
                            AND categories.category_id = 1
                            GROUP BY categories.category_id
                            ORDER BY categories.category_id;";
        $results_count_1 = $mysqli->query($sql_count);

        if (!$results_count_1) {
            echo $mysqli->error;
            $mysqli->close();
		    exit();
        }
        $row_count_1 = $results_count_1->fetch_assoc();
        $count_1 = 0;
        if($row_count_1 != null){
            $count_1 = $row_count_1["count"];
        }

        //count how many in in progress
        $sql_count = "SELECT categories.category_id, COUNT(*) AS count FROM tasks
                            LEFT JOIN categories
                                ON tasks.category_id = categories.category_id
                            WHERE tasks.user_id = $user_id
                            AND categories.category_id = 2
                            GROUP BY categories.category_id
                            ORDER BY categories.category_id;";
        $results_count_2 = $mysqli->query($sql_count);

        if (!$results_count_2) {
            echo $mysqli->error;
            $mysqli->close();
		    exit();
        }
        $row_count_2 = $results_count_2->fetch_assoc();
        $count_2 = 0;
        if($row_count_2 != null){
            $count_2 = $row_count_2["count"];
        }

        //count how many in finished
        $sql_count = "SELECT categories.category_id, COUNT(*) AS count FROM tasks
                            LEFT JOIN categories
                                ON tasks.category_id = categories.category_id
                            WHERE tasks.user_id = $user_id
                            AND categories.category_id = 3
                            GROUP BY categories.category_id
                            ORDER BY categories.category_id;";
        $results_count_3 = $mysqli->query($sql_count);

        if (!$results_count_3) {
            echo $mysqli->error;
            $mysqli->close();
		    exit();
        }
        $row_count_3 = $results_count_3->fetch_assoc();
        $count_3 = 0;
        if($row_count_3 != null){
            $count_3 = $row_count_3["count"];
        }


    }


?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Here you can use todo-board to create new tasks and priorize them with your own priority system. Categorize each task in todo, in progres, and finished. Edit your tasks by clicking on them." >

    <title> assignment 5 forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="general.css">
<style>



    #header{
        height: 80px;
        background-color: black;



    }

    h1{
        margin-top: 10px;
        margin-left: 10px;
        
    }
    .no-gutters{
        padding-right: 0;
        padding-left: 0;
    }

    #left-col{
        background-color: rgb(74, 74, 74);
        padding: 0;

    }
    #mid-col{
        padding:0;
        background-color: rgb(51, 51, 51);
    }
    #right-col{
        background-color: rgb(32, 32, 32);
        padding: 0;
    }
    #task-graphic{
       width: 100%;
       height: auto;
       margin: 10px;
    }


    .table_wraper{
        border:3px solid black;
        margin: 0px;
        min-height: 700px;
        border-left: 0;
    }

    .table-title{
        font-size: 40px;
        padding: 0px;
        margin:0;
        border-bottom: 2px solid black;
    }

    button{
        color: red;
        border-radius: 50px;
    }

    #sign-out-prompt{
        margin-top: 20px;
    }

    .form-group{
        padding:5px;
    }
    
     td > a {
      color: white;
      padding: 0px;
      margin: 5px;
    }

    td > a:hover{
      background-color: rgb(25, 25, 25);
      padding: 5px;
      margin:0px
    }





</style>
</head>

<body>

    
    <div class="row navbar-row no-gutters p-0" >
        <div class="col-12 navbar-col no-gutters p-0">
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
        </div>
    </div>
    <div  class="container-fluid ">
        <div class="row no-gutters">
            <div class="col-12 no-gutters">
                <div id="header" class=" d-flex flex-column ">
                    <h1 class="">Welcome back <?php echo $_SESSION['username']?></h1>
                </div><!--header-->
            </div><!--col-->
        </div> <!--row-->


        





        <div id="body" class="row justify-content-center">
            <div id="left-col" class="col-4">
                
                <div class="row justify-content-center table_wraper">
                    <div class="col-12">
                        
                            <div id="todo-table-title" class="table-title">
                                TODO
                            </div> <!-- col11-->
                            <p id="count1">number of items: <?php echo $count_1; ?></p>
                 
                        <table class="table mt-4 text-light">
                            <thead>
                              <tr>
                                <th scope="col">Task</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody id="body1">
                                <?php while($row = $results_todo->fetch_assoc()): ?>
                                    <tr>
                                        <td><a  href="edit_task.php?task_id=<?php echo $row["task_id"]?>&user_id=<?php echo $_SESSION["user_id"]?>"><?php echo $row["name"]?></a></td>
                                        <td><?php echo $row["priority"]?></td>
                                        <td><button type="button" class="btn-close btn-close-white" aria-label="Close"></button></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                          </table>
                          <form class="form-inline row form1">
                            <div class="form-group col-7">
                                <input type="text" class="form-control task-form" placeholder="Task name" name="task" required>
                            </div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control priority-form" placeholder="priority" name="priority">
                            </div>
                            <div class="form-group col-2">
                                <button type="submit" class="btn btn-primary mb-2">Add</button>
                            </div>
                          </form>
                    </div>
                </div>
                

            </div><!--left col-->

            <div id="mid-col" class="col-4 ">
                <div class="row justify-content-center table_wraper">
                    <div class="col-12">
                        
                            <div id="inprog-table-title" class="table-title">
                                IN PROGRESS
                            </div> <!-- col11-->
                            <p id="count2">number of items: <?php echo $count_2; ?></p>
                 
                        <table class="table mt-4 text-light">
                            <thead>
                              <tr>
                                <th scope="col">Task</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody id="body2">
                            <?php while($row = $results_in_progress->fetch_assoc()): ?>
                                    <tr>
                                        <td><a  href="edit_task.php?task_id=<?php echo $row["task_id"]?>&user_id=<?php echo $_SESSION["user_id"]?>"><?php echo $row["name"]?></a></td>
                                        <td><?php echo $row["priority"]?></td>
                                        <td><button type="button" class="btn-close btn-close-white" aria-label="Close"></button></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                          </table>
                          
                         
                            <form class="form-inline row form2">
                                <div class="form-group col-7">
                                    <input type="text" class="form-control task-form" placeholder="Task name" name="task" required>
                                </div>
                                <div class="form-group col-3">
                                  <input type="text" class="form-control priority-form" placeholder="priority" name="priority">
                                </div>
                                <div class="form-group col-2">
                                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                                </div>
                              </form>

                    </div>
                </div>
             </div><!--mid col-->

            <div id="right-col" class="col-4">
                <div class="row justify-content-center table_wraper">
                    <div class="col-12">
                        
                            <div id="finished-table-title" class="table-title">
                                FINISHED
                            </div> <!-- col11-->
                            <p id="count3">number of items: <?php echo $count_3; ?></p>

                        <table class="table  mt-4 text-light">
                            <thead>
                              <tr>
                                <th scope="col">Task</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody id="body3">
                            <?php while($row = $results_finished->fetch_assoc()): ?>
                                    <tr>
                                        <td><a  href="edit_task.php?task_id=<?php echo $row["task_id"]?>&user_id=<?php echo $_SESSION["user_id"]?>"><?php echo $row["name"]?></a></td>
                                        <td><?php echo $row["priority"]?></td>
                                        <td><button type="button" class="btn-close btn-close-white" aria-label="Close"></button></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                          </table>
                          <form class="form-inline row form3">
                            <div class="form-group col-7">
                                <input type="text" class="form-control task-form" placeholder="Task name" name="task" required>
                            </div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control priority-form" placeholder="priority" name="priority">
                            </div>
                            <div class="form-group col-2">
                                <button type="submit" class="btn btn-primary mb-2">Add</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div><!--right col-->

        </div><!--body-->
    </div> <!--container-fluid-->

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function deleteItem(e){
            console.log(e.target.parentNode.parentNode.parentNode);  // to get the element
            table_body = e.target.parentNode.parentNode.parentNode;
            completion_id = table_body.id.slice(-1);
            table_row = e.target.parentNode.parentNode
            task_name = table_row.children[0].children[0].innerHTML
            task_priority = table_row.children[1].innerHTML
            console.log(task_priority)


            //delete the item in the database
            console.log(task_name)
            console.log(task_priority)
            console.log(completion_id)
            var formData = {
                task:task_name,
                priority:task_priority,
                category:completion_id
            }

            $.ajax({
                url:"remove_task.php",
                type:"POST",
                data: formData,
                dataType: "text",
                success: function (data){
                    const data_obj = JSON.parse(data)
                    if(data_obj.status == "success"){
                        table_row.remove()
                        counter = document.querySelector("#count" + completion_id.toString());
                        num = counter.innerHTML.match("([0-9]+)")[0]
                        counter.innerHTML = "number of items: " + (parseInt(num)-1).toString()
                        

                    }
                    else{
                        console.log(data_obj.status)
                    }

                },
                error:function(x,e){
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

            
            
        }

        function addItems(form, body, category_name){
        //save name and priority into variables
        const task_name = form.querySelector(".task-form").value.trim()
        const priority_name = form.querySelector(".priority-form").value.trim()
        //check if insertion is valid
        let validForm = true
        if (task_name.length === 0){
            validForm = false
            return
        }

        console.log(task_name)

        var formData = {
          task:task_name,
          priority:priority_name,
          category:category_name
        }

        //add to database
        $.ajax({
          url:"add_task.php",
          type: "POST",
          data: formData,
          dataType: "text",
          success: function (data){
            const data_obj = JSON.parse(data)
            
            if(data_obj.status == "success"){
                //add the ask to html
                const tr =document.createElement("tr")
                
                tr.innerHTML = '<td><a href="edit_task.php?task_id='+data_obj.task_id.toString()+'&user_id='+<?php echo strval($_SESSION["user_id"]); ?>+'">' + task_name.toString() + ' </a></td>\
                                <td>'+ priority_name+'</td>\
                                <td><button type="button" class="btn-close btn-close-white" aria-label="Close"></button></td>'
                body.appendChild(tr)
                //make the delete button work
                var buttons = document.querySelectorAll(".btn-close")
                for(i=0; i<buttons.length; i++){
                    buttons[i].onclick = e => {
                        deleteItem(e)

                    }
                }
                // update count
                counter = document.querySelector("#count" + category_name.toString());
                num = counter.innerHTML.match("([0-9]+)")[0]
                counter.innerHTML = "number of items: " + (parseInt(num)+1).toString()
                form.reset()
            }
            else{
                alert(data_obj.status)
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
      
        
                        
        }

     document.querySelector(".form1").onsubmit = function(){
        let form = document.querySelector(".form1")
        let body = document.querySelector("#body1")
        addItems(form, body, 1)
        return false;
     }
     document.querySelector(".form2").onsubmit = function(){
        let form = document.querySelector(".form2")
        let body = document.querySelector("#body2")
        addItems(form, body, 2)
        return false;
     }
     document.querySelector(".form3").onsubmit = function(){
        let form = document.querySelector(".form3")
        let body = document.querySelector("#body3")
        addItems(form, body, 3)
        return false;
     }

    var buttons = document.querySelectorAll(".btn-close")
    for(i=0; i<buttons.length; i++){
        buttons[i].onclick = e => {
            deleteItem(e)

        }
    }




           
    </script>


</body>
</html>