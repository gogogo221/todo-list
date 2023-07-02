<?php 

    header("Content-Type: application/json");
    if(!isset($_POST["email"]) || trim($_POST['email']) == ""
    || !isset($_POST["username"]) || trim($_POST['username']) == ""
    || !isset($_POST["password"]) || trim($_POST['password']) == ""){
        $response_array = array("status"=>'missing required form values');  
        echo json_encode($response_array);
	}
    else {
        $host = "303.itpwebdev.com";
		$user = "nchan103_db_user";
		$pass = "itp303webdev";
		$db = "nchan103_taskboard";

        // Establish MySQL Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
	
		// Check for any Connection Errors.
		if ( $mysqli->connect_errno ) {
            $response_array = array("status"=>$mysqli->connect_error);
            echo json_encode($response_array);
			exit();
		}
        $mysqli->set_charset('utf8');
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO users (email, username, password) 
                VALUES ('$email', '$username', '$password');";

        $results = $mysqli->query($sql);

        if (!$results) {
            $response_array = array("status"=>$mysqli->error);
            echo json_encode($response_array);
			$mysqli->close();
			exit();
		}
        $response_array = array("status"=>'success');
        echo json_encode($response_array);
        $mysqli->close();

    }
    

?>