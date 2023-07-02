<?php
    session_start();


	// Check if user already logged in 
	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		header("Location: taskboard.php");
	}

    // Check if user submitted form
	if (isset($_POST['email']) && isset($_POST['password'])) {
		// Form submitted

		if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
			// Missing values
			echo '<script>alert("please enter a email and password")</script>';
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
                echo $mysqli->connect_error;
                exit();
            }

            $mysqli->set_charset('utf8');
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users 
                WHERE '$email' = users.email
                LIMIT 1";

            $results = $mysqli->query($sql);

            if (!$results) {
                
                echo $mysqli->error;
                $mysqli->close();
                exit();
            }

            $user = $results->fetch_assoc();
            $mysqli->close();
            if($user == NULL){
            // Invalid credentials
            echo '<script>alert("Invalid username or password.")</script>';
            }
            else{
                $username = $user["username"];
                $user_id = $user["user_id"];

                // Valid credentials
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION["user_id"] = $user_id;
    
        
                
                header("Location: taskboard.php");
            }

            



        }  

	}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="log into your account for TODO-Board to access your board. If you don't have an account, make a new one in the register page" >

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
                <h1>Hello Again!</h1>
                <h6>We're exited to see your progress!</h6>
            </div><!-- col12-->
        </div> <!--row-->
        <div class="row justify-content-center">
            <div class="col-11">
                <form id="signup-form" action="login.php" method="POST">
                    <div class="form-group row">
                        <label for="email" class="form-label ">Email</label>
                        <div class="col-12">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="asdf@usc.edu" id="email" required>
                            <small id="email-error" class="form-text text-danger"></small>
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
                            <button type="submit" class="btn btn-primary btn-lg w-100">Log In</button>
                        </div> <!-- .col -->
                    </div> <!-- .form-group -->
                </form><!-- form-->
                <div class="row swap_group">
                    <div class="col-12">
                        <p>Need an account?  <a href="register.php">Register</a></p>
                    </div>
                </div>
            </div> <!--col-->
        </div> <!--row-->

    </div><!--container-->





</body>
</html>