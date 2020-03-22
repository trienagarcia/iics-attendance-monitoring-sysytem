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
			"title"         =>  "Substitute Professor | Attendance Monitoring System",
			);
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

		$date = $results["date"];
        $timestamp = strtotime($date);
        $day = intval(date('w', $timestamp)) + 1;

		$schedule_data = [
			"person_id" => $this->session->userdata('person_id'),
			"room_id" => $results["room_id"],
			"course_id" => $results["course"],
			"section_id" => $results["section"],
			"type_id" => 2,
			"start_time" => $results["start_time"],
			"end_time" => $results["end_time"],
			"day" => $day
		];

		$schedule_insert = $this->Global_model->insert_data('schedule', $schedule_data);

		$request_data = [
			"schedule_id" => $schedule_insert,
			"status_id" => 1,
			"request_date" => $date
		];

		print("<pre>".print_r($schedule_data,true)."</pre>");
		print("<pre>".print_r($request_data,true)."</pre>");
		
		$request_insert = $this->Global_model->insert_data('make_up_requests', $request_data);

		redirect("HomeController/submittedRequests"); 
	}
}
