<?php 

$servername = "localhost";
$username = "uhtgkekzke";
$password = "Password1"; 
$database = "uhtgkekzke";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$insert_logs_event = "INSERT INTO `logs` (person_id, schedule_id, log_date) Select person_id, schedule_id, CURRENT_DATE FROM `schedule` s where s.day = DAYOFWEEK(CURRENT_DATE)";
$insert_logs_from_requests_event = "INSERT Into `logs` (person_id, schedule_id, log_date)
									Select person_id, s.schedule_id, CURRENT_DATE from `schedule` s INNER JOIN `make_up_requests` mur on s.schedule_id = mur.schedule_id 
									where mur.request_date = CURRENT_DATE AND mur.status_id = 2";

if(mysqli_query($conn, $insert_logs_event)){

} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

if(mysqli_query($conn, $insert_logs_from_requests_event)){

} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);




?>