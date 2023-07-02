

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Register for a new user account here! Once you have an account, you will be able to create a new task board and organize your work." >

    <title> assignment 5 forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="general.css">
<style>

    #form-result{
        visibility: hidden;
    }

    .container{
        margin-top: 100px;
        
        width: 650px;
        height: 550px;
        border: 3px solid white;
        background-color: rgb(59, 59, 59);
        border-radius: 5px;

    }
    h1{
        text-align: center;
        margin-top: 30px;
    }
    h6{
        text-align: center;
        margin-top:5px;
        margin-bottom: 15px;
    }


    #out{
        padding: 0px;

    }
    #button_group{
        margin-top: 20px;
    }
    .form-group{
        margin-top: 10px;
    }
    .swap_group{
        margin-top: 15px;
    }


</style>
</head>

<body>

    <div class="container col-9">

        <div class="row justify-content-center">
            <div class="col-12">
                <h1>Create an account</h1>
            </div><!-- col12-->
        </div> <!--row-->
        <div class="row justify-content-center">
            <div class="col-11">
                <form id="signup-form">
                    <div class="form-group row">    
                        <label for="email" class="form-label ">Email</label>
                        <div class="col-12">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="asdf@usc.edu" id="email" required>
                            <small id="email-error" class="form-text text-danger"></small>
                        </div> <!-- col sm 10-->
                    </div><!-- form-group -->

                    <div class="form-group row">
                        <label for="username" class="form-label ">Username</label>
                        <div class="col-12">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Tommy" id="username" required>
                            <small id="username-error" class="form-text text-danger"></small>
                        </div> <!-- col sm 10-->
                    </div><!-- form-group -->
    
                    <div class="form-group row">
                        <label for="password" class="form-label col-form-label">Password</label>
                        <div class="col-12">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" id="password" required>
                            <small id="password-error" class="form-text text-danger"></small>
                        </div> <!-- col sm 10-->
                    </div><!-- form-group -->
    
                    <div id="button_group" class="form-group row justify-content-center">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100" >Register</button>
                        </div> <!-- .col -->
                    </div> <!-- .form-group -->
                </form><!-- form-->
                <div class="row swap_group">
                    <div class="col-12 ">
                        <p>already have an account? <a href="login.php">Log in.</a></p>
                    </div>
                </div>




            </div> <!--col-->
        </div> <!--row-->

    </div><!--container-->


   
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>


        document.querySelector("#signup-form").onsubmit = function(){
            //TODO QUERY DATABASE TO SEE IF USER EXISTS AND ERROR IF IT DOESN'T
            const form = document.querySelector("#signup-form")
            var formData = {
                email: document.querySelector("#email").value.trim(),
                username: document.querySelector("#username").value.trim(),
                password: document.querySelector("#password").value.trim()
            }
            $.ajax({
                url: "register_confirmation.php",
                type: "POST", 
                data: formData,
                dataType: "text",
                success: function (data){
                    const data_obj = JSON.parse(data)
                    console.log(data_obj)

                    if(data_obj.status == "success"){
                        alert("account creation successful!")
                        document.location.href = "login.php"
                        return true
                    }
                    else{
                        error_message =data_obj.status
                        if(error_message.search(/Duplicate/) != -1){
                            alert("there is already an account with this email")
                        }
                        else{
                            alert(error_message)
                        }
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
            return false
        }
           
    </script>


</body>
</html>