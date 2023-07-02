<?php 

    header("Content-Type: application/json");
    if(!isset($_POST["email"]) || trim($_POST['email']) == ""
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
        $password = $_POST['password'];

        $sql = "SELECT * FROM users 
                WHERE $email = users.email
                LIMIT 1";

        $results = $mysqli->query($sql);
        
        if (!$results) {
            $response_array = array("status"=>$mysqli->error);
            echo json_encode($response_array);
			$mysqli->close();
			exit();
		}
        $user = $results->fetch_assoc();
        
        session_start();
        $_SESSION['logged_in'] = true;
		$_SESSION['username'] =  $user['username'];

        $response_array = array("status"=>'success');

        echo json_encode($response_array);
        $mysqli->close();

    }
    

?>