<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();

		//$this->checkSession();
	}

	function checkSession() {

		// echo $this->uri->segment(1) . "<br>";

		if($this->uri->segment(1)!='login'){
				if ($this->session->userdata('person_id')=='') {
					header('Location: '.base_url("login"));
				}
		} else {
			if($this->session->userdata('person_id')!=''){
				header('Location: '.base_url("home"));
			}
		}
	}

	public function index()
	{
		$this->load->view('pages/index');

	}

	public function login()
	{
		$this->load->view('pages/index');

	}

	public function home()
	{
		$data['view'] =  "home";
		$data['head'] = array(
			"title"         =>  "Home | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function roomSchedule()
	{
		$data['view'] =  "room-schedule";
		$data['head'] = array(
			"title"         =>  "Room Attendance | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function submittedRequests()
	{
		$data['view'] =  "submitted-requests";
		$data['head'] = array(
			"title"         =>  "My Requests | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function addRequests()
	{
		$data['view'] =  "add-request";
		$data['head'] = array(
			"title"         =>  "Add Make Up Requests | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function timeLogs()
	{
		$data['view'] =  "time-logs";
		$data['head'] = array(
			"title"         =>  "Time Logs | Attendance Monitoring System",
			);
		$data['faculty'] = json_decode(json_encode($this->Custom_model->get_all_users()), true);
		$this->load->view('layouts/template', $data);
	}

	public function timeLogsUser()
	{
		$data['view'] =  "time-logs-user";
		$data['head'] = array(
			"title"         =>  "My Time Logs | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function substituteProfessor()
	{
		$data['view'] = 'substitute';
		$data['head'] = array(
			"title" =>  "View Schedule | Attendance Monitoring System",
		);
		$data['faculty'] = json_decode(json_encode($this->Custom_model->get_all_users()), true);
		$this->load->view('layouts/template', $data);
	}

	public function substituteForStaff() {
		$data['view'] = 'substitute_staff';
		$data['head'] = array(
			"title" =>  "View Schedule | Attendance Monitoring System",
		);
		$data['faculty'] = json_decode(json_encode($this->Custom_model->get_all_users()), true);
		$this->load->view('layouts/template', $data);
	}

	public function changePassword()
	{
		$data['view'] =  'change-password';
		$data['head'] = array(
			"title"         =>  "Change Password | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function accountManagement()
	{
		$data['view'] =  'account-management';
		$data['head'] = array(
			"title"         =>  "Account Management | Attendance Monitoring System",
			);
		$this->load->view('layouts/template', $data);
	}

	public function logout() {
		$this->session->sess_destroy();
		header('Location: '.base_url());
	}

	public function viewRequest()
	{
		$data['view'] =  "view-request";
		$data['head'] = array(
			"title" =>  "View Request | Attendance Monitoring System",
		);
		// $data['faculty'] = json_decode(json_encode($this->Custom_model->get_all_users()), true);
		$this->load->view('layouts/template', $data);
	}

	//03-20-2020
	public function submitRequest() {
		$results = $this->input->post();

		// print("<pre>".print_r($results,true)."</pre>");
		// $date = '05/15/2020';

		$date = $results["date"];
        $timestamp = strtotime($date);
        $day = intval(date('w', $timestamp)) + 1;
        $is_schedule_taken = FALSE;
        $room_id = intval($results['room']) + 1;
        $start_time = $results['time_from'];
        $end_time = $results['time_to'];
        $all_schedules = $this->Custom_model->get_all_schedule_by_day($day);
        $input_time_range = $this->find_range_inclusive($start_time, $end_time);
        $current_schedules = array();

        // print("<pre>".print_r($all_schedules,true)."</pre>");
        foreach($all_schedules as $candidate_schedule) {
        	
        	if($candidate_schedule->type_id == 2 && ( $candidate_schedule->status_id == 1 || $candidate_schedule->status_id == 2 ) ) {

        		$request_date = new DateTime($date);
        		$schedule_date = new DateTime($candidate_schedule->request_date);

        		if( $request_date == $schedule_date ) {
        			array_push($current_schedules, $candidate_schedule);
        		}
        		
        	}elseif($candidate_schedule->type_id == 1) {
        		array_push($current_schedules, $candidate_schedule);
        	}
        }
        
        

        // echo '<br>day: ' . $day . "<br>";
        // $room_id = '1';
        // $start_time = '9:00';
        // $end_time = '9:30';
        // print("current schedules: <pre>".print_r($input_time_range,true)."</pre>");

        foreach($current_schedules as $schedule) {
        	
        	if( $room_id == $schedule->room_id ) {
        		// print("<pre>".print_r($schedule,true)."</pre>");
        		$schedule_time_range = $this->find_range_exclusive( $schedule->start_time, $schedule->end_time );
        		if( !empty(array_intersect($input_time_range, $schedule_time_range)) ) {
        			$is_schedule_taken = TRUE;
        			break;
        		}        		
        	}
        }





        if( $is_schedule_taken ) {
	        $data = array('message' => 'Sorry. Your chosen schedule is already taken. Please choose another schedule. ', 'type' => 'taken');
	        // $data = array('message' => $room_id, 'type' => 'taken');
        }else{
        	$schedule_data = [
				"person_id" => $this->session->userdata('person_id'),
				"room_id" => $room_id,
				"course_id" => intval($results["course"])+1,
				"section_id" => intval($results["section"]) + 1,
				"type_id" => 2,
				"start_time" => $start_time,
				"end_time" => $end_time,
				"day" => $day
			];

			$schedule_insert = $this->Global_model->insert_data('schedule', $schedule_data);

			$request_data = [
				"schedule_id" => $schedule_insert,
				"status_id" => 1,
				"request_date" => $date
			];

			// print("<pre>".print_r($schedule_data,true)."</pre>");
			// print("<pre>".print_r($request_data,true)."</pre>");
			
			$request_insert = $this->Global_model->insert_data('make_up_requests', $request_data);

			if($request_insert) {
				$data = array( 'message' => 'Success! New Make Up Request Added.', 
									'type' => 'success' );
			}else{
				$data = array( 'message' => 'Success! New Make Up Request Added.', 'type' => 'error' );
			}

			
        }


		print_r(json_encode($data));

       //  $input_time_test_cases = array( 
       //  							array('8:30','9:00', FALSE),
       //  							array('9:00','9:30', FALSE),
       //  							array('9:30','10:00', TRUE),
       //  							array('8:00','10:00', TRUE),
       //  							array('10:00','11:00', TRUE),
       //  							array('10:30','12:00', FALSE),
       //  							array('10:00','10:00', TRUE),
       //  							array('9:30','10:30', TRUE),
       //  						 ); 
        

       //  // test cases
       //  $schedule_start_time = '9:30:00';
       //  $schedule_end_time = '10:30:00';

       //  echo '<br>&nbsp;&nbsp;&nbsp;scheduled start time: ' . $schedule_start_time . '<br>&nbsp;&nbsp;&nbsp;scheduled end time: ' . $schedule_end_time . '<br><br>'; 

       //  foreach( $input_time_test_cases as $input_time_test_case ) {
       //  	$test_is_schedule_taken = FALSE;
       //  	$test_case_start_time = $input_time_test_case[0];
       //  	$test_case_end_time = $input_time_test_case[1];

       //  	$test_case_time_range = $this->find_range_inclusive($test_case_start_time, $test_case_end_time);
       //  	$schedule_time_range = $this->find_range_exclusive($schedule_start_time, $schedule_end_time);

       //  	echo '&nbsp;&nbsp;&nbsp;test case start time: ' . $test_case_start_time . '<br>&nbsp;&nbsp;&nbsp;test case end time: ' . $test_case_end_time;
       //  	print("<br>Interset: <pre>".print_r(array_intersect($test_case_time_range, $schedule_time_range),true)."</pre>");
        	
       //  	if( !empty(array_intersect($test_case_time_range, $schedule_time_range)) ) {
    			// $test_is_schedule_taken = TRUE;
       //  	}

       //  	if($test_is_schedule_taken) {
       //  		echo '<br>&nbsp;&nbsp;Schedule is TAKEN' . '<br>';
       //  	}else {
       //  		echo '<br>&nbsp;&nbsp;&nbsp;Schedule is FREE'.'<br>';
       //  	}

       //  	if($input_time_test_case[2] == $test_is_schedule_taken) {
       //  		echo '&nbsp;&nbsp;&nbsp;TEST <font color="green">PASS</font><br>'; 
       //  	}else{
       //  		echo '&nbsp;&nbsp;&nbsp;TEST <font color="red">FAIL</font><br>'; 
       //  	}
       //  	echo '<br>';
       //  }


	}

	private function find_range_exclusive($time1, $time2) {

		if(strtotime($time1) == strtotime($time2)) return array(strtotime($time1));

		$range = array();
		$next_time = strtotime('+30 minutes',strtotime($time1));
		array_push($range, $next_time);

		while( $next_time < strtotime($time2) ) {
			array_push($range, $next_time);
			$next_time = strtotime('+30 minutes',$next_time);
		}


		return $range;

    }


	private function find_range_inclusive($time1, $time2) {

		if(strtotime($time1) == strtotime($time2)) return array(strtotime($time1));

		$range = array();
		array_push($range, strtotime($time1));
		$next_time = strtotime('+30 minutes',strtotime($time1));
		array_push($range, $next_time);

		while( $next_time < strtotime($time2) ) {
			array_push($range, $next_time);
			$next_time = strtotime('+30 minutes',$next_time);
		}

		array_push($range, strtotime($time2));
		return $range;

    }


}
