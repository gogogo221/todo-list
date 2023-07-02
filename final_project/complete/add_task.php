<?php 
    session_start();
    header("Content-Type: application/json");

    // Check if user already logged in 
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
		$response_array = array("status"=>'user not logged in');  
        echo json_encode($response_array);
	}
    else if(!isset($_POST["task"]) || trim($_POST['task']) == ""){
        $response_array = array("status"=>'missing forum values');  
        echo json_encode($response_array);
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
            $response_array = array("status"=>$mysqli->connect_error);
            echo json_encode($response_array);
			exit();
		}

        $mysqli->set_charset('utf8');

        $user_id = $_SESSION["user_id"];
        $name = $_POST['task'];
        $priority = $_POST['priority'];
        $category_id = $_POST["category"];

        $sql = "INSERT INTO tasks (user_id, name, priority, category_id)
                VALUES ($user_id, '$name', '$priority', $category_id);";
        
        $results = $mysqli->query($sql);

        if (!$results) {
            $response_array = array("status"=>$mysqli->error);
            echo json_encode($response_array);
			$mysqli->close();
			exit();
		}
        $sql="SELECT tasks.task_id FROM tasks
        WHERE tasks.user_id = $user_id
        AND '$name' = tasks.name
        AND '$priority' = tasks.priority
        AND $category_id = tasks.category_id;";

        $results = $mysqli->query($sql);

        if (!$results) {
            $response_array = array("status"=>$mysqli->error);
            echo json_encode($response_array);
			$mysqli->close();
			exit();
		}

        $id = $results->fetch_assoc()["task_id"];

        $response_array = array("status"=>'success', 
                                "task_id"=>$id);
        echo json_encode($response_array);
        $mysqli->close();
    }


?>