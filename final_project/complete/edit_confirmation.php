<?php 
    session_start();
    header("Content-Type: application/json");

    // Check if user already logged in 
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
		$response_array = array("status"=>'user not logged in');  
        echo json_encode($response_array);
	}
    else if(!isset($_POST["task"]) || trim($_POST['task']) == ""
          ||!isset($_POST["task_id"]) || trim($_POST['task_id']) == ""
          ||!isset($_POST["category"]) || trim($_POST['category']) == ""){
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
        $task_id = $_POST['task_id'];

        $sql = "UPDATE tasks
                SET tasks.name = '$name',
                tasks.priority = '$priority',
                tasks.category_id = $category_id
                WHERE $task_id = tasks.task_id;";
        
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