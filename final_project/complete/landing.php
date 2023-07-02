<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="TODO-Board is a website for all your task management needs. Using TODO-Board, you can keep track of all the tasks you need to finish and their priorities. Categorize tasks by their completion into either todo, in-progress, and finished." >
    <title> assignment 5 forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="general.css">

<style>


    #header{
        height: 250px;
        background-color: black;


    }

    h1{
        text-align: center;
        
    }
    .no-gutters{
        padding-right: 0;
        padding-left: 0;
    }
    #body{
        background-color: lavender;
    }
    #left-col{
        padding-top: 20px;
        background-color: rgb(48, 48, 48);


    }
    #right-col{
        background-color: rgb(48, 48, 48);
    }
    #task-graphic{
       width: 100%;
       height: auto;
       margin: 10px;
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
                        <a class="nav-link active" href="register.php">Register</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link active" href="login.php">Sign In</a>
                      </li>

                    </ul>
                </div>
              </nav>
   

    <div  class="container-fluid">
        <div class="row no-gutters">
            <div class="col-12 no-gutters w-100">
                <div id="header" class=" d-flex flex-column justify-content-center align-items-center">
                    <h1 class="">WELCOME TO TODO-BOARD</h1>
                </div><!--header-->
            </div><!--col-->
        </div> <!--row-->


        <div id="body" class="row justify-content-center">
            <div id="left-col" class="col-6  text-center">
                <div class="row h-50 top-text">
                    <div class="col-11">
                    
                        <h2>Prioritize your tasks based on their importance and keep track of their completion status</h2>
                    </div><!--col-->
                </div><!--row-->

                <div class="row ">
                    <div class="col-11">
                        <h3>Just create an account to get started!</h3>
                    </div><!--col-->
                </div><!--row-->

                <div class="row h-25">
                    <div class="col-12 ">
                        <button type="button" class="btn btn-primary btn-lg w-50 register-button">Register Here</button>
                    </div><!--col-->
                </div><!--row-->

                <div class="row h-25">
                    <div class="col-11">
                        <h5>Already have an account? Log in <a href="login.php">here</a> </h5>
                    </div><!--col-->
                </div><!--row-->

            </div><!--left col-->

            <div id="right-col" class="col-6">
               <div class="row justify-content-center">
                    <div class="col-10">
                        <img id="task-graphic" src="img/task.jpg" alt="task board graphic">
                    </div><!--col10-->
               </div><!--row-->
            </div><!--right col-->

        </div><!--body-->
    </div> <!--container-fluid-->

    <script>
        document.querySelector(".register-button").onclick = function(){
            window.location.href = "register.php"
        }
           
    </script>


</body>
</html>